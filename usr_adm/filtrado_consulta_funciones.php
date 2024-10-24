<?
include('../000_conexion.php');
session_start();
//error_reporting(E_ALL);

unset($_SESSION['salida']); ##salida del generador
$P=1; //define si los pre se ven o no

//include("../000_configurador.php");

// Obtener el cuerpo de la solicitud
$json = file_get_contents('php://input');

header('Content-Type: application/json');
$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
	regresar("No recibi argumentos");
	die();
} else {
	$argumentos = $data ?? null;
	$argumentos=$argumentos['argumentos'];
	$funcionLlamada=$argumentos['funcionLlamada'];
}

/*
$argumentos['idVariable']=2;
$argumentos['seguimiento']=2;
$funcionLlamada='buscaTextos';
*/

//$mysqli=conectar($_SESSION['datosConexion']);
//p(1,$mysqli);


switch ($funcionLlamada) {
	case 'elegirAmbito':
	$z=buscaDatos($argumentos);
	break;	
	case 'cargaSelects':
	$z=cargaSelects($argumentos);
	break;	
	case 'iniciarSelect':
	$z=iniciarSelect($argumentos);
	break;	
	case 'iniciarTablaV':
	$z=iniciarTablaV($argumentos);
	break;	
	case 'ejecutarRobot':
	$z=ejecutarRobot($argumentos);
	break;	
	case 'eliminarTexto':
	$z=eliminarTexto($argumentos);
	break;	
	case 'reiniciarRobot':
	$z=reiniciarRobot($argumentos);
	break;	
	case 'borrarEtiqueta':
	$z=borrarEtiqueta($argumentos);
	break;	
	default:
	$z="No se crearon respuestas válidas";
	break;
}

regresar($z);
die();
function regresar($x){ echo json_encode($x); }
function clausulaCliente($esteAmbito,$para){
	$restriccion=restriccion();
	$cliente=$_SESSION['cliente'];
	foreach ($restriccion as $key => $value) {
		if(in_array($esteAmbito, $restriccion[$key])){
			$parentesco=$key;
		}
	}
	if($para=='select'){
		switch ($parentesco) {
			case 'vertical':
				$z=" WHERE id_cliente_proyecto='$cliente' ";
			break;
			case 'lateral':
				$z=" WHERE id_seguimientoEspejo_variable IN (SELECT v_aaa_seguimiento.id FROM v_aaa_seguimiento WHERE v_aaa_seguimiento.id_cliente_proyecto='$cliente')";
			break;
			case 'ninguna':
				$z=" ";
			break;
		}		
	}
	if($para=='registros'){
		switch ($parentesco) {
			case 'vertical':
				$z=" AND id_cliente_proyecto='$cliente' ";
			break;
			case 'lateral':
				$z=" AND id_seguimientoEspejo_variable IN (SELECT v_aaa_seguimiento.id FROM v_aaa_seguimiento WHERE v_aaa_seguimiento.id_cliente_proyecto='$cliente')";
			break;
			case 'ninguna':
				$z=" ";
			break;
		}		
	}

	return $z;
}
function cargaSelects($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$esteAmbito=$argumentos['esteAmbito'];

	$clausulaCliente=clausulaCliente($esteAmbito,'select');

	$arrayDesplegable=arrayDesplegable();	
	$camposExternos=$arrayDesplegable[$esteAmbito];

	
	$vista='v_aaa_'.$esteAmbito;
	$sql = "SHOW COLUMNS FROM v_aaa_$esteAmbito";
	$resultado = $mysqli->query($sql);
	while ($campoQ = $resultado->fetch_assoc()) { #En esta linea se genera un error debido a que en 000_configurador en el arrau de ambitos se llama a una tabla que no existe
		$c=$campoQ['Field'];
		if($c=='fecha') {
			$fecha=1;
		}
	}
	$sql=array();
	$i=0;

	foreach ($camposExternos as $k=>$v) {
		$campoDescriptor='descriptor'.substr($k, 2,1000);
		$t[$i]['id']=$k;
		$t[$i]['alias']=$v;
		$sql="SELECT DISTINCT($k) as id, $campoDescriptor as value FROM $vista $clausulaCliente";
		$sqla[]=$sql;
		if ($result = $mysqli->query($sql)) {
			if ($result->num_rows> 0){
				$j=0;
				while ($row = $result->fetch_assoc()){
					$t[$i]['options'][$j]['value']=$row['id'];
					$t[$i]['options'][$j]['text']=$row['value'];
					$j++;
				}
			}
			$result->close();
		} else {
			return "ERROR: ".$sql;
		}
		$i++;
	}
	if($fecha){
		$sqlFecha="SELECT DISTINCT(YEAR(fecha)) as fecha FROM $vista ORDER BY fecha ASC"; 
		if ($result2 = $mysqli->query($sqlFecha)) {
			if ($result2->num_rows> 0){
				while ($row = $result2->fetch_assoc()){
					$anos[]=(int) $row['fecha'];
				}
			}
			$result2->close();
		} else {
			return "ERROR: ".$sql;
		}
	}
	$campos['sqlExterno']=$sqla;
	$campos['sqlFecha']=$sqlFecha;
	$campos['internos']=$camposInternos;
	$campos['selects']=$t;
	$campos['anos']=$anos;
	return $campos;
}
function buscaDatos($argumentos){
	#return $argumentos['esteAmbito'];
	$esteAmbito=$argumentos['esteAmbito'];
	$titulos=buscaTitulos($esteAmbito);
	$registros=buscaRegistros($esteAmbito,$titulos, $argumentos);
	$ambito=$argumentos['esteAmbito'];

	$z['titulos']=$titulos;
	$z['error']=$registros['error'];
	$z['registros']=$registros['datos'];
	$z['sql']=$registros['sql'];
	$z['argumentos']=$registros['argumentos'];
	$z['filtros']=$registros['filtros'];
	$z['anos']=$registros['anos'];
	$z['html2Excel']=buscaCompleto($ambito);

	return $z;
}
function buscaCompleto($esteAmbito){
	$mysqli=conectar($_SESSION['datosConexion']);
	$vista='v_aaa_'.$esteAmbito;
	$sql="SELECT * FROM $vista WHERE $vista.id>1";
	#return $sql;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows > 0) {
			$data = [];
			$fieldInfo = $result->fetch_fields();
			$titles = [];
			foreach ($fieldInfo as $field) {
				$titles[] = $field->name; 
			}
			$data[0] = $titles;
			while ($row = $result->fetch_assoc()) {
				$rowData = [];
				foreach ($titles as $title) {
					$rowData[] = $row[$title]; 
				}
				$data[] = $rowData;
			}
			$result->close();
		} else {
			return "No se encontraron resultados.";
		}
	} else {
		return "ERROR: " . $sql;
	}
	foreach ($data as $key => $value) {
		$array2Excel[]=implode("\t", $value);
	}
	$string2Excel=implode("\n", $array2Excel);
	return $string2Excel;
}
function buscaRegistros($esteAmbito, $titulos, $argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$clausulaCampos=implode(", ", $titulos);
	$tipoBusqueda=$argumentos['tipoBusqueda'];
	$vista='v_aaa_'.$esteAmbito;

	foreach ($argumentos as $k=>$v) {
		if(strlen($k)>2 AND substr($k, 0,2)=='id' and $v>0 ){
			$filtros[$k]=$v;
		}
	}
	$clausulaFecha=clausulaFecha($argumentos,$vista);
	$clausulaFiltros=clausulaFiltros($argumentos,$vista,$tipoBusqueda);
	$clausulaKeywords=clausulaKeywords($argumentos,$vista);
	$clausulaExcepcion=clausulaExcepcion($argumentos,$vista);
	$clausulaCliente=clausulaCliente($esteAmbito,'registros');

	$sql="SELECT $clausulaCampos FROM $vista $clausulaFecha $clausulaKeywords $clausulaExcepcion $clausulaFiltros $clausulaCliente AND $vista.id>1 LIMIT 0,500";
	$t['sql']=$sql;
	//return $sql;
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				foreach ($titulos as $key => $value) {
					$t['datos'][$i][$value]=$row[$value];
				}
				$i++;
			}
		}
		$result->close();
	} else {
		$t['error']="ERROR: ".$sql;
		return $t['error'];
	}
	$t['argumentos']=$argumentos; 
	$t['filtros']=$clausulaFiltros; 
	return ($t);
}
function clausulaFecha($argumentos, $vista){
	$clausulaFecha=' WHERE (1=1) ';
	if(isset($argumentos['anoInicio']) AND isset($argumentos['anoFinal']) AND isset($argumentos['mesInicio']) AND isset($argumentos['mesFinal']) ){
		$anoInicio=$argumentos['anoInicio']; 
		$mesInicio=$argumentos['mesInicio'].'/01'; 
		$anoFinal=$argumentos['anoFinal'];
		$mesFinal=$argumentos['mesFinal'].'/31';
		$fechaInicio=$anoInicio.'/'.$mesInicio;
		$fechaFinal=$anoFinal.'/'.$mesFinal;
		$clausulaFecha=" WHERE $vista.fecha >= '$fechaInicio' AND $vista.fecha <= '$fechaFinal' ";
	}
	return $clausulaFecha;
}
function clausulaFiltros($argumentos,$vista,$tipoBusqueda){
	foreach ($argumentos as $k=>$v) {
		if(strlen($k)>2 AND substr($k, 0,2)=='id' and $v>0 ){
			$filtros[$k]=$v;
		}
	}
	$conector= " AND ";
	if($tipoBusqueda=='O') { $conector =' OR  ';	} 
	if(count($filtros)>0){
		$clausulaFiltros = " AND (";
		foreach ($filtros as $key => $value) {
			if($value>0){
				$clausulaFiltros.=" $key='$value' $conector";
			}
		}
		$clausulaFiltros =substr($clausulaFiltros, 0,-4);
		$clausulaFiltros .=" ) ";
	}
	return $clausulaFiltros;
}
function clausulaKeywords($argumentos,$vista){
	$keywords=explode(",",$argumentos['keywords']);
	foreach ($keywords as $key => $value) {
		$kw[]=trim($value);
	}
	$medio = implode("%' OR $vista.descriptor LIKE '%", $kw);
	if($medio!=''){
		$clausulaKeywords="AND ( $vista.descriptor LIKE '%".$medio."%' ) ";
	}
	return $clausulaKeywords;
}
function clausulaExcepcion($argumentos,$vista){
	$excepciones=explode(",",$argumentos['excepto']);
	foreach ($excepciones as $key => $value) {
		$ex[]=trim($value);
	}
	$medio = implode("%' OR $vista.descriptor LIKE '%", $ex);
	if($medio!=''){
		$clausulaExcepcion="AND ( $vista.descriptor NOT LIKE '%".$medio."%' ) ";
	}
	return $clausulaExcepcion;
}
function buscaTitulos($esteAmbito){
	$mysqli=conectar($_SESSION['datosConexion']);
	$sql = "SHOW COLUMNS FROM v_aaa_$esteAmbito";
	$resultado = $mysqli->query($sql);
	$camposExternos2=array();
	while ($campoQ = $resultado->fetch_assoc()) { #En esta linea se genera un error debido a que en 000_configurador en el arrau de ambitos se llama a una tabla que no existe
		$c=$campoQ['Field'];
		$campos[]=$c;
		if($c!='id' AND substr($c, 0,2)=='id' ){
			$camposExternos[]=$c;
		} else {
			if(!in_array($c, array('fechaHora','descriptor'))){
				$camposInternos[]=$c;
			}
		}
	}
	#$campos['externos']=$camposExternos;
	#$campos['internos']=$camposInternos;
	return $campos;
}
function eliminarTexto($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idTexto=$argumentos['idTexto'];
	$sql="DELETE FRoM aaa_texto WHERE id='$idTexto'";
	$i=0;
	if ($result = $mysqli->query($sql)) {} 
		return "Borrado con exito";
}
function iniciarSelect($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idVariable=$argumentos['idVariable'];
	$idTexto=$argumentos['idTexto'];
	$sql="SELECT aaa_valor.id as id, aaa_valor.descriptor as t FROM aaa_valor WHERE idaaa_variable='$idVariable' AND aaa_valor.id NOT IN ( SELECT idaaa_valor FROM aaa_textoValor WHERE idaaa_texto='$idTexto')";
	//return $sql;
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$opciones[$i]['value']=$row['id'];
				$opciones[$i]['text']=$row['t'];
				$i++;
			}
		} 
		$result->close();
	} 
	return $opciones;
}
function limpiar($t){ return $z; }	
function conecta(){
	$datosConexion=$_SESSION['datosConexion']; 
	$mysqli=conectar($datosConexion);
	return $mysqli;
}