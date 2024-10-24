<?

//inicializando
include('../000_conexion.php');
session_start();
unset($_SESSION['salida']); ##salida del generador
$P=0; //define si los pre se ven o no

$arg=$_POST['argumentos'];
$esteAmbito=$arg['esteAmbito'];
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;

$seccion="principal";

$campoTotalizacion=$arg['campoTotalizacion'];


$mysqli=conectar($datosConexion);
$idUsuario=$_SESSION['fvp']['idUsuario'];
$tipoBusqueda=' OR  ';
if(isset($arg['tipoBusqueda'])){
	$tipoBusqueda=$arg['tipoBusqueda'];
	if($tipoBusqueda=='O'){
		$tipoBusqueda=" OR  ";
	} else {
		$tipoBusqueda=" AND ";
	}
};

$clausulaFecha=' WHERE ';
if(isset($arg['anoInicio']) AND isset($arg['anoFinal']) AND isset($arg['mesInicio']) AND isset($arg['mesFinal']) ){
	$anoInicio=$arg['anoInicio']; 
	$mesInicio=$arg['mesInicio']; 
	$anoFinal=$arg['anoFinal'];
	$mesFinal=$arg['mesFinal'];
	$fechaInicio=$anoInicio.'/'.$mesInicio;
	$fechaFinal=$anoFinal.'/'.$mesFinal;
	$clausulaFecha=" WHERE $estaVista.fecha >= '$fechaInicio' AND $estaVista.fecha <= '$fechaFinal' ";
}


$q=0;
$longAmbito=strlen($esteAmbito);
$q=0;
foreach ($arg as $key => $value) {
	if( substr($key, 0, 2)=='id'){
		$k.= $key.' ';
		$camposExternos[$q]['key']=$key;
		$camposExternos[$q]['ref']='id'.substr($key, 5,1000).'_'.$esteAmbito;
		$camposExternos[$q]['ref']=$key;
		$q++;
	}
}
/*
p($P,json_encode($camposExternos));
die();
*/
//$camposExternos=explode(",", "socialTipoActividad_social,socialEstatus_social,socialEnte_social,socialPsuv_social,socialNuevoVotante_social,socialDiscapacidad_social,socialVota_social");
//$camposExternos=explode(",", "socialTipoActividad_social,socialEstatus_social,socialEnte_social,socialPsuv_social,socialNuevoVotante_social,socialDiscapacidad_social,socialVota_social");
foreach ($camposExternos as $key => $value) {
	if(count($arg[$value['key']]>0)){
		$c=' ( '.$estaVista.'.'.$value['ref'].' = '.implode(" OR $estaVista.".$value['ref'].' = ', $arg[$value['key']] ).' ) ';
		$ap .= $c .  $tipoBusqueda ;
	};
}
if(strlen($ap)>0){
	$ap=' AND ( '.substr($ap, 0,-7).') )';
}

$id=1;
$whereBase='';
$clausulaWhere=" AND $estaVista.id>1 ".$ap;	

/*
$json=json_encode($clausulaWhere);
echo $json;
die();
*/


$id=2;
if($_POST['id']!=''){
	$id=$_POST['id'];
};



$sql = "SHOW COLUMNS FROM v_$estaTabla";
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if(substr($c, 0,2)!='id' ){
		$campos[]=$c;
	}
}


//$camposInternos=explode(",", "id,descriptor,fechaHora,fecha,apellido,nombre,cedula,telefono,nucleoFamiliar");
$tabla=array();
$rechazo=rechazos(basename($_SERVER['PHP_SELF']));

foreach ($campos as $key => $value) {
	if(in_array($value, $rechazo)){
		unset($campos[$key]);
	}
}

foreach ($campos as $campo) {

	$campoTotalizacion=='id'? $clausulaTotalizacion="count($campoTotalizacion)" : $clausulaTotalizacion="sum($campoTotalizacion)";
	$sql="SELECT $campo as Campo, $clausulaTotalizacion as Cuenta FROM $estaVista $clausulaFecha $clausulaWhere GROUP BY Campo ORDER BY Cuenta DESC ";
	$sql2.=$sql;
	if ($result = $mysqli->query($sql)) {
		$i=0;
		if ($result->num_rows> 0){
			$q=0;
			while ($row = $result->fetch_assoc()){
				foreach ($row as $key => $value) {
					$tabla[$campo]['Titulo']=$campo;
					if( $q<12){
						$tabla[$campo]['data'][$row['Campo']]=(int)$row['Cuenta'];
						$q++;
					} else {
						$tabla[$campo]['Otros']+=$row['Cuenta'];
					}
					$tabla[$campo]['Total']+=$row['Cuenta'];
				}
				if($tabla[$campo]['data']['Otros']==0){
					unset($tabla[$campo]['data']['Otros']);
				}
			}
		} 
		$result->close();
	} 
}
/*
j($sql2);
$json=json_encode($sql2);
echo $json;
die();
*/




$json=json_encode($tabla);
echo $json;
die();
