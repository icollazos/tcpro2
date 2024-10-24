<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

//include 'funciones.php';

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Consulta general de: '.$esteAmbito;

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
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="col">
							<form class="form">
								<div class="row">
									<div class="col">
										<label for="exampleFormControlTextarea1" class="form-label">Proyecto</label>
										<select class="form-select argumento-select" aria-label="Default select example" id="proyecto" onchange="selSeguimiento();">
										</select>
										<label for="exampleFormControlTextarea1" class="form-label">Seguimiento</label>
										<select class="form-select argumento-select" aria-label="Default select example" id="seguimiento" onchange="selItem();">
										</select>
										<label for="exampleFormControlTextarea1" class="form-label">Item</label>
										<select class="form-select argumento-select" aria-label="Default select example" id="item">
										</select>
									</div>
									<div class="col">
									</div>
									<div class="col">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col">
										<div class="d-grid gap-2">
											<div class="row">
												<div class="col">
													<textarea type="text" id="texto" class="form-control" style="width:100%; height:300px;"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col">
										<div class="d-grid gap-2">
											<div class="row">
												<div class="col">
													<button type="button" id="texto" class="btn btn-primary" onclick="cargaTexto();">Grabar</textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<form action="crudCU.php" method="POST" id="formCU">
					<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
					<input type="hidden" name="tabla" value="<?echo $estaTabla;?>">
				</form>
			</div>
		</main>
	</body>

	<script type="text/javascript">
		$(document).ready(function() {
			selProyecto();
		});
		async function postData(url = url, data = {}) {
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
	</script>
	<script type="text/javascript">
		function creaSelect(id,data){
			$('#' + id).empty();
			$.each(data, function(index, valor) {
				$('#' + id).append($('<option>', {
					value: valor.value, 
					text: (valor.value + '. ' + valor.text)
				}));
			});
		}
		function selProyecto(){
			var id;
			var valor;
			argumentos={};
			argumentos['funcionLlamada']="cargaProyectos";
			postData('pry_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				id="proyecto";
				creaSelect(id,data);
				selSeguimiento();
			});
		}
		function selSeguimiento(){
			var id;
			var valor;
			argumentos={};
			argumentos['funcionLlamada']="cargaSeguimientos";
			argumentos['idaaa_proyecto']=$("#proyecto").val();
			postData('pry_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				id="seguimiento";
				creaSelect(id,data);
				selItem();
			});
		}
		function selItem(){
			var id;
			var valor;
			argumentos={};
			argumentos['funcionLlamada']="cargaItems";
			argumentos['seguimiento']=$("#seguimiento").val();
			postData('pry_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l(data)
				id="item";
				creaSelect(id,data);
			});
		}
		function cargaTexto(){
			l("Cargando Texto Individual");
			var id;
			var valor;
			argumentos={};
			argumentos['funcionLlamada']="cargaTextoIndividual";
			argumentos['idaaa_item']=$("#item").val();
			argumentos['texto']=$("#texto").val();
			l(argumentos);
			postData('pry_textoIndividual_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l(data);
				wellUltimoTexto();
			});
		}
		function wellUltimoTexto(){
		}
		function l(variable){ console.log(variable); }
	</script>
	</html>
	<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

