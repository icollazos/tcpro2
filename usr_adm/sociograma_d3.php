<?
include('../000_conexion.php');
session_start();
$mysqli=conectar($datosConexion);
unset($_SESSION['salida']); ##salida del generador

$P=0; //define si los pre se ven o no
//p($P,$mysqli);
//die();

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Sociograma';

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
p($P,$sql);
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
//p($P,$aliasCampos);

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
#p($P,$_SESSION['fvp']);

$sql = "SHOW COLUMNS FROM $estaVista";
#j($sql);
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
#En esta linea se genera un error debido a que en 000_configurador en el arrau de ambitos se llama a una tabla que no existe
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
#j("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
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

#carga lista de actores
$sql ="SELECT aaa_actor.id as idActor, aaa_actor.descriptor as actor FROM aaa_actor WHERE id<>1 AND ( aaa_actor.id IN (SELECT aaa_relacion.idaaa_actor FROM aaa_relacion) OR aaa_actor.id IN (SELECT aaa_relacion.idaaa_actor2 FROM aaa_relacion) ) ORDER BY descriptor ASC";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$actores[$row['idActor']]=$row['actor'];
		}
		$result->close();
	}
} 

$sql ="SELECT idaaa_actor AS idActor, SUM(idaaa_tipoCalidad) as cuenta FROM aaa_relacion WHERE id<>1 GROUP BY idActor ORDER BY idActor ASC";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$cuentas[$row['idActor']]=$row['cuenta'];
		}
		$result->close();
	}
} 
$sql ="SELECT idaaa_actor2 AS idActor, SUM(idaaa_tipoCalidad) as cuenta FROM aaa_relacion WHERE id<>1 GROUP BY idActor2 ORDER BY idActor2 ASC";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$cuentas[$row['idActor']]+=$row['cuenta'];
			break;
		}
		$result->close();
	}
} 
#j($cuentas);
$maximo=max($cuentas);

$exponente=2;

for ($rp=1; $rp < 40; $rp++) { 
	$pesoActual=pow($rp,$exponente);
	if($pesoActual>$maximo){
		break;
	}
	$listaPesos[]=$pesoActual;
}
#j($listaPesos);

$sql ="SELECT COUNT(id) as cuenta FROM aaa_actor WHERE id<>1";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$totalActores=$row['cuenta'];
		}
		$result->close();
	}
} 

$exponente=2;
for ($rp=1; $rp < 40; $rp++) { 
	$numNodosActual=pow($rp,$exponente);
	if($numNodosActual>$totalActores){
		break;
	}
	$listaNumNodos[]=$numNodosActual;
}


$sql ="SELECT id,descriptor FROM aaa_tipoRelacion WHERE id<>1 AND id<10";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$tiposRelacion[$row['id']]=$row['descriptor'];
		}
		$result->close();
	}
} 




$sql="
SELECT 
v_aaa_actor.id as id, 
v_aaa_actor.descriptor as actor,
v_aaa_actor.descriptor_tipoActor_actor as tipoDeActor
FROM v_aaa_actor
WHERE id>1
ORDER BY id ASC
";
if ($result = $mysqli->query($sql)) {
	#j($result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$actoresModal[$row['id']]['id']=$row['id'];
			$actoresModal[$row['id']]['actor']=$row['actor'];
			$actoresModal[$row['id']]['tipoDeActor']=$row['tipoDeActor'];
		} 
		$result->close();
	} 
}

$sql="
SELECT 
v_aaa_relacion.id as id,
v_aaa_relacion.descriptor_actor_relacion as actor1,
v_aaa_relacion.descriptor_actor2_relacion as actor2,
SUM(v_aaa_relacion.descriptor_tipoFuerza_relacion) as fuerzaDeRelacion
FROM v_aaa_relacion
WHERE id>1
GROUP BY actor1, actor2
ORDER BY id ASC
";
if ($result = $mysqli->query($sql)) {
	#j($result);
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if(!isset($relaciones[$row['actor1']][$row['actor2']])) { $relaciones[$row['actor1']][$row['actor2']]=0;}
			if(!isset($relaciones[$row['actor2']][$row['actor1']])) { $relaciones[$row['actor2']][$row['actor1']]=0;}
			$relaciones[$row['actor1']][$row['actor2']]+=$row['fuerzaDeRelacion'];
			$relaciones[$row['actor2']][$row['actor1']]+=$row['fuerzaDeRelacion'];
		} 
		$result->close();
	} 
}
//p(1,$relaciones);
//p(1,$actoresModal);


?>


<html>
<!DOCTYPE html>
<html>
<head>

	<meta charset='utf-8' />
	<title>SOCIOGRAMAS</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sidebars/">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>

	<link href="../bs/sidebars.css" rel="stylesheet">
	<script src="../bs/sidebars.js"></script>
	<script type="text/javascript" src="../bs/moment.js"></script>
	<script type="text/javascript" src="../bs/datetime.js"></script>
	<link rel="stylesheet" href="../bs/datetime.css" />
	<link rel="stylesheet" href='../bs/css/theme_lux.css' />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<style type="text/css">
		/* Works on Firefox */
		* {
			scrollbar-width: thin;
			scrollbar-color: grey white;
		}

		/* Works on Chrome, Edge, and Safari */
		*::-webkit-scrollbar {
			width: 5px;
		}

		*::-webkit-scrollbar-track {
			background: orange;
		}

		*::-webkit-scrollbar-thumb {
			background-color: white;
			border-radius: 2px;
			border: 3px solid white;
		}

		.chart {
			margin-bottom: 50px;
		}
		.scroll{
			overflow-y: scroll;
			max-height: 950px;
		}
		.rot{
			-webkit-transform: rotate(-90deg); 
			-moz-transform: rotate(-90deg);
			display: inline-block;
		}
		.danger, .btn-danger, .bg-danger{
			background-color: #C62828;
		}
		.warning, .btn-warning, .bg-warning{
			background-color: #F9A825;
		}
		.success, .btn-success, .bg-success{
			background-color: #2E7D32;
		}
		.info, .btn-info, .bg-info{
			background-color: #00838F;
		}
		.btn-datatable{
			margin-left: 5px;
			margin-right: 5px;
		}

	</style>

	<style>


		body, h1, h2 {
			color: #444;
			font-family: 'Helvetica Neue', Helvetica, sans-serif;
			font-weight: 300;
		}
		#graph {
			float: left;
			position: relative;
		}
		#notes {
			float: left;
			margin-left: 20px;
		}
		h1, h2 {
			margin: 0;
		}
		h1 {
			font-size: 1.4em;
			margin-bottom: 0.2em;
		}
		h2 {
			font-size: 1.1em;
			margin-bottom: 1em;
		}
		.artwork img {
			border: 1px solid #fff;
			-webkit-box-shadow: 0 3px 5px rgba(0,0,0,.3);
			-moz-box-shadow: rgba(0,0,0,.3) 0 3px 5px;
			border-color: #a2a2a2    9;
		}
		ul {
			list-style: none;
			padding-left: 0;
		}
		li {
			padding-top: 0.2em;
		}
		.node circle, circle.node {
			cursor:       pointer;
			fill:         #ccc;
			stroke:       #fff;
			stroke-width: 1px;
		}
		.edge line, line.edge {
			cursor:       pointer;
			stroke:       #aaa;
			stroke-width: 2px;
		}
		.labelNode text, text.labelNode {
			cursor:       pointer;
			fill:        #444;
			font-size:   11px;
			font-weight: normal;
		}
		ul.connection {
			background-color: #f0f0f0;
			border: 1px solid #ccc;
			border-radius: 8px;
			box-shadow: 0 5px 10px rgba(0,0,0,0.2);
			cursor: pointer;
			font-size: 11px;
			font-weight: normal;
			padding: 10px;
			position: absolute;
		}
		ul.connection:before,
		ul.connection:after {
			border: 10px solid transparent;
			content: '';
			position: absolute;
		}
		ul.connection:before {
			border-bottom-color: #f0f0f0;
			top: -19px;
			left: 20px;
			z-index: 2;
		}
		ul.connection:after {
			border-bottom-color: rgba(0, 0, 0, 0.2);
			top: -21px;
			left: 20px;
			z-index: 1;
		}
/*
ul.connection li {
    background-color: #eee;
    border-left: 1px #444 solid;
    border-right: 1px #444 solid;
    font-size: 11px;
    font-weight: normal;
    margin: 0 50% 0 -50%;
    padding: 2px 4px;
}
ul.connection li:first-child {
    border-top: 1px #444 solid;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
ul.connection li:last-child {
    border-bottom: 1px #444 solid;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
}
*/
ul.connection.hidden {
	display: none;
}

</style>

<style type="text/css">
	.radio_button input[type="checkbox"]{
		width:0;
		height:0;
		visibility:hidden;
		margin-top: -5px;
	}

	.radio_button .switch_label{
		width:80px !important;
		height:30px !important;
		background-color:#03256C !important;
		background-color: #00838F !important;
		border-radius:100px;
		position:relative;
		cursor:pointer;
		transition:all 0.5s;
	}

	.radio_button label::after{
		content:"";
		position:absolute;
		width:23px;
		height:23px;
		border-radius:50%;
		top:3px;
		left:4px;
		background-color:#2541B2;
		background-color:#dddddd;
		transition:all 1s;

	}

	.radio_button input:checked  + label:after{
		left:calc(100% - 28px);
	}

	.radio_button label:active::after{
		width:100%;
	}
</style>

<script src="d3.min.js"></script>
<style>
	circle {
		stroke: #fff;
		stroke-width: 1;
	}

	.link {
		stroke: #999;
		stroke-opacity: 0.6;
	}
</style>

<style type="text/css">
	#fig {
		width: 1280px;
		height: 800px;
	}
</style>


</head>

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 70%;">



			<div id='container'>
				<div id="fig"></div>
			</div>


		</div>

		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 15%;">
			<? 
			echo $panelAlerta;
			?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="row">
							<label for="exampleFormControlTextarea1" class="form-label" style="margin-top: 10px;">Actores</label>
							<select class="form-select alto argumento-select" multiple aria-label="Default select example" id="actores" onchange="getSelect();" style="height: 300px;">
								<? 
								foreach ($actores as $id=>$descriptor){
									echo '<option value="'.$id.'">'.$descriptor.'</option>';
								}
								?>
							</select>
							<label for="exampleFormControlTextarea1" class="form-label" style="margin-top: 10px;">Tipos de Relación</label>
							<select class="form-select alto argumento-select" aria-label="Default select example" multiple id="relaciones" onchange="getSelect();" style="height: 200px;">
								<? 
								foreach ($tiposRelacion as $id=>$descriptor){
									echo '<option value="'.$id.'">'.$descriptor.'</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
</body>

<?
#p(1,$relaciones);
echo creaModal($actoresModal, $relaciones);

function creaModal($actoresModal,$relaciones){
	foreach ($actoresModal as $key => $value) {
		$modal.='<div class='."modal".' tabindex="-1" id="'.$key.'" onclick="ocultarModal('.$key.')">
		<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header text-center"><h5 class="modal-title">'.$value['actor'].'</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
		<div class="modal-body">
		';
		$modal.='<div class="text-center"><h5>Tipo de actor</h5>'.$value['tipoDeActor'].'</div><hr>';
		$modal.=tablaRelaciones($key, $relaciones[$value['actor']]);
		$modal.='</div></div></div></div>
		';		
	}
	return $modal;
}

function tablaRelaciones($key,$array){
	$tabla.='<table class="table table-sm">
  <thead><tr><th scope="col">Relacionados</th><th scope="col">Relevancia</th></tr></thead>
  <tbody>';
  arsort($array);
  foreach ($array as $key => $value) {
  	$tabla.='<tr><td>'.$key.'</td><td>'.$value.'</td></tr>
  	';
  }
  $tabla.="</tbody></table>";
return $tabla;
}
?>



<script type="text/javascript">
	function mostrarModal(id){ $("#"+id).show(); }
	function ocultarModal(id){ $("#"+id).hide(); }
</script>

<script>

	$(document).ready(function() {
		getSelect();
	})

	$(document).ready(function() {
		$("#actores").change(function() {
			if ($(this).find("option:selected").length > 20) {
				$(this).find("option:selected").last().prop("selected", false);
			}
		});
	});

	async function postData(url = 'sociograma_d3_select.php', data = {}) {
		l("Enviando datos");
		const response = await fetch(url, {
			method: 'POST', 
			mode: 'cors', 
			cache: 'no-cache', 
			credentials: 'same-origin', 
			headers: {
				'Content-Type': 'application/json'
			},
			redirect: 'follow', 
			referrerPolicy: 'no-referrer', 
			body: JSON.stringify(data)
		});
		return response.json();
	}

	function getSelect(){

		l("Get Select")
		var id;
		var valor;
		var argumentos={};
		var selects = $(".argumento-select");
		selects.each(function() {
			let id = $(this).attr("id");
			let valor = $(this).val();
			argumentos[id] = valor;
		});


		const margin = {
			top: 20,
			bottom: 20,
			left: 20,
			right: 20,
		};
		var contenedor=document.getElementById("fig");
		$('#fig').empty();

		const width = contenedor.clientWidth - margin.left - margin.right;
		const height = contenedor.clientHeight - margin.top - margin.bottom;

		const svg = d3
		.select("#fig")
		.append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", `translate(${margin.left}, ${margin.top})`);

		const simulation = d3
		.forceSimulation()
		.force(
			"link",
			d3.forceLink().id((d) => d.id)
			)
		.force("charge", d3.forceManyBody())
		.force("center", d3.forceCenter(width / 2, height / 2));

		const color = d3.scaleOrdinal(d3.schemeCategory10);

		if (argumentos['actores'] && argumentos['relaciones']) {
			postData('sociograma_d3_select.php', { 
				actores:argumentos['actores'], 
				relaciones:argumentos['relaciones'] 
			})
			.then(data => {
				l(data); // JSON data parsed by `data.json()` call
				l("...................................................")
				//data=data.json(); // parses JSON response into native JavaScript objects
				grafo=data.grafo;



				const g = svg.append("g"); 

				const link = g.selectAll(".link")
				.data(grafo.links)
				.join("line")
				.attr("class", "link")
				.attr("stroke-width", d => d.value);

				const simulation = d3.forceSimulation(grafo.nodes)
				.force("link", d3.forceLink(grafo.links).id(d => d.id))
				.force("charge", d3.forceManyBody())
				.force("center", d3.forceCenter(width / 2, height / 2))
				.on("tick", ticked);

				const node = g.selectAll(".node")
				.data(grafo.nodes)
				.join("g")
				.attr("class", "node")
				.call(drag(simulation));

				node.append("circle")
				.attr("r", (d) => (1 * d.peso))
				.style("fill", (d) => color(d.group))
				.on("click", function(event, d) {
					mostrarModal(d.idOriginal);
					//alert("Haz hecho clic en el nodo con ID: " + d.id + " De nombre: " + d.nodeName + " De peso " + d.peso );
				});


				node.append("text")
				.attr("class", "node-label")
				//.attr("dy", (d) => ( toString(d.peso/10) + "em" )
				.attr("dy", "1.8em" )
				.attr("text-anchor", "middle")
				.style("font-size", "8px")
				.style("fill", "black")
				.text((d) => d.nodeName);

				function ticked() {
					link
					.attr("x1", d => d.source.x)
					.attr("y1", d => d.source.y)
					.attr("x2", d => d.target.x)
					.attr("y2", d => d.target.y);

					node
					.attr("transform", d => `translate(${d.x}, ${d.y})`);
				}

				function drag(simulation) {
					function dragstarted(event) {
						if (!event.active) simulation.alphaTarget(0.1).restart();
						event.subject.fx = event.subject.x;
						event.subject.fy = event.subject.y;
					}

					function dragged(event) {
						event.subject.fx = event.x;
						event.subject.fy = event.y;
					}

					function dragended(event) {
						if (!event.active) simulation.alphaTarget(0);
						event.subject.fx = null;
						event.subject.fy = null;
					}

					return d3.drag()
					.on("start", dragstarted)
					.on("drag", dragged)
					.on("end", dragended);
				}








			});
		} else {
			console.error("Faltan argumentos: actores o relaciones no están definidos.");
		}
	}


  function l(x){
  	console.log(x);
  }
</script>

<script>

	function creaModal(id){








		const link = svg
		.selectAll(".link")
		.data(grafo.links)
		.join((enter) => enter.append("line").attr("class", "link").attr("class", "link").attr("stroke-width", d => d.value) ); 

		const node = svg
		.selectAll(".node")
		.data(grafo.nodes)
		.join((enter) => {

			const node_enter = 

			enter.append("circle")
			.attr("class", "node")
			.attr("r", (d) => ( 1 * d.peso ) );

					/*
					*/
					enter.append("text")
					.attr("class", "node-label")
					.attr("x", (d) => d.x)
					.attr("y", (d) => d.y)
					.text((d) => d.nodeName);

					enter.append("title")
					.text((d) => d.nodeName);
					
					return node_enter;
				})
		.on("click", function(event, d) {
			mostrarModal(d.idOriginal);
					//alert("Haz hecho clic en el nodo con ID: " + d.id + " De nombre: " + d.nodeName + " De peso " + d.peso );
				});
		node.style("fill", (d) => color(d.group));

				/*
				node.call(d3.drag()
					.on("start", dragstarted)
					.on("drag", dragged)
					.on("end", dragended));
					*/

					simulation.nodes(grafo.nodes).force("link").links(grafo.links);

					simulation.on("tick", (e) => {
						link
						.attr("x1", (d) => d.source.x)
						.attr("y1", (d) => d.source.y)
						.attr("x2", (d) => d.target.x)
						.attr("y2", (d) => d.target.y);

						node.attr("cx", (d) => d.x).attr("cy", (d) => d.y);
					});



				}
			</script>




		</body>
		</html>



		</html>




