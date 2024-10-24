<?
include('../000_conexion.php');
session_start();

unset($_SESSION['salida']); ##salida del generador
$P=1; //define si los pre se ven o no



$json = file_get_contents('php://input');
header('Content-Type: application/json');
$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
	regresar(json_encode("No recibi argumentos"));
	die();
} else {
	$argumentos = $data ?? null;
	$argumentos=$argumentos['argumentos'];
	$funcionLlamada=$argumentos['funcionLlamada'];
}

switch ($funcionLlamada) {
	case 'dicDescarte':
	$z=dicDescarte($argumentos);
	break;	
	case 'cargaProyectos':
	$z=cargaProyectos($argumentos);
	break;	
	case 'cargaSeguimientos':
	$z=cargaSeguimientos($argumentos);
	break;	
	case 'cargaItems':
	$z=cargaItems($argumentos);
	break;	
	case 'cargaVariables':
	$z=cargaVariables($argumentos);
	break;	
	case 'cargaValores':
	$z=cargaValores($argumentos);
	break;	
	case 'cargaFrecuentes':
	$z=cargaFrecuentes($argumentos);
	break;	
	default:
		# code...
	break;
}
regresar($z);
die();

function regresar($x){
	echo json_encode($x);
}
function cargaFrecuentes($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$cliente=$_SESSION['cliente'];
	$sql="SELECT COUNT(aaa_lemaPar.id) as cuenta, aaa_lemaPar.descriptor 
	FROM aaa_lemaPar 
	INNER JOIN aaa_texto ON aaa_texto.id=aaa_lemaPar.idaaa_texto
	INNER JOIN aaa_item ON aaa_item.id=aaa_texto.idaaa_item
	INNER JOIN aaa_seguimiento ON aaa_seguimiento.id=aaa_item.idaaa_seguimiento
	INNER JOIN aaa_proyecto ON aaa_proyecto.id=aaa_seguimiento.idaaa_proyecto
	WHERE aaa_lemaPar.id>1 
	AND aaa_proyecto.idaaa_cliente=$cliente
	AND lop='L' 
	GROUP BY aaa_lemaPar.descriptor 
	ORDER BY cuenta DESC LIMIT 0,100;";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['descriptor'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function cargaProyectos($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$cliente=$_SESSION['cliente'];
	$sql="SELECT id, descriptor FROM aaa_proyecto WHERE id>1;";
	$sql="SELECT id, descriptor FROM aaa_proyecto WHERE id>1 AND idaaa_cliente='1';";
	$sql="SELECT id, descriptor FROM aaa_proyecto WHERE id>1 AND idaaa_cliente='$cliente';";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['id'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function cargaSeguimientos($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idaaa_proyecto=$argumentos['idaaa_proyecto'];
	$sql="SELECT id, descriptor FROM aaa_seguimiento WHERE idaaa_proyecto=$idaaa_proyecto;";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['id'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function cargaItems($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idaaa_seguimiento=$argumentos['seguimiento'];
	$sql="SELECT id, descriptor FROM aaa_item WHERE idaaa_seguimiento='$idaaa_seguimiento';";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['id'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function cargaVariables($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idaaa_seguimiento=$argumentos['idaaa_seguimiento'];
	$sql="SELECT id, descriptor FROM aaa_variable WHERE idaaa_seguimientoEspejo='$idaaa_seguimiento';";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['id'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function cargaValores($argumentos){
	$mysqli=conectar($_SESSION['datosConexion']);
	$idaaa_variable=$argumentos['idaaa_variable'];
	$sql="SELECT id, descriptor FROM aaa_valor WHERE idaaa_variable='$idaaa_variable';";
	$i=0;
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$i]['value']=$row['id'];
				$z[$i]['text']=$row['descriptor'];
				$i++;
			}
		}
		$result->close();
	}
	$mysqli->close();
	return $z;
}
function limpiar($t){
	return $z;
}	
function analizar($t){
	$z=dicDescarte();
	$z="cucucucuc";
	return $z;
}
function lemas($t){
	return $z;
}
function pares($t){
	return $z;
}
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