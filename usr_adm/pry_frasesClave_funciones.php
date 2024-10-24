<?
include('../000_conexion.php');
session_start();
//error_reporting(E_ALL);

unset($_SESSION['salida']); ##salida del generador
$P=1; //define si los pre se ven o no



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
	case 'buscaTextos':
	$z=buscaTextos($argumentos);
	break;	
	case 'creaTextoValor':
	$z=creaTextoValor($argumentos);
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

function buscaTextos($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idVariable=(int)$argumentos['variable'];
	$idSeguimiento=(int)$argumentos['seguimiento'];

	#return($argumentos);


	$clausulaFecha=' WHERE (1=1) ';
	if(isset($argumentos['anoInicio']) AND isset($argumentos['anoFinal']) AND isset($argumentos['mesInicio']) AND isset($argumentos['mesFinal']) ){
		$anoInicio=$argumentos['anoInicio']; 
		$mesInicio=$argumentos['mesInicio']; 
		$anoFinal=$argumentos['anoFinal'];
		$mesFinal=$argumentos['mesFinal'];
		$fechaInicio=$anoInicio.'/'.$mesInicio;
		$fechaFinal=$anoFinal.'/'.$mesFinal;
		$clausulaFecha=" WHERE aaa_texto.fecha >= '$fechaInicio' AND aaa_texto.fecha <= '$fechaFinal' ";
	}



	$keywords=$argumentos['keywords'];
	$keywords=explode(",",$keywords);
	foreach ($keywords as $key => $value) {
		$kw[]=trim($value);
	}
	if(count($kw)!=0){
		$clausulaValor="AND ( aaa_texto.descriptor LIKE '%";
		$clausulaValor.=implode("%' OR aaa_texto.descriptor LIKE '%", $kw);
		$clausulaValor.="%' ) ";
	} 

	$sql="SELECT aaa_texto.id as idTexto, aaa_texto.descriptor as descriptorTexto, aaa_texto.fecha as fecha 
	FROM aaa_texto 
	INNER JOIN aaa_item ON aaa_texto.idaaa_item=aaa_item.id 
	INNER JOIN aaa_seguimiento ON aaa_item.idaaa_seguimiento=aaa_seguimiento.id 
	$clausulaFecha 
	$clausulaValor
	AND aaa_texto.id>1 
	AND aaa_seguimiento.id='$idSeguimiento' 
	AND aaa_texto.id NOT IN (
		SELECT aaa_texto.id FROM aaa_texto 
		INNER JOIN aaa_textoValor ON aaa_texto.id=aaa_textoValor.idaaa_texto 
		INNER JOIN aaa_valor ON aaa_valor.id=aaa_textoValor.idaaa_valor 
		WHERE (1=1) 
		AND aaa_texto.id>1 
		AND aaa_valor.idaaa_variable='$idVariable' 
	);";	
	#return $sql;
	$i=0;
	$t=array();
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$t[$i]['id']=$row['idTexto'];
				$t[$i]['descriptor']=$row['descriptorTexto'];
				$t[$i]['texto']=$row['descriptorTexto'];
				$t[$i]['fecha']=$row['fecha'];
				$t[$i]['idValor']='';
				$t[$i]['valor']='';
				$t[$i]['puntaje']='';
				$t[$i]['idVariable']='';
				$t[$i]['variable']='';
				$t[$i]['roh']='';
				$t[$i]['idTextoValor']='';
				$i++;
			}
		}
		$result->close();
	} else {
		return "ERROR: ".$sql;
	}

	$sql="SELECT 
	aaa_texto.id as idTexto, 
	aaa_texto.descriptor as descriptorTexto,
	aaa_texto.fecha as fecha, 
	aaa_textoValor.roh as roh, 
	aaa_textoValor.puntaje as puntaje, 
	aaa_valor.id as idValor,
	aaa_valor.descriptor as descriptorValor,
	aaa_variable.id as idVariable,
	aaa_variable.descriptor as descriptorVariable,
	aaa_textoValor.id as idTextoValor
	FROM aaa_texto
	INNER JOIN aaa_textoValor ON aaa_texto.id=aaa_textoValor.idaaa_texto
	INNER JOIN aaa_valor ON aaa_valor.id=aaa_textoValor.idaaa_valor
	INNER JOIN aaa_variable ON aaa_variable.id=aaa_valor.idaaa_variable
	$clausulaFecha 
	$clausulaValor
	AND aaa_texto.id>1
	AND aaa_valor.idaaa_variable=$idVariable;";
	//return($sql);

	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$t[$i]['id']=$row['idTexto'];
				$t[$i]['texto']=$row['descriptorTexto'];
				$t[$i]['fecha']=$row['fecha'];
				$t[$i]['idValor']=$row['idValor'];
				$t[$i]['valor']=$row['descriptorValor'];
				$t[$i]['puntaje']=$row['puntaje'];;
				$t[$i]['idVariable']=$row['idVariable'];
				$t[$i]['variable']=$row['descriptorVariable'];
				$t[$i]['roh']=$row['roh'];
				$t[$i]['idTextoValor']=$row['idTextoValor'];
				$i++;
			}
		}
		$result->close();
	} else {
		return "ERROR: ".$sql;
	}
	$z=array();
	if(count($t)>0) {
		$z=$t;
	}
	return $z;
}
function borrarEtiqueta($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idTextoValor=$argumentos['idTextoValor'];
	$sql="DELETE FROM aaa_textoValor WHERE id='$idTextoValor'";
	if ($result = $mysqli->query($sql)) {
		return "Borrado con exito..." . $sql;
	} else {
	return $sql;
	}
}
function reiniciarRobot($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idVariable=$argumentos['idVariable'];
	$sql="DELETE FROM aaa_textoValor WHERE roh='R' AND aaa_textoValor.idaaa_valor IN (SELECT aaa_valor.id FROM aaa_valor WHERE aaa_valor.idaaa_variable='$idVariable');";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		return "Borrado con exito:    ".$sql;
	} else {
		return "Error en:     ".$sql;
	}
}
function eliminarTexto($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idTexto=$argumentos['idTexto'];
	$sql="DELETE FRoM aaa_texto WHERE id='$idTexto'";
	$i=0;
	if ($result = $mysqli->query($sql)) {} 
	return "Borrado con exito";
}
function ejecutarRobot($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);

	$idVariable=$argumentos['idVariable'];
	$idTexto=$argumentos['idTexto'];
	#1. Obtener todos los patrones acumulados de cada valor de la variable actual
	$sql="DELETE FROM aaa_textoValor WHERE roh='R";
	if ($result = $mysqli->query($sql)) {} 

		
	$sql="SELECT  DISTINCT(aaa_dicRechazo.lemaPar) as lemaPar, aaa_valor.id as idValor, aaa_valor.descriptor as valor 
	FROM aaa_dicRechazo 
	INNER JOIN aaa_valor ON aaa_valor.id=aaa_dicRechazo.idaaa_valor
	WHERE aaa_valor.idaaa_variable='$idVariable'";
	//return($sql);
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$rechazos[$row['idValor']]['idValor']=$row['idValor'];
				$rechazos[$row['idValor']]['valor']=$row['valor'];
				$rechazos[$row['idValor']]['lemaPares'][]=$row['lemaPar'];
				$rechazosLP[$row['idValor']][]=$row['lemaPar'];
				$i++;
			}
		} 
		$result->close();
	} 
	//return($rechazosLP);

		
		
	$sql="SELECT  DISTINCT(aaa_dicValor.lemaPar) as lemaPar, aaa_valor.id as idValor, aaa_valor.descriptor as valor 
	FROM aaa_dicValor 
	INNER JOIN aaa_valor ON aaa_valor.id=aaa_dicValor.idaaa_valor
	WHERE aaa_valor.idaaa_variable='$idVariable'";
	#return($sql);
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$valores[$row['idValor']]['idValor']=$row['idValor'];
				$valores[$row['idValor']]['valor']=$row['valor'];
				$valores[$row['idValor']]['lemaPares'][]=$row['lemaPar'];
				$valoresLP[$row['idValor']][]=$row['lemaPar'];
				$i++;
			}
		} 
		$result->close();
	} 


	$sql="SELECT  DISTINCT(aaa_dicTextoValor.lemaPar) as lemaPar, aaa_valor.id as idValor, aaa_valor.descriptor as valor 
	FROM aaa_dicTextoValor 
	INNER JOIN aaa_textoValor ON aaa_textoValor.id=aaa_dicTextoValor.idaaa_textoValor
	INNER JOIN aaa_valor ON aaa_valor.id=aaa_textoValor.idaaa_valor
	WHERE aaa_valor.idaaa_variable='$idVariable'";
	//return($sql);
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$valores[$row['idValor']]['idValor']=$row['idValor'];
				$valores[$row['idValor']]['valor']=$row['valor'];
				$valores[$row['idValor']]['lemaPares'][]=$row['lemaPar'];
				$valoresLP[$row['idValor']][]=$row['lemaPar'];
				$i++;
			}
		} 
		$result->close();
	} 

	#2. Obtener el id seguimiento de la variable actual
	$sql="SELECT idaaa_seguimientoEspejo as idSeguimiento
	FROM aaa_variable
	WHERE id=$idVariable";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$idSeguimiento=$row['idSeguimiento'];
				$i++;
			}
		} 
		$result->close();
	} 


	#2. Obtener todos los textos de este seguimiento con sus lemapares
	$sql="SELECT aaa_lemaPar.idaaa_texto as idTexto, aaa_lemaPar.id as idLemaPar, aaa_lemaPar.lemaPar as lemaPar, aaa_lemaPar.relevancia as relevancia
	FROM aaa_lemaPar
	INNER JOIN aaa_texto ON aaa_texto.id=aaa_lemaPar.idaaa_texto
	INNER JOIN aaa_item ON aaa_item.id=aaa_texto.idaaa_item
	WHERE aaa_item.idaaa_seguimiento='$idSeguimiento'
	AND aaa_lemaPar.idaaa_texto NOT IN (SELECT aaa_textoValor.idaaa_texto FROM aaa_textoValor WHERE aaa_textoValor.roh='H')";
	#return($sql);
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$textos[$row['idTexto']][$row['lemaPar']]=$row['relevancia'];
				$i++;
			}
		} 
		$result->close();
	} 
	$data['v']=$valoresLP;
	$data['t']=$textos;
	#return $data;

	#3. Recorrer la lista de patrones y compararlo con lemapares
	foreach ($valoresLP as $key=>$valor) {
			foreach ($textos as $key2 => $texto) {
				$data['distanciaPositiva'][$key][$key2]=distancia($valor,$texto);
				$data['r'][$key][$key2]=$data['distanciaPositiva'][$key][$key2];
			}
	}

	foreach ($rechazosLP as $key=>$valor) {
			foreach ($textos as $key2 => $texto) {
				$data['distanciaNegativa'][$key][$key2]=distanciaRechazando($valor,$texto);
				$data['r'][$key][$key2]=$data['r'][$key][$key2]-$data['distanciaNegativa'][$key][$key2];			
			}
	}

	#4. Eliminar los casos d puntaje 0
	foreach ($data['r'] as $key => $value) {
		foreach ($value as $key2 => $value2) {
			if($value2>0){
				$data2[$key][$key2]=$value2;
			}
		}
	}

	foreach ($data2 as $key => $value) {
		foreach ($value as $key2 => $value2) {
			$sql="INSERT INTO aaa_textoValor (idaaa_texto,idaaa_valor,roh,puntaje) VALUES ('$key2','$key','R','$value2')";
			if ($result = $mysqli->query($sql)) {}
		}
	}

	return $data2;
	/*
	/*
	*/
}
function distancia($valor,$texto){
	foreach ($valor as $v) {
		$puntaje+=$texto[$v];
	}
	return $puntaje;
}
function distanciaRechazando($rechazos,$texto){
	foreach ($rechazos as $v) {
		$puntaje+=$texto[$v];
	}
	return $puntaje;
}
function iniciarTablaV($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idVariable=$argumentos['idVariable'];
	$idTexto=$argumentos['idTexto'];
	$sql="SELECT aaa_valor.id as id, aaa_valor.descriptor as descriptor FROM aaa_textoValor INNER JOIN aaa_valor ON aaa_valor.id=aaa_textoValor.idaaa_valor WHERE aaa_valor.idaaa_variable ='$idVariable'  AND aaa_textoValor.idaaa_texto = '$idTexto'";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$filas[$i]['value']=$row['id'];
				$filas[$i]['text']=$row['descriptor'];
				$i++;
			}
		} 
		$result->close();
	} 
	return $filas;
}
function iniciarSelect($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idVariable=$argumentos['idVariable'];
	$idTexto=$argumentos['idTexto'];
	$sql="SELECT aaa_valor.id as id, aaa_valor.descriptor as t FROM aaa_valor WHERE idaaa_variable='$idVariable' AND aaa_valor.id NOT IN ( SELECT idaaa_valor FROM aaa_textoValor WHERE idaaa_texto='$idTexto')";
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
function regresar($x){ echo json_encode($x); }
function creaTextoValor($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$valor=$argumentos['valor'];
	$idTexto=$argumentos['idTexto'];
	$lemapares=$argumentos['lemapares'];
	$i=0;
	$puntaje=count($lemapares);
	$sql="INSERT INTO aaa_textoValor (roh,puntaje,idaaa_texto,idaaa_valor) VALUES ('H','$puntaje','$idTexto','$valor');";
	if ($result = $mysqli->query($sql)) {} else {return($sql);}
	$sql="SELECT MAX(id) as m FROM aaa_textoValor";
		if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$idMax=$row['m'];
			}
		}
		$result->close();
	} else {
		return "ERROR: ".$sql;
	}

	foreach ($lemapares as $key => $value) {
		if($lemapares[$key]['id']+1==$lemapares[$key+1]['id']){
			$LOP="P";
			$x[$i]['t']=$lemapares[$key]['value'];
			$x[$i]['lop']="L";
			$i++;
			$x[$i]['t']=$lemapares[$key]['value'].'-'.$lemapares[$key+1]['value'];
			$x[$i]['lop']="P";
			$i++;
		} else {
			$LOP="L";
			$x[$i]['t']=$lemapares[$key]['value'];			
			$x[$i]['lop']="L";
			$i++;
		}
	}
	foreach ($x as $key => $value) {
		$t=$value['t'];
		$lop=$value['lop'];
		$sql="INSERT INTO aaa_dicTextoValor (descriptor,lemaPar,LOP,idaaa_textoValor) VALUES ('$t','$t','$lop','$idMax');";
		if ($result = $mysqli->query($sql)) {} else {return($sql);}
	}
	return ("EXITO");
}

function contarElementosRepetidos($array) {
	$conteo = array_count_values($array);
	$repetidos = array_filter($conteo, function($valor) {
		return $valor > 1;
	});    
	return $repetidos;
}
function lemaPares($t){
	$t=str_replace("_ ", "", $t);
	$oraciones=explode(".", $t);
	foreach ($oraciones as $oracion) {
		$lemas=explode(" ", $oracion);
		for ($i=0; $i < count($lemas)-1; $i++) { 
			if($lemas[$i]!='' AND $lemas[$i+1]!=''){
				if(!isset($pares[$lemas[$i]][$lemas[$i+1]])){ 
					$pares[$lemas[$i]][$lemas[$i+1]]=0;
				}
				$pares[$lemas[$i]][$lemas[$i+1]]++;
			}
			if($lemas[$i]!='' AND $lemas[$i-1]!=''){
				if(!isset($pares[$lemas[$i]][$lemas[$i-1]])){
					$pares[$lemas[$i]][$lemas[$i-1]]=0;
				}
				$pares[$lemas[$i]][$lemas[$i-1]]++;
			}
			if($lemas[$i]!=''){
				$l[]=$lemas[$i];
			}
		}
	}
	$z['lemas']=$l;
	$z['pares']=$pares;
	return $z;
}
function descartar($t){
	$mysqli=conectar($_SESSION['datosConexion']);
	$sql="SELECT descriptor FROM aaa_dicDescarte WHERE idaaa_idioma='2';";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$dicDescarte[]=$row['descriptor'];
			}
		}
		$result->close();
	}
	$mysqli->close();
	$tarzan=explode(" ", $t);
	foreach ($tarzan as $key => $value) {
		if(in_array($value, $dicDescarte)){
			$tarzan[$key]="_";
		}
	}
	$tarzan=implode(" ", $tarzan);
	return $tarzan;
}
function textoLimpio($t){
	$t=strtolower($t);
	$busca = 		['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü'];
	$reemplaza = 	['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'n', 'u', 'u'];
	$t = str_replace($busca, $reemplaza, $t);
	$t = str_replace(array("\r\n", "\r", "\n"), ' ', $t);
	$patron = '/[^a-zA-Z0-9. ]/';
	$t = preg_replace($patron, '', $t);
	for ($i=0; $i < 5; $i++) { 
		$t = str_replace("..", ".", $t);
	}
	for ($i=0; $i < 5; $i++) { 
		$t = str_replace(".", " . ", $t);
	}
	for ($i=0; $i < 5; $i++) { 
		$t = str_replace("  ", " ", $t);
	}
	$t=trim($t);
	return $t;
}
function limpiar($t){ return $z; }	
function analizar($t){
	$z=dicDescarte();
	$z="cucucucuc";
	return $z;
}
function lemas($t){ return $z; }
function pares($t){	return $z; }
function dicDescarte($argumentos){
	$mysqli=conecta();
	return $mysqli;
	$clausulaMisDatos='';
	$sql="SELECT id, descriptor FROM aaa_dicDescarte WHERE idaaa_idioma='$idioma';";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$row['id']]=$row['descriptor'];
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function conecta(){
	$datosConexion=$_SESSION['datosConexion']; 
	$mysqli=conectar($datosConexion);
	return $mysqli;
}