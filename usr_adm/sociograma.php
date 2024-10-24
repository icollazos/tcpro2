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
$nombrePagina='Sociograma de arcos y red';

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

	<link type="text/css" rel="stylesheet" href="examples/ex.css"/>
	<script type="text/javascript" src="protovis.js"></script>
	<script type="text/javascript" src="miserables.js"></script>
	<style type="text/css">
		#fig {
			width: 880px;
			height: 800px;
		}
	</style>


</head>

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 70%;">

			<div id="fig" style="border-style: solid; border-width: 1px; border-color: white; width:100%;"></div>
		</div>

		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 15%;">
			<? 
			echo $panelAlerta;
			?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="row">
							<label for="exampleFormControlTextarea1" class="form-label">Tipo de gráfico</label>
							<select class="form-select alto"  aria-label="Default select example" id="tipoGrafico" onchange="getSelect();">
								<option value="red">Seleccione...</option>
								<option value="arcos">Arcos</option>
								<option value="red">Red</option>
							</select>
							<label for="exampleFormControlTextarea1" class="form-label" style="margin-top: 10px;">Actores</label>
							<select class="form-select alto argumento-select" multiple aria-label="Default select example" id="actores" onchange="getSelect();" style="height: 300px;">
								<option value="">Seleccione...</option>
								<? 
								foreach ($actores as $id=>$descriptor){
									echo '<option value="'.$id.'">'.$descriptor.'</option>';
								}
								?>
							</select>
							<label for="exampleFormControlTextarea1" class="form-label" style="margin-top: 10px;">Tipos de Relación</label>
							<select class="form-select alto argumento-select" aria-label="Default select example" multiple id="relaciones" onchange="getSelect();" style="height: 200px;">
								<option value="">Seleccionar tipos de relación...</option>
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

<script type="text/javascript">

	$(document).ready(function() {
		getSelect();
	})


$(document).ready(function() {
  $("#actores").change(function() {
    if ($(this).find("option:selected").length > 20) {
      // Si se han seleccionado más de 2 opciones, deselecciona la última
      $(this).find("option:selected").last().prop("selected", false);
    }
  });
});

	function getSelect(){

		l("Creando Marco");
		var id;
		var valor;
		var argumentos={};
		var tipoGrafico = $("#tipoGrafico").val();
		l(tipoGrafico);
		var inputs = $(".argumento-input");
		inputs.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		var selects = $(".argumento-select");
		selects.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		l("argumentos");
		l(argumentos);

		$.post("sociograma_select.php", {
			argumentos: argumentos
		})
		.done(function(response){
			l("DONE");
			//l(response);
			var counter = 0;
			var j=JSON.parse(response);
			l(j);
			if(tipoGrafico=="red") {
				createLayoutRed(j);
			} else {
				createLayoutArcos(j);				
			}
		})
		.fail(function() {
			l("Error en la carga de curr");
		});
	}

	function l(x){
		console.log(x);
	}



	var followers={};

	function createLayoutRed(followers){

		var vis;
		var contenedor=document.getElementById("fig");

		var w = contenedor.clientWidth,
		h = contenedor.clientHeight,
		colors = pv.Colors.category20();

		vis = new pv.Panel()
		.canvas("fig")
		.width(w)
		.height(h)
		.fillStyle("white")
		.event("mousedown", pv.Behavior.pan())
		.event("mousewheel", pv.Behavior.zoom());


		var force = vis.add(pv.Layout.Force)
		.nodes(followers.nodes)
		.links(followers.links);	

		force.link
		.add(pv.Line)
		;

		force.node
		.add(pv.Dot)
		.size(function(d){ return (d.linkDegree + 4) * Math.pow(this.scale, -1.5);})
		.fillStyle(function(d){ return d.fix ? "black" : colors(d.group);})
		.strokeStyle(function(){ return this.fillStyle().darker();})
		.lineWidth(1)
		.title(function(d){return d.nodeName;})
		.event("mousedown", pv.Behavior.drag(function(){alert("fdkhbfdhbfd")}))
		.event("drag", force)
		.anchor("bottom").add(pv.Label)
		.text(function(d){return d.nodeName;})


		vis.render();
	}


	function createLayoutArcos(followers){

		var vis;
		var contenedor=document.getElementById("fig");

		var w = contenedor.clientWidth,
		h = contenedor.clientHeight,
		colors = pv.Colors.category20();

		vis = new pv.Panel()
		.canvas("fig")
		.width(w)
		.height(h)
		.fillStyle("white")
		.bottom(90)
		.event("mousedown", pv.Behavior.pan())
		.event("mousewheel", pv.Behavior.zoom());


		var force = vis.add(pv.Layout.Arc)
		.nodes(followers.nodes)
		.links(followers.links);	

		force.link
		.add(pv.Line);

		force.node
		.add(pv.Dot)
		.size(function(d){ return (d.linkDegree + 4) * Math.pow(this.scale, -1.5);})
		.fillStyle(function(d){ return d.fix ? "brown" : colors(d.group);})
		.strokeStyle(function(){ return this.fillStyle().darker();})
		.lineWidth(1)
		.title(function(d){return d.nodeName;})
		.event("mousedown", pv.Behavior.drag())
		.event("drag", force)
		.anchor("bottom").add(pv.Label)
		.textAlign("right")
		.textBaseline("middle")
		.textAngle(-Math.PI / 2)
		.text(function(d){return d.nodeName;})


		vis.render();
	}



</script>




</html>




