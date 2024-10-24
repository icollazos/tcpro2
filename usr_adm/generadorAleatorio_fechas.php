<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador

$P=0;
$anoInicial=2024;
$anoFinal=2024;
$mesInicial=1;
$mesFinal=12;
include('..//000_conexion.php');

$tablas=tablasFechas();

#cargo las tablas del sistema
$mysqli=conectar($datosConexion);
p($P,$datosConexion);
p($P,$mysqli);


$bd=$datosConexion['database'];
foreach ($tablas as $tabla) {
	$sql="SELECT id FROM $tabla";
	p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		#p($P,$result);
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$registros[$tabla][]=$row['id'];
			}
		}
		$result->close();
	}
} 

p($P,$registros);


foreach ($registros as $tabla=>$ids) {
	foreach ($ids as $id) {
		$ano=rand($anoInicial,$anoFinal);
		$mes=rand($mesInicial,$mesFinal);
		if($mes<10){ $mes='0'.$mes;	}
		$dia=rand(1,28);
		if($dia<10){ $dia='0'.$dia;	}
		$sql="UPDATE $tabla SET fecha='$ano/$mes/$dia' WHERE id='$id';

		";
		if ($result = $mysqli->query($sql)) {}
		//echo $sql;
	}
	$sql2="UPDATE $table set fechaHora=fecha";
	if ($result = $mysqli->query($sql2)) {}
}

header("location:filtrado_consulta.php");
die();
#p($P,$sql2);




