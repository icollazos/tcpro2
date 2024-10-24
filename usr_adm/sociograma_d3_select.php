<?
include('../000_conexion.php');
session_start();
$mysqli=conectar($datosConexion);

unset($_SESSION['salida']); ##salida del generador
$P=0; //define si los pre se ven o no



/*
*/

header('Content-Type: application/json');
// Obtener el cuerpo de la solicitud
$json = file_get_contents('php://input');
// Decodificar el JSON recibido
$data = json_decode($json, true);
// Verificar si la decodificación fue exitosa
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}
// Procesar los datos (por ejemplo, podrías realizar operaciones con $data['x'])
$argumentos = $data ?? null;


// Aquí puedes realizar la lógica que necesites con el valor de $x
// Por ejemplo, simplemente devolverlo en la respuesta


$esteAmbito=$argumentos['esteAmbito'];
$estaTabla='aaa_relacion';
$estaVista='v_'.$estaTabla;

$seccion="principal";

$idUsuario=$_SESSION['fvp']['idUsuario'];

$clausulaFecha=' WHERE (1=1) ';

$actores=$argumentos['actores'];
$relaciones=$argumentos['relaciones'];
if($actores){
	$clausulaActores1="AND ( ";
	foreach ($actores as $actor) {
		$clausulaActores1 .= " idaaa_actor='$actor' OR ";
	}
	$clausulaActores1=substr($clausulaActores1, 0,-3);
	$clausulaActores1.=" ) ";

	$clausulaActores2="AND ( ";
	foreach ($actores as $actor) {
		$clausulaActores2 .= " idaaa_actor2='$actor' OR ";
	}
	$clausulaActores2=substr($clausulaActores2, 0,-3);
	$clausulaActores2.=" ) ";

	$clausulaActores3="AND ( ";
	foreach ($actores as $actor) {
		$clausulaActores3 .= " idaaa_actor='$actor' OR  idaaa_actor2='$actor' OR ";
	}
	$clausulaActores3=substr($clausulaActores3, 0,-3);
	$clausulaActores3.=" ) ";

}

if($relaciones){
	$clausulaRelaciones="AND ( ";
	foreach ($relaciones as $relacion) {
		$clausulaRelaciones .= " idaaa_tipoRelacion='$relacion' OR ";
	}
	$clausulaRelaciones=substr($clausulaRelaciones, 0,-3);
	$clausulaRelaciones.=" ) ";
}


//PRIMERO LA LISTA DE NODOS


$sql="
SELECT 
aaa_actor.id as id, 
aaa_actor.descriptor as actor
FROM aaa_actor
";
if ($result = $mysqli->query($sql)) {
	#j($result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$listaActores[$row['id']]=$row['actor'];
		} 
		$result->close();
	} 
}
#j($listaActores);


$sql="
SELECT 
aaa_relacion.idaaa_actor as idActor, 
aaa_relacion.idaaa_actor2 as idSocio,
sum(aaa_tipoFuerza.descriptor) as cuenta 
FROM aaa_relacion  
INNER JOIN aaa_actor ON aaa_actor.id=aaa_relacion.idaaa_actor
INNER JOIN aaa_actor2 ON aaa_actor2.id=aaa_relacion.idaaa_actor2
INNER JOIN aaa_tipoFuerza ON aaa_tipoFuerza.id=aaa_relacion.idaaa_tipoFuerza
$clausulaFecha 
$clausulaActores3 
$clausulaRelaciones
AND aaa_relacion.idaaa_actor<>aaa_relacion.idaaa_actor2
GROUP BY idActor, idSocio
ORDER BY idActor ASC, idSocio ASC
";
//j($sql);
#j($sql);
$nodos=array();
$i=0;
if ($result = $mysqli->query($sql)) {
	#j($result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			#j($row);
			if( isset ( $nodos[$row['idActor']] ) ){ $nodos[$row['idActor']]+=$row['cuenta']; } else { $nodos[$row['idActor']]= (int) $row['cuenta']; }
			if( isset ( $nodos[$row['idSocio']] ) ){ $nodos[$row['idSocio']]+=$row['cuenta']; } else { $nodos[$row['idSocio']]= (int) $row['cuenta']; }
		} 
		$result->close();
	} 
}
arsort($nodos);

#equivalencias
$i=0;
foreach ($nodos as $key => $value) {
	$equivalencias[$key]=$i;
	$i++;
}
#j($equivalencias);


$sql=" 
	SELECT 
	aaa_relacion.idaaa_actor as idActor, 
	aaa_relacion.idaaa_actor2 as idSocio, 
	sum(aaa_tipoFuerza.descriptor) as cuenta 
	FROM aaa_relacion 
	INNER JOIN aaa_actor ON aaa_actor.id=aaa_relacion.idaaa_actor 
	INNER JOIN aaa_actor2 ON aaa_actor2.id=aaa_relacion.idaaa_actor2 
	INNER JOIN aaa_tipoFuerza ON aaa_tipoFuerza.id=aaa_relacion.idaaa_tipoFuerza 
	$clausulaActores1 
	$clausulaRelaciones 
	AND aaa_relacion.idaaa_actor<>aaa_relacion.idaaa_actor2 
	GROUP BY 
	idActor, 
	idSocio 
	ORDER BY cuenta 	DESC ";
$sqlRelacion=$sql;
//j($sql);
//j($sql1);
$i=0;
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if($row['idSocio']>$row['idActor']){
				$idActor=(int)$row['idActor'];
				$idSocio=(int)$row['idSocio'];
			} else {
				$idActor=(int)$row['idSocio'];
				$idSocio=(int)$row['idActor'];
			}
			$jefes[$row['idActor']]+=($row['cuenta']);
			$jefes[$row['idSocio']]+=( $row['cuenta']);
			if(!isset($relaciones[$idActor][$idSocio])){
				$relaciones[$idActor][$idSocio] = 0 ;
			} 
			$relaciones[$idActor][$idSocio] = $relaciones[$idActor][$idSocio] + ( (int) $row['cuenta'] );
			$pares[$idActor][]=$idSocio;
			$pares[$idSocio][]=$idActor;
			$i++;
		}
	} 
	$result->close();
} 


arsort($jefes);
$i=0;
$numeroJefes=(int) pow(count($jefes), .5) ;
foreach ($jefes as $key => $value) {
	$jefes2[$key]=$value;
	if($i>=$numeroJefes){
		break;
	}
	$i++;
}
$jefes=$jefes2;
$jefes=array_keys($jefes);
$jefes=array_flip($jefes);

foreach ($jefes as $key => $value) {
	$jefes[$key]++;
}

$listaJefes=array_keys($jefes);
#j($listaJefes);


foreach ($pares as $key => $value) {
	if(!in_array($key, $listaJefes)){
		$cuenta=count(array_intersect($listaJefes, $value));
		if($cuenta==1){
			#tengo que ver cual es
			foreach ($listaJefes as $jefe) {
				if(in_array($jefe, $value))
				$listaGrupos[$key]=$jefes[$jefe];
			}
		} else {
			$listaGrupos[$key]=count(array_intersect($listaJefes, $value));
			$listaGrupos[$key]=0;
		}
	} else {
		#es un jefe
		$listaGrupos[$key]=$jefes[$key];
	}
}

//j($listaGrupos);


#CREANDO JSON 
$i=0;

foreach ($nodos as $key => $value) {
	if($value>$maxPeso){$maxPeso=$value;}
}

foreach ($nodos as $key => $value) {
	$nodos2[$i]=$listaActores[$key];
	$nodosIdOriginal[$i]=$key;
	$lg[$i]=$listaGrupos[$key];
	$peso[$key]= $value;
	$peso[$key]= 2 + (10*($value/$maxPeso));
	$i++;
}
$nodos=$nodos2;

foreach ($relaciones as $key1 => $value1) {
	foreach ($value1 as $key2 => $value2) {
		$arcos[$equivalencias[$key1]][$equivalencias[$key2]]=$value2;
	}
}
foreach ($arcos as $key1 => $value1) {
	foreach ($value1 as $key2 => $value2) {
		$arcos2[$key1][$key2]=$value2;
	}
}
$arcos=$arcos2;




#SIMETRIZANDO
$matrizDeAdyacencia=array();

foreach ($arcos as $key1 => $value1) {
	foreach ($value1 as $key2 => $value2) {
		$matrizDeAdyacencia[$key1][$key2]=$value2;
		$matrizDeAdyacencia[$key2][$key1]=$value2;
	}
}
#j($matrizDeAdyacencia);

$grafo=array();
$i=0;
foreach ($matrizDeAdyacencia as $key1 => $value) {
	foreach ($value as $key2 => $value2) {
		$grafo[$key1][]=$key2;
	}
}

$componentes = listar_nodos_por_componente($grafo);
//j($componentes);

#pintandolos
$i=0;
foreach ($nodos as $key => $value) {
	$nodes[$i]['id']=$i;
	$nodes[$i]['idOriginal']=$nodosIdOriginal[$key];
	$nodes[$i]['nodeName']=$value ;
	$labels[$i]['label']=$value ;
	$nodes[$i]['group']=$lg[$key];
	$nodes[$i]['peso']=$peso[$nodosIdOriginal[$key]];
	$i++;
}

$i=0;
foreach ($arcos as $key => $value) {
	foreach ($value as $key2 => $value2) {
		$links[$i]['source']=$key;
		$links[$i]['target']=$key2;
		$links[$i]['value']=$value2;
		$i++;
	}
}


$nodos2_[0]['id']=0;
$nodos2_[0]['nodeName']="A";
$nodos2_[0]['group']=1;
$nodos2_[1]['id']=1;
$nodos2_[1]['nodeName']="B";
$nodos2_[1]['group']=1;
$nodos2_[2]['id']=2;
$nodos2_[2]['nodeName']="C";
$nodos2_[2]['group']=2;
$arcos2_[0]['source']=0;
$arcos2_[0]['target']=1;
$arcos2_[0]['value']=1;
$arcos2_[1]['source']=0;
$arcos2_[1]['target']=2;
$arcos2_[1]['value']=3;

$grafo2['nodes']=$nodos2_;
$grafo2['links']=$arcos2_;


$grafo=array();
$grafo['nodes']=$nodes;
$grafo['links']=$links;
$grafo['labels']=$labels;
$grafo['grupos']=$jefes;
/*
*/

$response = [
    'grafo' => $grafo,
    'message' => 'Exitosa recepcion de datos'
];
// Enviar la respuesta en formato JSON
echo json_encode($response);


die();



function listar_nodos_por_componente($grafo) {
	$visitados = [];
	$componentes = [];
	$contador_componentes = 0;

	foreach ($grafo as $nodo => $vecinos) {
		if (!isset($visitados[$nodo])) {
			$contador_componentes++;
			$componentes[$contador_componentes] = [];
			dfs_listar($nodo, $visitados, $componentes[$contador_componentes], $grafo);
		}
	}

	return $componentes;
}

function dfs_listar($nodo, &$visitados, &$componente, $grafo) {
	$visitados[$nodo] = true;
	$componente[] = $nodo;

	foreach ($grafo[$nodo] as $vecino) {
		if (!isset($visitados[$vecino])) {
			dfs_listar($vecino, $visitados, $componente, $grafo);
		}
	}
}
