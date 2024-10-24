<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);
$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Nube de categorías';

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
$sql="SELECT column_name
FROM INFORMATION_SCHEMA.COLUMNS
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


$sql = "SHOW COLUMNS FROM $estaTabla";
#echo $sql;
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
#En esta linea se genera un error debido a que en 000_configurador en el arrau de ambitos se llama a una tabla que no existe
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if($c!='id' AND substr($c, 0,2)=='id' ){
		$camposExternos[]='id'.trim(substr($c, 5,1000)).'_'.$esteAmbito;
	} else {
		$camposInternos[]=$c;
	}
}
/*
p($P,$camposInternos);
p($P,$camposExternos);
*/

$sql ="SELECT * FROM $estaVista WHERE id<>1 $clausulaMisDatos ORDER BY id DESC";
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
<script src="https://code.highcharts.com/modules/wordcloud.js"></script>
<script src="frn_funciones.js"></script> <!-- funciones de selects indispensables-->
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="col">
							<div class="row">
								<div class="col-4">
									<div class="row">
										<h5 class="form-label">Filtros</h5>
									</div>
									<label for="exampleFormControlTextarea1" class="form-label">Proyecto</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="proyecto" onchange="selSeguimiento();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Seguimiento</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="seguimiento" onchange="selVariable();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Variable</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="variable" onchange="selValor();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Valores</label>
									<select class="form-select argumento-select"  style="height: 200px;" aria-label="Default select example" id="valor" multiple onchange="creaSalida();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Buscar por palabra</label>
									<input type="text" class="form-control" id="keywords" placeholder="Escriba palabras separadas por comas" onblur="creaSalida();">
									<div class="row">
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Año Inicial</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="anoInicio" onchange="creaSalida();">
												<? for ($i=2023; $i < 2030; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
											</select>
										</div>
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Mes Inicial</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="mesInicio" onchange="creaSalida();">
												<option value="01/01">Enero</option><option value="02/01">Febrero</option><option value="03/01">Marzo</option><option value="04/01">Abril</option><option value="05/01">Mayo</option><option value="06/01">Junio</option><option value="07/01">Julio</option><option value="08/01">Agosto</option><option value="09/01">Septiembre</option><option value="10/01">Octubre</option><option value="11/01">Noviembre</option><option value="12/01">Diciembre</option>
											</select>
										</div>
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Año Final</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="anoFinal" onchange="creaSalida();">
												<? for ($i=2023; $i < 2030; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
											</select>
										</div>
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Mes Final</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="mesFinal" onchange="creaSalida();">
												<option value="01/31">Enero</option><option value="02/28">Febrero</option><option value="03/31">Marzo</option><option value="04/30">Abril</option><option value="05/31">Mayo</option><option value="06/30">Junio</option><option value="07/31">Julio</option><option value="08/31">Agosto</option><option value="09/30">Septiembre</option><option value="10/31">Octubre</option><option value="11/30">Noviembre</option><option value="12/31">Diciembre</option>
											</select>
										</div>							
									</div>

								</div>
								<div class="col">
									<div id="miGrafica" style="width:100%; height:600px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>



<script type="text/javascript">

		$(document).ready(function() {
			selProyecto();
			creaSalida();
		});

		function creaSalida(x){
			l("Creando Marco");
			var id;
			var valor;
			var argumentos={};
			var selects = $(".argumento-select");
			selects.each(function() {
				var id = $(this).attr("id");
				var valor = $(this).val();
				argumentos[id] = valor;
			});
			l("argumentos");
			l(argumentos);
			argumentos['funcionLlamada']="buscaData";
			argumentos['keywords']=$("#keywords").val();
				postData('gra_nubeCategorias_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos Tabla")
				l(data);
				generarNubeDePalabras(data);

			});
		}

		function generarNubeDePalabras(datosJSON) {
			Highcharts.chart('miGrafica', {
				series: [{
					type: 'wordcloud',
					data: datosJSON,
					color: '#FF5733',
					placementStrategy: 'center', 
					rotation: {
						from: 0,
						to: 0 
					},
					name: 'Palabras',
					minSize: '10%',
					maxSize: '25%',
				}],
				title: {
					text: 'Nube de Palabras'
				},
				tooltip: {
					pointFormat: '<b>{point.name}</b>: {point.weight}'
				}
			});
		}

</script>

