<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador
include("000_lemario_corto.php");
$limite=150;
$limiteParent=15;
$lemario=lemario();
$lemario=explode("\n", $lemario);

#$P=1; //define si los pre se ven o no
include('..//000_conexion.php');

#cargo las tablas del sistema
$mysqli=conectar($datosConexion);
#p($P,$mysqli);

$bd=$datosConexion['database'];


$sql="SET FOREIGN_KEY_CHECKS = 0;\n";
$sql2='SHOW TABLES FROM '.$bd."\n";
	#p($P,$sql2);
if ($result = $mysqli->query($sql2)) {
		#p($P,$result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				if( substr($value, 0,2)!='v_' 
					AND substr($value, 0,4)!="adm_" 
					AND substr($value, 0,4)!="doc_" 
					AND substr($value, 0,4)!="gra_" 
					AND substr($value, 0,4)!="ind_" 
					AND $value!="ctrlViews" 
					AND $value!="alias" 
					AND $value!="Alias" ) {
					$tablas[]=$value;
			} 
		}
	}
}
$result->close();
} 

$total=count($lemario);
foreach ($tablas as $key => $value) {
	
	for ($i=0; $i < $limite; $i++) { 
		unset($cadena);
		for ($j=0; $j < (rand(1,1)); $j++) { 
			$azar = rand(0, $total-1);
			$azar2 = rand(0, $total-1);
			$azar3 = rand(0, $total-1);
			$azar4 = rand(0, $total-1);
			$azar5 = rand(0, $total-1);
			$cadena=trim($lemario[$azar]).trim($lemario[$azar2]).trim($lemario[$azar3]).trim($lemario[$azar4]).trim($lemario[$azar5]);
		}
		$cadena=trim($cadena);
		$sql="INSERT INTO $value (descriptor) VALUES ('$cadena'); \n   ";
		
		if ($result = $mysqli->query($sql)) {} 
	}
}
#p($P,$sql);

$sql='';
$sql2='';
p($P,$tablas);
foreach ($tablas as $key => $value) {
	p($P,"-----------------------------------------------------------------------------");
	p($P,$value);
	$sql="DESCRIBE $value;\n   ";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				if($row[Field] != 'id' AND $row[Field] != 'fechaHora' AND $row[Field] != 'descriptor' AND $row[Field] != 'borrar' AND $row[Field] != 'lat' AND $row[Field] != 'lng' and $value!="aaa_municipio"){
					p($P,"11111111111111111111111111111111111111111111111111111111111111111111111111111");
					$field=$row[Field];
					$type=$row[Type];
					p($P,$field.' '.$type);
					if( substr($field,0,2)=='id' and strlen($field)>2 ){
						p($P,"PARENT");
						for ($i=2; $i <= $limite; $i++) { 
							$q=rand(2,$limiteParent-1);
							$sql2="UPDATE $value SET $field='$q' WHERE id='$i';\n   ";
							p($P,$sql2);
							if ($result2 = $mysqli->query($sql2)) {
							}
						}
					}
					if(substr($field, 0,2)!="id" AND substr($type, 0,3)=="int"){
						p($P,"NUMERO");
						for ($i=2; $i <= $limite; $i++) { 
							$r=rand(0,10);
							$sql2="UPDATE $value SET $field='$r' WHERE id='$i';\n   ";
							p($P,$sql2);
							if ($result2 = $mysqli->query($sql2)) {
							}
						}
					}
					if(substr($field, 0,2)!="id" AND substr($type, 0,7)=="decimal"){
						p($P,"DECIMAL");
						for ($i=2; $i <= $limite; $i++) { 
							$r=(rand(0,1000))/100;
							$sql2="UPDATE $value SET $field='$r' WHERE id='$i';\n   ";
							p($P,$sql2);
							if ($result2 = $mysqli->query($sql2)) {
							}
						}
					}
					if(substr($type, 0,7)=="varchar"){
						p($P,"TEXTO");
						for ($i=2; $i <= $limite; $i++) { 
							for ($j=0; $j < (rand(1,2)); $j++) { 
								$cadena='';
								$azar = rand(0, $total);
								$cadena=$cadena.trim($lemario[$azar]).' ';
							}
							$sql2="UPDATE $value SET $field='$cadena' WHERE id='$i';\n   ";
							p($P,$sql2);
							if ($result2 = $mysqli->query($sql2)) {
							}
						}
					}
				}
			}
		}
		$result->close();
	}
}

header("location:filtrado_consulta.php");
#p($P,$sql2);




