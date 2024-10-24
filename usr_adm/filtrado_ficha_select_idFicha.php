<?

//inicializando
include('../000_conexion.php');
session_start();
unset($_SESSION['salida']); ##salida del generador
$P=0; //define si los pre se ven o no

$arg=$_POST['argumentos'];
$esteAmbito='factura';
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;

$seccion="principal";
$idFactura=$_POST['idFactura'];

$mysqli=conectar($datosConexion);

$sql="SELECT * from v_aaa_factura WHERE id='$idFactura'";
$tabla['sql']=$sql;

if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				$tabla['factura'][$key]=$value;
			}
		}
	} 
	$result->close();
} 

$sql="SELECT * from v_aaa_otrosGastos WHERE id_factura_otrosGastos='$idFactura'";
$q=0;
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				if(is_numeric($value)){
					$value=(int)$value;
				}
				$tabla['otrosGastos'][$q][$key]=$value;
			}
			$q++;
		}
	} 
	$result->close();
} 

$json=json_encode($tabla);
echo $json;
die();
