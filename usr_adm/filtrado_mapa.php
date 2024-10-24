<?


//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador

$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){
	$esteAmbito=$_GET['esteAmbito']; 
} else { 
	$esteAmbito='fft';
}
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Mapa de '.$esteAmbito;



$misDatos=$_SESSION['fvp']['misDatos'];

$seccion="principal";

$nivelDeUsuario=$_SESSION['fvp']['nivel'];
#p($P,$nivelDeUsuario);

if($nivelDeUsuario>4){
	$disabled="disabled";
}
#p($P,$disabled);

if(isset($_GET['view'])){
	$view=$_GET['view'];
	$_SESSION['fvp']['view']=$view;
}
$_SESSION['fvp']['view']=$estaVista;
$view=$_SESSION['fvp']['view'];

$idUsuario=$_SESSION['fvp']['idUsuario'];

$clausulaMisDatos='';
$sql="SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '$estaTabla';";
#p($P,$sql);
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$listaCampos[]=$row['column_name'];
			if($misDatos=='mis'){
				if(substr($row['column_name'], 0,10)=='id_usuario'){
					$clausulaMisDatos =" AND ".$row['column_name']." = $idUsuario ";
				}				
				if($view=='adm_usuario'){
					$clausulaMisDatos =" AND id = $idUsuario ";
				}				
			}
		}
		$result->close();
	}
} 

$_SESSION['crud']['corrida']=0;
unset($_SESSION['fvp']['crud']);
unset($_SESSION['fvp']['idRegistro']);

in_array($view, $_SESSION['fvp']['tablasSeguras']) ? $tablaSegura=TRUE : $tablaSegura=FALSE ;


$sql="SELECT descriptor,alias FROM adm_alias";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$aliasCampos[$row['descriptor']]=$row['alias'];
		}
		$result->close();
	}
} 
$_SESSION['fvp']['aliasCampos']=$aliasCampos;
#p($P,$aliasCampos);

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: ../gen_login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

$sql="SELECT descriptor, alias, rango FROM adm_views ORDER BY alias ASC";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if($row['rango']<3){
				$_SESSION['fvp']['uniViews'][$row['descriptor']]=$row['alias'];
			}
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 
//p($P,$_SESSION['fvp']);
$sql = "SHOW COLUMNS FROM $estaVista";
//j($sql);
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if($c!='id' AND substr($c, 0,2)=='id' ){
		//$camposExternos[]='id'.trim(substr($c, 5,1000)).'_'.$esteAmbito;
		$camposExternos[]=$c;
	} else {
		$camposInternos[]=$c;
	}
}
/*
p($P,$camposInternos);
p($P,$camposExternos);
*/

$sql ="SELECT * FROM $estaVista WHERE id<>1 $clausulaMisDatos ORDER BY id DESC";
#echo $sql;
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			$array2Excel[]=implode("\t", $row);
			foreach ($row as $key => $value) {
				if($key=='id' OR ( strlen($key)>2 AND substr($key, 0,2)!='id') ){
					$tabla[$row['id']][$key]=$value;
					$titulos[$key]=$key;
					foreach ($camposExternos as $ce) {
						$arrayGenerador[$ce][$row[$ce]]=$row['descriptor_'.substr($ce, 3,1000)];
					}
				}
			}
		}
	} else {
		$panelAlerta=panel("warning",'Sin registros','La consulta no arrojó resultados');
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

$string2Excel=implode("\n", $array2Excel);

?>


<html>
<? include('../000_head.php');?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
<style>
	#map { position: absolute; top: 0; bottom: 0; width: 48%; margin-top: 120px; margin-left: 0px; }
</style>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<? 
			echo $panelAlerta;
			?>



			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="col-md-5">
							<div class="row">
								<div class="col-md-4">
									<label for="exampleFormControlTextarea1" class="form-label">Ámbito</label>
									<form action="" method="GET">
										<select class="form-select argumento-select" id="esteAmbito" name="esteAmbito" onchange="this.form.submit();">
											<option value="<?echo $esteAmbito?>"><?echo $esteAmbito?></option>
											<?	
											$opcionesAmbito=opcionesAmbitoMapas();
											foreach ($opcionesAmbito as $key => $value) { 
												echo '<option value="'.$key.'">'.$value.'</option>'; 
											}
											?>
										</select>
									</form>
								</div>
								<div class="col-md-4">
									<label for="exampleFormControlTextarea1" class="form-label">Tipo de búsqueda</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="tipoBusqueda" onblur="getCircleData(1);">
										<option value="O">Seleccione...</option>
										<option value="O">Extensa</option>
										<option value="A">Estricta</option>
									</select>
								</div>
								<div class="col-md-4">
									<label for="exampleFormControlTextarea1" class="form-label">Reiniciar Filtros</label>
									<button id="reiniciar" class="btn btn-warning btn-block btn-sm">Reiniciar</button>
								</div>

								<hr>

								<div class="col-md-6">
									<div class="row">
										<label for="exampleFormControlTextarea1" class="form-label">Año Inicial</label>
										<select class="form-select alto argumento-select" aria-label="Default select example" id="anoInicio" onblur="getCircleData(1);">
											<option value="2019">Seleccione...</option>
											<? for ($i=2019; $i < 2026; $i++) { 
												echo '<option value="'.$i.'">'.$i.'</option>';
											}
											?>
										</select>
									</div>
									<div class="row">
										<label for="exampleFormControlTextarea1" class="form-label">Mes Inicial</label>
										<select class="form-select alto argumento-select" aria-label="Default select example" id="mesInicio" onblur="getCircleData(1);">
											<option value="01/01">Seleccione...</option>
											<option value="01/01">Enero</option>
											<option value="02/01">Febrero</option>
											<option value="03/01">Marzo</option>
											<option value="04/01">Abril</option>
											<option value="05/01">Mayo</option>
											<option value="06/01">Junio</option>
											<option value="07/01">Julio</option>
											<option value="08/01">Agosto</option>
											<option value="09/01">Septiembre</option>
											<option value="10/01">Octubre</option>
											<option value="11/01">Noviembre</option>
											<option value="12/01">Diciembre</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<label for="exampleFormControlTextarea1" class="form-label">Año Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="anoFinal" onblur="getCircleData(1);">
										<option value="2026">Seleccione...</option>
										<? for ($i=2019; $i < 2026; $i++) { 
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Mes Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="mesFinal" onblur="getCircleData(1);">
										<option value="12/31">Seleccione...</option>
										<option value="01/31">Enero</option>
										<option value="02/28">Febrero</option>
										<option value="03/31">Marzo</option>
										<option value="04/30">Abril</option>
										<option value="05/31">Mayo</option>
										<option value="06/30">Junio</option>
										<option value="07/31">Julio</option>
										<option value="08/31">Agosto</option>
										<option value="09/30">Septiembre</option>
										<option value="10/31">Octubre</option>
										<option value="11/30">Noviembre</option>
										<option value="12/31">Diciembre</option>
									</select>
								</div>
							</div>

							<hr>

							<div class="row">
								<div class="col">
									<? 
									$adt=arrayDesplegableTotales();
									echo desplegableTotales($idCampo,$titulo,$adt[$esteAmbito]);
									?>
								</div>
							</div>

							<div class="col-md-12">
								<div class="row">
								<? 
								$arrayDesplegable=arrayDesplegable();
								print_r($arrayDesplegable);
								foreach ($arrayDesplegable[$esteAmbito] as $key => $titulo) {
									$idCampo="id".$key;
									echo desplegable($key,$titulo,$arrayGenerador[$key]);
								}
								?>
								</div>
							</div>
						</div>
						<div class="col-md-7">
							<div id="map"></div>
						</div>
					</div>
				</div>
			</div>



		</div>
	</main>
</body>
<?


function desplegable($id,$titulo,$array){
	asort($array);
	$Z='<div class="col col-sm-4"><label class="form-label">'.$titulo.'</label><select multiple class="form-select alto argumento-select campos" id="'.$id.'" onblur="getCircleData(\'SEL\');"><option value="">Seleccione...</option>';
	foreach ($array as $k=>$v) {
		$Z.= '<option value="'.$k.'">'.$v.'</option>';
	}
	$Z.='</select></div>';
	return $Z;	
}

function desplegableTotales($id,$titulo,$array){
	asort($array);
	$Z='<label class="form-label">Campo a totalizar en: <br><strong>'.$titulo.'</strong></label><select class="form-select alto argumento-select" id="campoTotalizacion" onblur="creaMarco();">';
	foreach ($array as $k=>$v) {
		$Z.= '<option value="'.$k.'">'.$v.'</option>';
	}
	$Z.='</select><hr>';
	return $Z;	
}




?>


</html>
<?
#include("000_navbarBottom.php");
?>

<script type="text/javascript">

l("Mapa inicial")
mapboxgl.accessToken = 'pk.eyJ1IjoiaWNvbGxhem9zIiwiYSI6ImNpbDVwcDN6ODAwMWd1aGx2dHdwNDZxdWEifQ.YkB4c807S2y_16k1jYgXuQ';
const bounds = [
  [-72.5, 6.9], // Southwest coordinates
  [-71.1, 8.7] // Northeast coordinates
  ];
  const map = new mapboxgl.Map({
  	container: 'map',
        projection: 'mercator', // Display the map as a globe, since satellite-v9 defaults to Mercator
        style: 'mapbox://styles/mapbox/streets-v9',
        style: 'mapbox://styles/mapbox/navigation-day-v1',
        zoom: 7,
        center: [-72.19, 7.70],
        maxBounds: bounds
    });

    // Token de acceso a Mapbox
    map.addControl(new mapboxgl.NavigationControl());
    //map.scrollZoom.disable();
    if (map.getLayer("circles")) {
    	map.removeLayer("circles");
    }

    $(document).ready(function() {
    	l("Iniciando");
    	desde="documentReady"
    	getCircleData(desde);
    });

    $("#reiniciar").click(function() {
    	$(".campos").find('option:selected').prop('selected', false);
    	desde="reiniciar"
    	getCircleData(desde);
    });



    function l(variable){ console.log(variable); }

    function tablita(titulo,array,aliasTitulo){
    	var tablita='<div class="col col-lg-3 col-md-4 col-sm-8 col-xs-12"><div class="card card-info" style="margin-bottom:14px;"><div class="card-header">'+aliasTitulo+'</div><div class="card-body"><figure class="highcharts-figure"><div id="grafico_'+titulo+'"></div></figure>';
		tablita+='</div></div></div>';	
		return tablita;
	}

	function creaMarco(desde){
		l("creando marco");
		l(desde);
		var id;
		var valor;
		var argumentos={};
		var inputs = $(".argumento-input");
		inputs.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		var selects = $(".argumento-select");
		selects.each(function() {
			//l($(this));
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		anoInicio=$("#anoInicio").val();
		mesInicio=$("#mesInicio").val();
		anoFinal=$("#anoFinal").val();
		mesFinal=$("#mesFinal").val();

		getCircleData(desde);
	}


	$("#actualizar").click(function() {
		desde="actualizar"
		getCircleData(desde);
	});




// Función para buscar los datos
function getCircleData(desde) {
	l("getCircleData");
		l("Recibiendo argumentos");
		l(desde);
		var id;
		var valor;
		var argumentos={};
		var inputs = $(".argumento-input");
		inputs.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		var selects = $(".argumento-select");
		selects.each(function() {
			//l($(this));
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		anoInicio=$("#anoInicio").val();
		mesInicio=$("#mesInicio").val();
		anoFinal=$("#anoFinal").val();
		mesFinal=$("#mesFinal").val();


	l(argumentos)
	$.ajax({
		url: "filtrado_mapa_select.php",
		method: "POST",
		data: {
			argumentos: argumentos
		},
		dataType: "json",
		success: function(data) {
			l("Recibiendo Data");
			l(data);
			updateCirclesLayer(data);
		}
	});
}

// Función para actualizar la capa de círculos
function updateCirclesLayer(data) {
	l("Actualizando el layer de circulos")
	l(data.features);
    // Eliminar la capa anterior (si existe)
    if (map.getLayer("circles")) {
    	map.removeLayer("circles");
    } else {
    	//alert();
    }
    if (map.getSource("circles")) {
    	map.removeSource("circles");
    } else {
    	//alert();
    }

    // Crear la capa de círculos
    map.addLayer({
    	id: "circles",
    	type: "circle",
    	source: {
    		type: "geojson",
    		data: {
    			type: "FeatureCollection",
    			features: data.features
    		}
    	},
    	paint: {
    		"circle-color": ["get", "color"],
    		"circle-opacity": 0.1,
    		"circle-stroke-color": ["get", "color"],
    		"circle-stroke-width": 5,
    		"circle-radius": ["get", "radius"]
    	}
    });
}


</script>

