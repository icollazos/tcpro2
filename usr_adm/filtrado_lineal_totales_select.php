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
$campoTotalizacion=='id'? $clausulaTotalizacion="count($campoTotalizacion)" : $clausulaTotalizacion="sum($campoTotalizacion)";

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

if(isset($arg['anoInicio']) ){ $anoInicial=$arg['anoInicio']; } else { $anoInicial='2019';}
if(isset($arg['mesInicio']) ){ $mesInicial=$arg['mesInicio']; } else { $mesInicial='01/01';}
if(isset($arg['anoFinal']) ){ $anoFinal=$arg['anoFinal']; } else { $anoFinal='2030';}
if(isset($arg['mesFinal']) ){ $mesFinal=$arg['mesFinal']; } else { $mesFinal='12/31';}

$fechaInicial=$anoInicial.'/'.$mesInicial;
$fechaFinal=$anoFinal.'/'.$mesFinal;

$clausulaFecha=" WHERE $estaVista.fecha >= '$fechaInicial' AND $estaVista.fecha <= '$fechaFinal' ";




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


$tabla=array();
$rechazo=rechazos(basename($_SERVER['PHP_SELF']));
foreach ($campos as $key => $value) {
	if(in_array($value, $rechazo) OR substr($value, 0,3)=='id_'){
		unset($campos[$key]);
	}
}
sort($campos);

/*
$json=json_encode($campos);
echo $json;
die();
*/

$agrupamientoFechas='anos';
$agrupamientoFechas='semanas ';
$agrupamientoFechas='dias';
$agrupamientoFechas='meses';

$ag['dias']='Y-n-j';
$ag['meses']='Y-n';
$ag['semanas']='W';
$ag['anos']='Y';

$formatoFecha=$ag[$agrupamientoFechas];

$agSql['dias']		=	" fecha ";
$agSql['meses']		=	" CONCAT(YEAR(fecha),'-',MONTH(fecha)) ";
$agSql['semanas']	=	" CONCAT(YEAR(fecha),'-',WEEK(fecha)) ";
$agSql['anos']		=	" CONCAT(YEAR(fecha)) ";

$fechaSql=$agSql[$agrupamientoFechas];


$sql="SELECT min(fecha) as fechaInicial FROM $estaVista $clausulaFecha $clausulaWhere; ";
	//j($sql);
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				$fechaInicial=trim($row['fechaInicial']);
			}
		}
	} 
	$result->close();
} 
$sql="SELECT max(fecha) as fechaFinal FROM $estaVista $clausulaFecha $clausulaWhere; ";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				$fechaFinal=trim($row['fechaFinal']);
			}
		}
	} 
	$result->close();
}

$categorias = obtenerListaFechas($fechaInicial, $fechaFinal,$formatoFecha);

foreach ($categorias as $cat) {
	$graficos['0']['valores']['Totales']['dataFechas'][$cat]=0;
}

$actual=arrayDesplegableTotales();
$actual=$actual[$esteAmbito];


	$sql="SELECT $fechaSql as Fecha, $clausulaTotalizacion as Cuenta FROM $estaVista $clausulaFecha $clausulaWhere GROUP BY $fechaSql ORDER BY Fecha ASC;";
	//j($sql);
			//$graficos[$campo]['sql'].=$sql;
			if ($result = $mysqli->query($sql)) {
				$i=0;
				if ($result->num_rows> 0){
					$q=0;
					while ($row = $result->fetch_assoc()){
						$graficos['0']['valores']['Totales']['name']="Total General";
						$graficos['0']['valores']['Totales']['dataFechas'][$row['Fecha']]=(int)$row['Cuenta'];
						$q++;
					}
				} 
				$result->close();
			} 
	$graficos['0']['categorias']=$categorias;
	$graficos['0']['campo']="Total General";



/*
$json=json_encode($clausulaWhere);
echo $json;
die();
*/

foreach ($campos as $campo) {

	$graficos[$campo]['campo']=$campo;
	$graficos[$campo]['categorias']=$categorias;

	$sql="SELECT DISTINCT($campo) as Valor FROM $estaVista $clausulaFecha $clausulaWhere ";
	unset($listaValores);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				foreach ($row as $key => $value) {
					$listaValores[]=(string)$row['Valor'];
				}
			}
		} 
		$result->close();
	} 

	$tabla[$campo]['Titulo']=$campo;
	foreach ($listaValores as $valor) {
		foreach ($categorias as $fechaCat) {
			$graficos[$campo]['valores'][$valor]['dataFechas'][$fechaCat]=0;
			# code...
		}
	}

	foreach ($listaValores as $valor) {
		$graficos[$campo]['valores'][$valor]['name']=$valor;
	}

	foreach ($listaValores as $esteValor) {
		$sql="SELECT $campo as Campo, $fechaSql as Fecha, $clausulaTotalizacion as Cuenta FROM $estaVista $clausulaFecha $clausulaWhere AND $campo='$esteValor' GROUP BY Campo, $fechaSql ORDER BY Campo ASC, Fecha ASC; ";
		$graficos[$campo]['sql'].=$sql;
		if ($result = $mysqli->query($sql)) {
			$i=0;
			if ($result->num_rows> 0){
				$q=0;
				while ($row = $result->fetch_assoc()){
					$graficos[$campo]['valores'][$row['Campo']]['name']=$row['Campo'];
					$graficos[$campo]['valores'][$row['Campo']]['dataFechas'][$row['Fecha']]=(int)$row['Cuenta'];
					$q++;
				}
			} 
			$result->close();
		} 
	}
} //campos

foreach ($graficos as $kGrafico=>$vGrafico) {
	foreach ($vGrafico['valores'] as $kCampo=>$vCampo) {
		$graficos[$kGrafico]['valores'][$kCampo]['data']=array_values($graficos[$kGrafico]['valores'][$kCampo]['dataFechas']);
		unset($graficos[$kGrafico]['valores'][$kCampo]['dataFechas']);
	}
}

$json=json_encode($graficos);
echo $json;
die();

/*
$json=json_encode($sql2);
echo $json;
die();
*/

function ceroAntes($x){
	if($x<10){
		$x='0'.$x;
	}
	return $x;
}

function obtenerListaFechas($fechaInicio, $fechaFin,$formatoFecha) {
	
	/*
	$fechaInicio='2024/01/02';
	$fechaFin='2024/03/27';
	$formatoFecha='Y';
	*/

  // Convertir las fechas a objetos DateTime
	$fechaInicioObj = new DateTime($fechaInicio);
	$fechaFinObj = new DateTime($fechaFin);
	$intervalo = new DateInterval('P1D'); // Intervalo de un día

  // Crear un intervalo de fechas
	$periodo = new DatePeriod($fechaInicioObj, $intervalo, $fechaFinObj);
 	//print_r($periodo);

  // Obtener la lista de fechas del periodo
	$listaFechas = array();
	foreach ($periodo as $fecha) {
		$f=$fecha->format($formatoFecha);
		$listaFechas[$f] = $f;
	}
	$listaFechas=array_keys($listaFechas);
	//print_r($listaFechas);
	return $listaFechas;
}

