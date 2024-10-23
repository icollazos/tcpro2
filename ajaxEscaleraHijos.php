<?
//inicializando
session_start();
$P=1; //define si los pre se ven o no
include('00_conexion.php');
$mysqli=conectar($datosConexion);
$padre=$_POST['padre'];
	$sql="SELECT descriptor FROM cadenas";
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
	$mysqli->close();
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
	echo json_encode($z[$padre]);
