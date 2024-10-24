<?
include('../000_conexion.php');
session_start();
$mysqli=conectar($datosConexion);

unset($_SESSION['salida']); ##salida del generador
$P=1; //define si los pre se ven o no


// Obtener el cuerpo de la solicitud
$json = file_get_contents('php://input');
// Si hay solicitud la captura en caso contrario corre normal (para poder depurar)

header('Content-Type: application/json');
	// Decodificar el JSON recibido
$data = json_decode($json, true);
	// Verificar si la decodificación fue exitosa
if (json_last_error() !== JSON_ERROR_NONE) {
	$actor=12;
	$actor2=14;
	$relaciones=[2,3,4,5,6,7,8,9];
} else {
	$argumentos = $data ?? null;
	$actor=(int)$argumentos['actor'];
	$actor2=(int)$argumentos['actor2'];
	$relaciones=$argumentos['relaciones'];
}

$esteAmbito=$argumentos['esteAmbito'];
$estaTabla='aaa_relacion';
$estaVista='v_'.$estaTabla;
$seccion="principal";

$idUsuario=$_SESSION['fvp']['idUsuario'];

count ($relaciones)>0 ? $clausulaRelaciones = " AND ( idaaa_tipoRelacion = " . implode (" OR idaaa_tipoRelacion = ", $relaciones). " ) " : $clausulaRelaciones="";
#j($clausulaRelaciones);

//PRIMERO LA LISTA DE NODOS

$sql=" SELECT aaa_actor.id as id, aaa_actor.descriptor as actor FROM aaa_actor WHERE id>1; ";
$nodos[0]="00";
$nodos[1]="11";
$i=2;
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$nodos[$row['id']]=$row['actor'];
			$i++;
		} 
		$result->close();
	} 
}
#j($nodos);

$sql="SELECT 
aaa_relacion.idaaa_actor as idActor, 
aaa_relacion.idaaa_actor2 as idSocio,
sum(aaa_tipoFuerza.descriptor) as cuenta 
FROM aaa_relacion  
INNER JOIN aaa_actor ON aaa_actor.id=aaa_relacion.idaaa_actor
INNER JOIN aaa_actor2 ON aaa_actor2.id=aaa_relacion.idaaa_actor2
INNER JOIN aaa_tipoFuerza ON aaa_tipoFuerza.id=aaa_relacion.idaaa_tipoFuerza
WHERE (1=1)
$clausulaRelaciones
AND aaa_relacion.idaaa_actor<>aaa_relacion.idaaa_actor2
GROUP BY idActor, idSocio
ORDER BY idActor ASC, idSocio ASC
";

$i=0;
if ($result = $mysqli->query($sql)) {
	#j($result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			#j($row);
			$arcos[$row['idActor']][$row['idSocio']] ? $arcos[$row['idActor']][$row['idSocio']]+=$row['cuenta'] : $arcos[$row['idActor']][$row['idSocio']]= (int) $row['cuenta']; 
			$arcos[$row['idSocio']][$row['idActor']] ? $arcos[$row['idSocio']][$row['idActor']]+=$row['cuenta'] : $arcos[$row['idSocio']][$row['idActor']]= (int) $row['cuenta']; 
		} 
		$result->close();
	} 
}
#j($arcos);

$grafo = new Grafo($arcos, $nodos);
#j($grafo);
$arcosCaminos = $grafo->obtenerArcosEnCaminosMasCortos($actor, $actor2, 100); // Cambia los índices según tus nodos
foreach ($arcosCaminos as $key => $value) {
	foreach ($value as $key2 => $value2) {
		$pares[$value2[0]][$value2[1]]++;
		$activos[]=$value2[0];
		$activos[]=$value2[1];
	}
}
$activos=array_unique($activos);
$activos=array_values($activos);

$i=0;
foreach ($nodos as $key => $value) {
	$nodes[$i]['id']=$key;
	$nodes[$i]['nodeName']=$nodos[$key];
	$nodes[$i]['group']=1;
	$nodes[$i]['peso']=10;
	in_array($key, $activos) ? $nodes[$i]['activo']=1 : $nodes[$i]['activo']=0;
	in_array($key, [$actor,$actor2]) ? $nodes[$i]['peso']=10 : $nodes[$i]['peso']=3;
	in_array($key, [$actor,$actor2]) ? $nodes[$i]['group']=2 : $nodes[$i]['group']=2;
	$i++;
}
#p($P,$nodes);
$i=0;
#j($pares);
foreach ($pares as $key=>$value) {
	foreach ($value as $key2 => $value2) {
		$links[$i]['source']=$key;
		$links[$i]['target']=$key2;
		$links[$i]['value']=$value2;
		$i++;
	}
}
#p($P,$links);

$grafo=array();
$grafo['nodes']=$nodes;
$grafo['links']=$links;
#p($P,$grafo);

$response = [
	'grafo' => $grafo
];
// Enviar la respuesta en formato JSON
echo json_encode($response);



die();

class Grafo {
    private $lista; // Lista de adyacencia
    private $nodos; // Nombres de los nodos

    public function __construct($lista, $nodos) {
    	$this->lista = $lista;
    	$this->nodos = $nodos;
    }

    public function obtenerArcosEnCaminosMasCortos($inicio, $fin, $n) {
    	$caminos = [];
    	$this->buscarCaminos($inicio, $fin, [], $caminos, 0, $n);

        // Extrae solo los arcos de los caminos encontrados
    	$arcosEnCaminos = [];
    	foreach ($caminos as $camino) {
    		$arcosEnCaminos[] = $camino['arcos'];
    	}

        // Ordenar los caminos por cantidad de pasos
    	usort($arcosEnCaminos, function($a, $b) {
    		return count($a) - count($b);
    	});

        return array_slice($arcosEnCaminos, 0, $n); // Retorna solo los N caminos
    }

    private function buscarCaminos($actual, $fin, $caminoActual, &$caminos, $pesoActual, $n) {
    	$caminoActual[] = $actual;

    	if ($actual === $fin) {
            // Almacena los arcos en el camino
    		$arcos = [];
    		for ($i = 0; $i < count($caminoActual) - 1; $i++) {
    			$arcos[] = [$caminoActual[$i], $caminoActual[$i + 1]];
    		}
    		$caminos[] = ['arcos' => $arcos, 'peso' => $pesoActual];
    		return;
    	}

    	foreach (array_keys($this->lista[$actual]) as $vecino) {
    		if (!in_array($vecino, $caminoActual) && count($caminos) < $n) {
    			$this->buscarCaminos($vecino, $fin, $caminoActual, $caminos, $pesoActual + $this->lista[$actual][$vecino], $n);
    		}
    	}
    }
}

