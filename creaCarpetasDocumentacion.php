<?

//inicializando
session_start();

$P=1; //define si los pre se ven o no
include('00_conexion.php');

$mysqli=conectar($datosConexion);
$sql="SHOW TABLES from tioconejo_funvape";

if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if(substr($row['Tables_in_tioconejo_funvape'],0,2)!='v_' AND substr($row['Tables_in_tioconejo_funvape'],0,3)!='doc' ){
				$carpetas[]=$row['Tables_in_tioconejo_funvape'];
			}
		}
		$result->close();
	}
} 

p(1,$carpetas);
$ruta="archivos/";

foreach ($carpetas as $carpeta) {
	mkdir($ruta.$carpeta);
	mkdir($ruta.$carpeta.'/1/');
}

die();


