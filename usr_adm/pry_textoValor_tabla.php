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
$nombrePagina='Etiquetador | Entrenamiento del Robot';

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
								<div class="col">
									<div class="row">
										<h5 class="form-label">Filtros</h5>
									</div>
									<label for="exampleFormControlTextarea1" class="form-label">Proyecto</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="proyecto" onchange="selSeguimiento();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Seguimiento</label>
								<?echo $_SESSION['cliente'];?>
									<select class="form-select argumento-select" aria-label="Default select example" id="seguimiento" onchange="selVariable();">
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Variable</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="variable" onchange="creaSalida();">
									</select>
								</div>
								<div class="col">
									<div class="row" style="">
										<h5 class="form-label">&nbsp;</h5>
									</div>
									<div class="row" style="">
										<label for="exampleFormControlTextarea1" class="form-label">Buscar por palabra</label>
										<input type="text" class="form-control" id="keywords" placeholder="Escriba palabras separadas por comas" onblur="creaSalida();">
										<label for="exampleFormControlTextarea1" class="form-label">Palabras mas usadas</label>
										<select class="form-select argumento-select" aria-label="Default select example" id="frecuentes" onchange="creaSalida();">
										</select>
									</div>
								</div>
								<div class="col">
									<div class="row" style="">
										<h5 class="form-label">&nbsp;</h5>
									</div>
									<div class="row">
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Año Inicial</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="anoInicio" onchange="creaSalida();">
												<? for ($i=2023; $i < 2030; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
											</select>
											<label for="exampleFormControlTextarea1" class="form-label">Mes Inicial</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="mesInicio" onchange="creaSalida();">
												<option value="01/01">Enero</option><option value="02/01">Febrero</option><option value="03/01">Marzo</option><option value="04/01">Abril</option><option value="05/01">Mayo</option><option value="06/01">Junio</option><option value="07/01">Julio</option><option value="08/01">Agosto</option><option value="09/01">Septiembre</option><option value="10/01">Octubre</option><option value="11/01">Noviembre</option><option value="12/01">Diciembre</option>
											</select>
										</div>
										<div class="col">

											<label for="exampleFormControlTextarea1" class="form-label">Año Final</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="anoFinal" onchange="creaSalida();">
												<? for ($i=2030; $i > 2023; $i--) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
											</select>
											<label for="exampleFormControlTextarea1" class="form-label">Mes Final</label>
											<select class="form-select alto argumento-select" aria-label="Default select example" id="mesFinal" onchange="creaSalida();">
												<option value="01/31">Enero</option><option value="02/28">Febrero</option><option value="03/31">Marzo</option><option value="04/30">Abril</option><option value="05/31">Mayo</option><option value="06/30">Junio</option><option value="07/31">Julio</option><option value="08/31">Agosto</option><option value="09/30">Septiembre</option><option value="10/31">Octubre</option><option value="11/30">Noviembre</option><option value="12/31">Diciembre</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col">
								</div>
								<div class="col">
									<div class="row" style="width: 90%">
										<h5 class="form-label">Datos y Registros</h5>
									</div>
									<div class="row" style="width: 90%; margin-bottom: 10px;">
										<button class="btn btn-sm btn-warning" name="proyecto" id="actualizarTextos" >Actualizar textos</a>
										</div>
										<div class="row" style="width: 90%; margin-bottom: 10px;">
											<button class="btn btn-sm btn-primary" disabled="true">Ver registros eliminados</button>
										</div>
										<div class="row" style="width: 90%; margin-bottom: 10px;">
											<button class="btn btn-sm btn-warning" onclick="reiniciarRobot();">Reiniciar robot de etiquetado</button>
										</div>
										<div class="row" style="width: 90%; margin-bottom: 10px;">
											<button class="btn btn-sm btn-success" onclick="ejecutarRobot();">Ejecutar robot</button>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="container-fluid	scroll" style="margin-bottom: 0px;" id="cajaTabla">
										<table class="table display" id="example">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Texto</th>
													<th scope="col">Fecha</th>
													<th scope="col">Borrar Txt.</th>
													<th scope="col">Valor</th>
													<th scope="col">Puntaje</th>
													<th scope="col">ROH</th>
													<th scope="col">Etiquetas</th>
												</tr>
											</thead>
											<tbody id="tbody">
											</tbody>
										</table>
									</div>
								</div>						
								<hr>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</body>
	</html>
	<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			
			selProyecto();

			$('#actualizarTextos').on('click', function() {
				actualizarTextos();
			});

		}); 

		function actualizarTextos() {
				var proyecto=$("#proyecto").val();
				const url = 'api_app.php';
				const params = {
					proyecto: proyecto,
					param2: 'value2'
				};
				getData(url, params)
				.then(data => {
					l("TEXTOS ACTUALIZADOS")
					l(data); 
				})
				.catch(error => {
					l('Error:', error); 
				});
			};			

		function creaSalida(){
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
			argumentos['variable']=$("#variable").val();
			argumentos['seguimiento']=$("#seguimiento").val();
			argumentos['keywords']=$("#keywords").val();
			argumentos['funcionLlamada']="buscaTextos";
			l(argumentos);
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos Tabla")
				l(data)
				llenarDataTable(data);
			});
		}
		function llenarDataTable(data) {
			var idVariable=$("#variable").val();
			if ($.fn.DataTable.isDataTable('#example')) {
				$('#example').DataTable().clear().destroy();
			}
			$('#example').DataTable({
        data: data, // Los datos que recibiste del servidor
        columns: [
        { data: 'id' }, 
        {
        	data: 'texto',
        	render: function(data, type, row) {
        		const maxLength = 200;
        		return data.length > maxLength ? data.substring(0, maxLength) + '...' : data;
        	}
        }, 
        { data: 'fecha' }, 
        {
        	data: null, 
        	render: function(data, type, row) {
        		return `<button class="btn btn-danger btn-sm" onclick="eliminarTexto(${row.id})">Borrar</button>`;
        	}
        },
        { data: 'valor' }, 
        { data: 'puntaje' }, 
        { data: 'roh' },
        {
        	data: null, 
        	render: function(data, type, row) {
        		return `
        		<a href="pry_textoValor_crear.php?idVariable=`+idVariable+`&idTexto=`+row.id+`" class="btn btn-success btn-sm">Crear</a>
        		<button class="btn btn-warning btn-sm" onclick="borrarEtiqueta(${row.idTextoValor})">Borrar</button>
        		`;
        	}
        }
        ],
        bFilter: true,
        dom: 'Bfrtip',
        lengthMenu: [
        [5, 10, 25, 50, -1],
        ['5 filas', '10 filas', '25 filas', '50 filas', 'Mostrar todo']
        ],
        buttons: [
        'colvis', 'pageLength'
        ],
        "pageLength": 100,
        language: {
        	url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
        },
        columnDefs: [
        { targets: [0, 1, 2, 3, 4], searchable: true },
        { targets: 1, width: '40%' } // Establecer el ancho de la columna 'texto' al 25%
        ],
        "oClasses": {
        	"sWrapper": "dataTables_wrapper form-inline dt-bootstrap",
        	"sFilterInput": "form-control",
        	"sLengthSelect": "form-control"
        }});
		}
		function ejecutarRobot(){
			l("EJECUTANDO ROBOT");
			var id;
			var valor;
			var idVariable=$("#variable").val();
			l(idVariable);
			var argumentos={};
			l("argumentos");
			l(argumentos);
			argumentos['funcionLlamada']="ejecutarRobot";
			argumentos['idVariable']=idVariable;
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos robot")
				l(data)
				creaSalida();
			});
		}
		function eliminarTexto(id) {
			l("EJECUTANDO ROBOT");
			var id;
			var argumentos={};
			l("argumentos");
			l(argumentos);
			argumentos['funcionLlamada']="eliminarTexto";
			argumentos['idTexto']=id;
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos robot")
				l(data)
				creaSalida();
			});	
		}
		function borrarEtiqueta(id) {
			l("ELIMINANDO ETIQUETA");
			var id;
			var argumentos={};
			l("argumentos");
			l(argumentos);
			argumentos['funcionLlamada']="borrarEtiqueta";
			argumentos['idTextoValor']=id;
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos robot")
				l(data)
				creaSalida();
			});	
		}
		function reiniciarRobot() {
			l("EJECUTANDO ROBOT");
			var id;
			var argumentos={};
			l("argumentos");
			l(argumentos);

			argumentos['funcionLlamada']="reiniciarRobot";
			argumentos['idVariable']=$("#variable").val();
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("ROBOT REINICIADO")
				l(data)
				creaSalida();
			});	
		}
		function etiquetarTexto(id) {
			l('Etiquetar texto con ID: ' + id);
		}
		function eliminarEtiqueta(id) {
			l('Eliminar etiqueta de texto con ID: ' + id);
		}


	</script>

