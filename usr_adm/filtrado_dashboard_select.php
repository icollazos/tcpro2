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
	if($c=='id' OR substr($c, 0,2)!='id' ){
		$camposInternos[]=$c;
	}
}
//$camposInternos=explode(",", "id,descriptor,fechaHora,fecha,apellido,nombre,cedula,telefono,nucleoFamiliar");
foreach ($camposInternos as $key => $value) {
	$segmentoInterno.="$estaVista.$value as $value, ";
}
$segmentoInterno=substr($segmentoInterno, 0, -2);

foreach ($camposExternos['key'] as $key => $value) {
	$segmentoExterno.=", $estaVista.id_$value as id_$value, ";
	$segmentoExterno.="$estaVista.descriptor_$value as descriptor_$value, ";
}
$segmentoExterno=substr($segmentoExterno, 0, -2);
/*
$segmentoExterno.="$estaVista.id_municipio_parroquia as id_municipio_parroquia, ";
$segmentoExterno.="$estaVista.descriptor_municipio_parroquia as descriptor_municipio_parroquia, ";
*/
$sql ="SELECT $segmentoInterno $segmentoExterno FROM $estaVista $clausulaFecha $clausulaWhere ORDER BY id DESC LIMIT 0,500";
/*
$json=json_encode($sql);
echo $json;
die();
*/
$tabla=array();
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	$i=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			foreach ($row as $key => $value) {
				$clave=$key;
				if( substr($key, 0,11)=='descriptor_' AND substr($key, -1*(strlen($esteAmbito)))==$esteAmbito ){
					$clave=trim(substr($key, 11, 1000) );
					$clave=substr($clave, 0, (strlen($clave) - strlen($esteAmbito) -1 ));
				}
				if(substr($clave, 0, 3)!='id_'){
					$registro[$clave]=$value;
				}
				$tablaModal ='
				<table class="table table-hover" style="margin-bottom:0px;">
				<tbody>';
				foreach ($row as $key => $value) {
					if(substr($key, 0,3)!='id_'){
						$tablaModal.='<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
					}
				}
				$tablaModal.='</tbody></table>';
				$modalVer ='
				<form>
				<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal_'.$i.'">Ver
				</button>
				</form>';
				$modalVer.='
				<div class="modal fade" id="modal_'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				<div class = "modal-content"> 
				<div class="modal-header bg-info">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Libro:&nbsp;'.$row['idLibro'].' '.$row['Libro'].'</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label = "Close"></button> 
				</div>
				<div class="modal-body">'.$tablaModal.'
				</div>
				<div class="modal-footer"> 
				<form method="post" action="buscadorLibros.php">
				<input type="hidden" name="from" value="consulta_filtrada.php?esteAmbito="'.$esteAmbito.'">
				<input type="hidden" name="idLibro" value="'.$row['idLibro'].'"/>
				<input type="hidden" name="accion" value="nuevoFavorito"/>
				<input type="hidden" name="idUsuario" value="'.$idUsuario.'"/>
				<button type="submit" class="btn btn-success btn-sm">Agregar a mis favoritos
				</button>
				</form>
				<button type="button" class="btn btn-primary btn-sm" data-bs-dismiss = "modal"> Salir 
				</button> 
				</div> 
				</div> 
				</div> 
				</div>';
				$modalEliminar='
				<form action="crudD.php" method="get">
				<input type="hidden" name="from" value="consulta_filtrada.php?esteAmbito='.$esteAmbito.'">
				<input type="hidden" name="tabla" value="'.$estaTabla.'">
				<input type="hidden" name="idRegistro" value="'.$row['id'].'">
				<button type="submit" class="btn btn-danger btn-sm">Borrar</button>
				</form>
				';
				$modalEditar='
				<form action="crudCU.php" method="POST">
				<input type="hidden" name="from" value="consulta_filtrada.php?esteAmbito='.$esteAmbito.'">
				<input type="hidden" name="tabla" value="'.$estaTabla.'">
				<input type="hidden" name="idRegistro" value="'.$row['id'].'">
				<button type="submit" class="btn btn-warning btn-sm">Editar</button>
				</form>';
				$modalDocumentos='
				<form action="documentacion.php" method="get">
				<input type="hidden" name="from" value="consulta_filtrada.php?esteAmbito='.$esteAmbito.'">
				<input type="hidden" name="view" value="'.$estaTabla.'">
				<input type="hidden" name="idRegistro" value="'.$row['id'].'">
				<button class="btn btn-info btn-sm" onclick="this.form.submit();">Ver</button>
				</form>
				';
				$i==0 ? $mensaje=$sql : $mensaje='' ;
				$mensaje='';
				foreach ($registro as $keyRegistro => $valueRegistro) {
					$tabla['data'][$i][$keyRegistro]=$valueRegistro;//.' '.$sql;
					# code...
				}
				$tabla['data'][$i]['return']=$registro;
				$tabla['data'][$i]['btn_ver']=$modalVer;
				$tabla['data'][$i]['btn_eliminar']=$modalEliminar;
				$tabla['data'][$i]['btn_editar']=$modalEditar;
				$tabla['data'][$i]['btn_documentos']=$modalDocumentos;
				$tabla['argumentos']=$arg;
				$tabla['sql']=$sql;
				$tabla['where']=$clausulaWhere;
				$tabla['ap']=$ap;
			}
			#p(1,"RERERERERER");
			#p(1,$registro);
			$i++;
		}
	} 
	$result->close();
} 
$json=json_encode($tabla);
echo $json;
die();
