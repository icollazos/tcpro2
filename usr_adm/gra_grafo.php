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
$nombrePagina='Generador de Grafos';

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
<script src="d3.min.js"></script>
<script src="frn_funciones.js"></script> <!-- funciones de selects indispensables-->

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 0px;">
						<div class="col">
							<div class="row">
								<div class="col-2">
									<div class="row">
										<h5 class="form-label" style="margin-top: -20px;">Filtros</h5>
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
									<label for="exampleFormControlTextarea1" class="form-label">Excepto</label>
									<input type="text" class="form-control" id="excepto" placeholder="Escriba palabras separadas por comas" onblur="creaSalida();">
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
									<div id="graph-container" style="overflow-x: auto; white-space: nowrap;">
										<div id="fig" style="display: inline-block; width: 1200px; height: 900px;"></div>
									</div>
									<!--<input type="range" id="weight-slider" min="0" max="100" value="0" step="1" style="width: 100%;">-->
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
	});

	let grafo;
	
	document.getElementById("weight-slider")
	.addEventListener("input", function() {
    const threshold = parseInt(this.value); // Obtener el valor del slider
    const filteredNodes = grafo.nodes.filter(node => node.peso >= threshold);
    const filteredLinks = grafo.links.filter(link => 
    	filteredNodes.some(node => node.id === link.source) && 
    	filteredNodes.some(node => node.id === link.target)
    	);
    renderizarGrafo({ nodes: filteredNodes, links: filteredLinks });
});

	function creaSalida() {
		var argumentos={}
		var id;
		var valor;
		var argumentos={};
		var selects = $(".argumento-select");
		selects.each(function() {
			let id = $(this).attr("id");
			let valor = $(this).val();
			argumentos[id] = valor;
		});
		argumentos['keywords']=$("#keywords").val();
		argumentos['excepto']=$("#excepto").val();
		argumentos['funcionLlamada']="buscaData";
		postData('gra_grafo_funciones.php', { argumentos: argumentos })
		.then(data => {
			l(data);
			renderizarGrafo(data);
		});
	}


	function renderizarGrafo(grafo) {
		d3.select("#fig").selectAll("*").remove();
		const width = 1300;
		const height = 750;

		const svg = d3.select("#fig")
		.append("svg")
		.attr("width", width)
		.attr("height", height);

		const simulation = d3.forceSimulation()
		.force("link", d3.forceLink().id(d => d.id).distance(1))
		.force("charge", d3.forceManyBody().strength(-50))
		.force("center", d3.forceCenter(width / 2, height / 2));


		const link = svg.append("g")
		.attr("class", "links")
		.selectAll("line")
		.data(grafo.links)
		.enter().append("line")
		.attr("stroke-width", d=>d.value) 
		.attr("stroke", "lightgray") 
		.attr("class", "link");

		const node = svg.append("g")
		.attr("class", "nodes")
		.selectAll("circle")
		.data(grafo.nodes)
		.enter().append("circle")
		.attr("r", 5)
		.attr("r", d => d.peso)
		.attr("fill", d => d.color)
		.attr("stroke", "gray")
		.attr("stroke-width", 1)
		.attr("class", "node")
		.call(d3.drag()
			.on("start", dragstarted)
			.on("drag", dragged)
			.on("end", dragended));

		node.append("title")
		.text(d => d.nodeName);


		const nodeText = svg.append("g")
		.attr("class", "node-labels")
		.selectAll("text")
		.data(grafo.nodes)
		.enter().append("text")
		.attr("class", "node-label")
		.attr("dx", 0) 
		.attr("dy", ".35em") 
		.attr("font-size", "12px") 
		.attr("fill", "black") 
		.text(d => d.nodeName); 


		simulation
		.nodes(grafo.nodes)
		.on("tick", ticked);

		simulation.force("link")
		.links(grafo.links);


		function ticked() {
			const margin = 20; 

			link
			.attr("x1", d => Math.max(margin, Math.min(width - margin, d.source.x)))
			.attr("y1", d => Math.max(margin, Math.min(height - margin, d.source.y)))
			.attr("x2", d => Math.max(margin, Math.min(width - margin, d.target.x)))
			.attr("y2", d => Math.max(margin, Math.min(height - margin, d.target.y)));

			node
			.attr("cx", d => Math.max(margin, Math.min(width - margin, d.x)))
			.attr("cy", d => Math.max(margin, Math.min(height - margin, d.y)));

			nodeText
			.attr("x", d => d.x + 10)
			.attr("y", d => d.y + 4);
		}

		function dragstarted(event, d) {
			if (!event.active) simulation.alphaTarget(0.3).restart();
			d.fx = d.x;
			d.fy = d.y;
		}

		function dragged(event, d) {
			d.fx = event.x;
			d.fy = event.y;
		}

		function dragended(event, d) {
			if (!event.active) simulation.alphaTarget(0);
			d.fx = null;
			d.fy = null;
		}
	}


</script>

