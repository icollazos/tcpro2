<?
//inicializando
session_start();
$P=$_SESSION['fvp']['P']; //define si los pre se ven o no
include('00_conexion.php');
$mysqli=conectar($datosConexion);

$padre=$_POST['padre'];
$idPadre=$_POST['idPadre'];
$hijo=substr($_POST['hijo'],2,100);

$sql="SELECT descriptor FROM adm_cadenas";
#p($P,$sql);

if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$exp=explode(",", $row['descriptor']);
			krsort($exp);
			$a[]=$exp;
		}
		#p($P,$a);
	} 
	$result->close();
} 
foreach ($a as $keya => $valuea) {
	foreach ($valuea as $keyb => $valueb) {
		$b[$keya][]=$valueb;
	}
}
foreach ($b as $keyb => $valueb) {
	for ($i=0; $i < count($valueb); $i++) { 
		for ($j=$i+1; $j < count($valueb); $j++) { 
			$z[$valueb[$i]][]=$valueb[$j];
		}		
	}
}
foreach ($z as $key => $value) {
	$z[$key]=array_unique($z[$key]);
}
$f['hijos']=$z[$padre];


$padre=$_POST['padre'];
$idPadre=$_POST['idPadre'];
$hijo=substr($_POST['hijo'],2,100);

$sql="SELECT id,descriptor FROM $hijo WHERE $padre=$idPadre";
$z=array();
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		$i=0;
		while ($row = $result->fetch_assoc()){
			array_push($z,array('id'=>$row['id'],'descriptor'=>$row['descriptor']));
		}
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 
$f['options']=$z;
$mysqli->close();
echo json_encode($f);
die();
#$z=array('id'=>'a','v'=>1);
