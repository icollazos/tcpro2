<?
function ejecutarNewsData($url,$idItem,$P){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'User-Agent: TCPRO/1.0' ]);
	$response = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error en cURL: ' . curl_error($ch);
	} else {
		$data = json_decode($response, true);
		p($P,$data);
		$data=extraeTextosNewsData($data);
			//p(1,$data); // Muestra la respuesta
		foreach ($data as $registro) {
			cargaTextoIndividual($registro,$idItem);
			//break;
		}
	}
	curl_close($ch);
}
function extraeTextosNewsData($array){
	$array=$array['results'];
		//p(1,$array);
	$i=0;
	foreach ($array as $key => $value) {
		$t=trim($value['title']);
		$c=trim($value['title']);
		$tc=$t.'. '.$c;
		$tc= str_replace(array("\r", "\n"), '', $tc);
		$mapa = [
			'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U',
			'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
			'Ñ' => 'n', 'ñ' => 'n'
		];
		$tl = strtr($tc, $mapa);
		$z[$i]['texto']=$tc;
		$z[$i]['url']=$value['link'];
		$z[$i]['fecha']=substr($value['pubDate'],0,10);
		$z[$i]['textoLimpio']=$tl;
		$i++;
	}
	return $z;
}
function ejecutarNewsApi($url,$idItem,$P){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'User-Agent: TCPRO/1.0' ]);
	$response = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error en cURL: ' . curl_error($ch);
	} else {
		$data = json_decode($response, true);
		p($P,$data);
		$data=extraeTextosNewsApi($data);
				#p(1,$data); // Muestra la respuesta
		foreach ($data as $registro) {
			cargaTextoIndividual($registro,$idItem,$dicDescarte);
		}
	}
	curl_close($ch);
}
function extraeTextosNewsApi($array){
	$array=$array['articles'];
	$i=0;
	foreach ($array as $key => $value) {
		$t=trim($value['title']);
		$c=trim($value['content']);
		$tc=$t.'. '.$c;
		$tc= str_replace(array("\r", "\n"), '', $tc);
		$mapa = [
			'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U',
			'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u',
			'Ñ' => 'n', 'ñ' => 'n'
		];
		$tl = strtr($tc, $mapa);
		$z[$i]['texto']=$tc;
		$z[$i]['url']=$value['url'];
		$z[$i]['fecha']=substr($value['publishedAt'],0,10);
		$z[$i]['textoLimpio']=$tl;
		$i++;
	}
	return $z;
}
function unica($texto){
	$plantilla=array(15,4,7,2,9);
	foreach ($plantilla as $p) {
		$unica.=$texto[$p];
	}
	return($unica);
}
function cargaTextoIndividual($registro,$idItem){
	$mysqli=conectar($_SESSION['datosConexion']);
	$texto=$registro['texto'];
	$texto = str_replace(array("\r\n", "\r", "\n"), ' ', $texto);
	$textoLimpio=textoLimpio($texto);
	$urlTexto=$registro['url'];
	$controlador=unica($texto);
	if($urlTexto==''){$urlTexto = $controlador;}
	$longitud=strlen($texto);
	$fecha=$registro['fecha'];
	$analizado=0;
	$sql="INSERT INTO aaa_texto (controlador, descriptor, textoLimpio, idaaa_item, fecha, analizado, url, longitud) VALUES ( 
	'$controlador', 
	'$texto', 
	'$textoLimpio', 
	'$idItem', 
	'$fecha', 
	'0',	
	'$urlTexto', 
	'$longitud');";
	//P(1,$sql);
	if ($result = $mysqli->query($sql)) { 
		$sql2="SELECT MAX(id) as idActual FROM aaa_texto;";
		if ($result2 = $mysqli->query($sql2)) {
			if ($result2->num_rows> 0){
				while ($row = $result2->fetch_assoc()){
					$idActual=$row['idActual'];
					$tarzan=descartar($textoLimpio);
					$sql3="UPDATE aaa_texto SET textoLimpio='$textoLimpio' WHERE id='$idActual'";
					if ($result3 = $mysqli->query($sql3)) { } else { return "ERROR: ".$sql; }
					$sql4="UPDATE aaa_texto SET textoTarzan='$tarzan' WHERE id='$idActual'";
					if ($result4 = $mysqli->query($sql4)) { } else { return "ERROR: ".$sql; }
					$lemaPares=lemaPares($tarzan);
					//p(1,$lemaPares);
					$lemas=$lemaPares['lemas'];
					$pares=$lemaPares['pares'];
					$lemasCompacto=array_unique($lemas);
					foreach ($lemasCompacto as $lc) {
						$analisisLemas[$lc]['fi']=0;
						foreach ($lemas as $lema) {
							if($lema==$lc){$analisisLemas[$lc]['fi']++;}
						}
					}
					foreach ($lemasCompacto as $l) {
						foreach ($pares as $key => $value) {
							if($key==$l){
								foreach ($value as $key2 => $value2) {
									$xx[$l][]=$key2;
								}
							}
						}
					}
					foreach ($xx as $key => $value) {
						$analisisLemas[$key]['numSocios']=count($value);
						$analisisLemas[$key]['socios']=$pares[$key];
						$analisisLemas[$key]['relevancia']=$analisisLemas[$key]['numSocios']*$analisisLemas[$key]['fi'];
					}

					foreach ($analisisLemas as $k=>$v) {
						$lemaPar=$k;
						$lop="L";
						$lema1=$k;
						$lema2=$k;
						$relevancia=$v['relevancia'];
						$numSocios=$v['numSocios'];
						$idaaa_texto=$id;
						$sql5="INSERT INTO aaa_lemaPar (descriptor,lemaPar,lema1,lema2,lop,relevancia,numSocios,idaaa_texto) VALUES ('$lemaPar','$lemaPar','$lema1','$lema2','$lop','$relevancia','$numSocios','$idActual')";
						//p(1,$sql5);
						if ($result5 = $mysqli->query($sql5)) { } else { return "ERROR: ".$sql; }
					}
					foreach ($pares as $key => $value) {
						$lemaPar=$key.'-'.array_keys($value)[0];
						$lop='P';
						$lema1=$key;
						$lema2=array_keys($value)[0];
						$relevancia=$analisisLemas[$key]['relevancia']  + $analisisLemas[array_keys($value)[0]]['relevancia'];
						$numSocios=0;
						$idaaa_texto=$id;
						$sql6="INSERT INTO aaa_lemaPar (descriptor,lemaPar,lema1,lema2,lop,relevancia,numSocios,idaaa_texto) VALUES ('$lemaPar','$lemaPar','$lema1','$lema2','$lop','$relevancia','$numSocios','$idActual');";
						if ($result6 = $mysqli->query($sql6)) { } else { return "ERROR: ".$sql; }	
					}
				}
			}
		} else {
			return "ERROR: ".$sql;
		}
	} else { return "ERROR: ".$sql; }



	$mysqli->close();
	return "EXITO";
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
	$sql="SELECT descriptor FROM aaa_dicDescarte WHERE idaaa_tipoIdioma='2';";
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
	$idaaa_seguimiento=$argumentos['idaaa_seguimiento'];
	$sql="SELECT id, descriptor FROM aaa_item WHERE idaaa_seguimiento=$idaaa_seguimiento;";
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
function limpiar($t){ return $z; }	
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
