<?
//CONECTA A LA BASE DE DATOS
include('../000_conexion.php');
include('api/api_funcionesComunes.php');
$mysqli=conectar($_SESSION['datosConexion']);

$P=1;
if (isset($_GET['proyecto'])) {
	$proyecto = $_GET['proyecto'];
	$clausulaProyecto=" AND id_proyecto_seguimiento=$proyecto ";
	$P=0;
}
/*
$sql="DELETE FROM aaa_texto WHERE id  >1";
if ($result = $mysqli->query($sql)) {}
*/
$sql="SELECT id as idItem, descriptor as dItem, q as query, id_seguimiento_item as idSeguimiento, descriptor_seguimiento_item as dSeguimiento, id_fuente_seguimiento as idFuente, descriptor_fuente_seguimiento as dFuente FROM v_aaa_item WHERE id > 1  $clausulaProyecto AND id_tipoSeguimiento_fuente = 2";

$items=array();
if ($result = $mysqli->query($sql)) 
{
	if ($result->num_rows> 0)
	{
		while ($row = $result->fetch_assoc())
		{
			$items[$row['idItem']]['idItem']=$row['idItem'];
			$items[$row['idItem']]['idFuente']=$row['idFuente'];
			$items[$row['idItem']]['dItem']=$row['dItem'];
			$items[$row['idItem']]['query']=$row['dItem'];
			if($row['query']!=''){
				$items[$row['idItem']]['query']=$row['query'];
			}
		}
	}		
	$result->close();
}
foreach ($items as $item) {
	actualizar($item,$P);
}
die();


header('Content-Type: application/json');
echo json_encode(['resultado' => $resultado]);

die();

function actualizar($item,$P){

	$mysqli=conectar($_SESSION['datosConexion']);

	$sql="SELECT aaa_dicDescarte.id, aaa_dicDescarte.descriptor FROM aaa_dicDescarte WHERE aaa_dicDescarte.idaaa_tipoIdioma='0' OR aaa_dicDescarte.idaaa_tipoIdioma='2'";
	$dicDescarte=array();
	if ($result = $mysqli->query($sql)) 
	{
		if ($result->num_rows> 0)
		{
			while ($row = $result->fetch_array())
			{
				$dicDescarte[$row[0]]=$row[1];
			}
		}		
		$result->close();
	}
	$fecha=date("Y-m-d", strtotime('now') );
	$fecha=substr($fecha, 4, 6);
	$mes=substr($fecha, 0,3);
	$mes=str_replace(array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"), array("01","02","03","04","05","06","07","08","09","10","11","12"), $mes);
	$fecha="2017".$mes."-". substr($fecha, 4, 2);
	$analizado='NO';
	$estado='PENDIENTE';

	$idItem=$item['idItem'];
	$query=trim($item['query']);
	$query=strip_tags($query);
	$query=str_replace(" ", "%20", $query);

	/*
	$sql="DELETE FROM texto WHERE idaaa_item='$idItem'";
	if ($result = $mysqli->query($sql)) {}
	*/

	switch ($item['idFuente']) {
		case 2:
		$url="https://newsapi.org/v2/everything?apiKey=7cd7477f1a52414ebf86774d7859febf&language=es&q=$query";
		p($P,$url);
		$P=0;
		ejecutarNewsApi($url,$idItem,$P);
		break;
		case 3:
		$query=str_replace("|", "&", $query);
		$query=str_replace(" ", "%20", $query);
		$url="https://newsdata.io/api/1/news?apikey=pub_51161c909c303f52b197087bc13d670a2cada&$query";
		p($P,$url);
		ejecutarNewsData($url,$idItem,$P);
		break;
		default:
		break;
	}
	$url .= $item['item'];
	mysqli_close($mysqli);
}

