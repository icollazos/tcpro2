<?

//inicializando
include('../000_conexion.php');
session_start();
unset($_SESSION['salida']); ##salida del generador
$P=0; //define si los pre se ven o no

$arg=$_POST['argumentos'];
$esteAmbito=$arg['esteAmbito'];
$estaTabla='aaa_'.$esteAmbito;
$estaVista=$estaTabla;

$seccion="principal";

$campoTotalizacion=$arg['campoTotalizacion'];

$mysqli=conectar($datosConexion);
$idUsuario=$_SESSION['fvp']['idUsuario'];
$tipoBusqueda=' OR  ';
if(isset($arg['tipoBusqueda'])){
	$tipoBusqueda=$arg['tipoBusqueda'];
	if($tipoBusqueda=='O'){
		$tipoBusqueda=" OR  ";
	} else {
		$tipoBusqueda=" AND ";
	}
};

$cm=configMapa($esteAmbito);
$descriptorCampoMunicipio='descriptor_'.$cm;
$idCampoMunicipio='id_'.$cm;

$clausulaFecha=' WHERE ';
if(isset($arg['anoInicio']) AND isset($arg['anoFinal']) AND isset($arg['mesInicio']) AND isset($arg['mesFinal']) ){
	$anoInicio=$arg['anoInicio']; 
	$mesInicio=$arg['mesInicio']; 
	$anoFinal=$arg['anoFinal'];
	$mesFinal=$arg['mesFinal'];
	$fechaInicio=$anoInicio.'/'.$mesInicio;
	$fechaFinal=$anoFinal.'/'.$mesFinal;
	$clausulaFecha=" WHERE v_$estaVista.fecha >= '$fechaInicio' AND v_$estaVista.fecha <= '$fechaFinal' ";
}


$q=0;
$longAmbito=strlen($esteAmbito);
$q=0;
foreach ($arg as $key => $value) {
	if( substr($key, 0, 2)=='id'){
		$k.= $key.' ';
		$camposExternos[$q]['key']=$key;
		$camposExternos[$q]['ref']='id'.substr($key, 5,1000).'_'.$esteAmbito;
		$camposExternos[$q]['ref']=$key;
		$q++;
	}
}
/*
j($camposExternos);
p($P,json_encode($camposExternos));
die();
*/
//$camposExternos=explode(",", "socialTipoActividad_social,socialEstatus_social,socialEnte_social,socialPsuv_social,socialNuevoVotante_social,socialDiscapacidad_social,socialVota_social");
foreach ($camposExternos as $key => $value) {
	if(count($arg[$value['key']]>0)){
		$c=' ( v_'.$estaVista.'.'.$value['ref'].' = '.implode(" OR v_$estaVista.".$value['ref'].' = ', $arg[$value['key']] ).' ) ';
		$ap .= $c .  $tipoBusqueda ;
	};
}
if(strlen($ap)>0){
	$ap=' AND ( '.substr($ap, 0,-7).') )';
}

$id=1;
$whereBase='';
$clausulaWhere=" AND v_$estaVista.id>1 ".$ap;	

/*
$json=json_encode($clausulaWhere);
echo $json;
die();
*/


$id=2;
if($_POST['id']!=''){
	$id=$_POST['id'];
};



$sql = "SHOW COLUMNS FROM v_$estaTabla";
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if(substr($c, 0,2)!='id' ){
		$campos[]=$c;
	}
}


//$camposInternos=explode(",", "id,descriptor,fechaHora,fecha,apellido,nombre,cedula,telefono,nucleoFamiliar");
$tabla=array();
$rechazo=rechazos(basename($_SERVER['PHP_SELF']));
foreach ($campos as $key => $value) {
	if(in_array($value, $rechazo)){
		unset($campos[$key]);
	}
}

$campoTotalizacion=='id'? $clausulaTotalizacion="count(v_$estaTabla.id)" : $clausulaTotalizacion="sum(v_$estaTabla.$campoTotalizacion)";


$sql="SELECT v_$estaTabla.$descriptorCampoMunicipio as municipio, aaa_municipio.lng as lng, aaa_municipio.lat as lat, $clausulaTotalizacion as cuenta FROM aaa_municipio INNER JOIN v_$estaTabla ON aaa_municipio.id=v_$estaTabla.$idCampoMunicipio $clausulaFecha $clausulaWhere GROUP BY aaa_municipio.descriptor ORDER BY cuenta DESC ";
$sql2.=$sql;
$max=0;
$min=999999999;
$colores=explode(',', 'purple');
if ($result = $mysqli->query($sql)) {
	$i=0;
	if ($result->num_rows> 0){
		$q=0;
		while ($row = $result->fetch_assoc()){
			$circlesData[$q]['id']=$q;
			$circlesData[$q]['municipio']=$row['municipio'];
			$circlesData[$q]['lng']=$row['lng'];
			$circlesData[$q]['lat']=$row['lat'];
			$circlesData[$q]['color']=$colores[rand(0,count($colores)-1)];
			$circlesData[$q]['cantidad']=(int)$row['cuenta']*rand(1,1000);
			$cuentasMinMax[]=$circlesData[$q]['cantidad'];

			$q++;
		}
	} 
	$result->close();
} 
	//j($sql);
//j($cuentasMinMax);
$max=max($cuentasMinMax);
$min=min($cuentasMinMax);
$rangos=10;
$dif=$max-$min;
$frac=$dif/$rangos;
$factor=5;
foreach ($circlesData as $key => $value) {
	$circlesData[$key]['radius']=1*$factor;
	for ($i=0; $i < $rangos; $i++) { 
		if($circlesData[$key]['cantidad']>($min+($i*$frac))){ 
			$circlesData[$key]['radius']=(1+$i)*$factor;
		}
	}
}
//j($circlesData);

// Convertir los datos a formato GeoJSON
$geojsonFeatures = [];
foreach ($circlesData as $key=>$circle) {
	$geojsonFeature = [
		"type" => "Feature",
		"geometry" => [
			"type" => "Point",
			"coordinates" => [$circle["lng"], $circle["lat"]]
		],
		"properties" => [
            "id" => $circle["id"], // Incluir ID si lo necesitas en el mapa
            "cantidad" => $circle["cantidad"],
            "radius" => ((int)$circle["radius"]),
            "municipio" => $circle["municipio"],
            "color" => $circle["color"],
        ]
    ];
    $geojsonFeatures[] = $geojsonFeature;
}

$geojson = [
	"type" => "FeatureCollection",
	"features" => $geojsonFeatures
];

// Enviar la respuesta JSON
//header('Content-Type: application/json');
j($geojson);

die();
