<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=1; //define si los pre se ven o no
include('../000_conexion.php');
//die();
$seccion="principal";

$vistaDefecto="cid_libro";


if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']=$vistaDefecto;
}
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
$view=$_SESSION['fvp']['view'];
$_SESSION['crud']['corrida']=0;
unset($_SESSION['fvp']['crud']);
unset($_SESSION['fvp']['idRegistro']);

in_array($view, $_SESSION['fvp']['tablasSeguras']) ? $tablaSegura=TRUE : $tablaSegura=FALSE ;

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$mysqli=conectar($datosConexion);

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
$nombrePagina="Buscador Bibliográfico";
#p($P,$aliasCampos);

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	$_SESSION['fvp']['idUsuario']=1;
} else {
	$_SESSION['fvp']['uniUsuario']="Visitante";
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}


$idUsuario=$_SESSION['fvp']['idUsuario'];
if(isset($_POST['accion']) and $_POST['accion']=='nuevoFavorito'){
	$idLibro=$_POST['idLibro'];
	$sql="INSERT INTO cid_favoritos (idadm_usuario,idcid_libro) VALUES ('$idUsuario','$idLibro')";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {}

}

$sql="SELECT descriptor, alias, rango FROM adm_views ORDER BY alias ASC";
//p($P,$sql);
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


$sql ="SELECT 
cid_autorLibro.id as IdBase, 
cid_libro.cota as Cota, 
cid_apellido.id as idApellido, 
cid_apellido.descriptor as Apellido, 
cid_nombre.id as idNombre, 
cid_nombre.descriptor as Nombre, 
cid_libro.id as idLibro, 
cid_libro.descriptor as Libro, 
cid_editorial.id as idEditorial, 
cid_editorial.descriptor as Editorial, 
cid_circulante.id as idCirculante, 
cid_circulante.descriptor as Circulante

FROM cid_autorLibro 
INNER JOIN cid_libro ON cid_libro.id=cid_autorLibro.idcid_libro
INNER JOIN cid_nombre ON cid_nombre.id=cid_autorLibro.idcid_nombre 
INNER JOIN cid_apellido ON cid_apellido.id=cid_autorLibro.idcid_apellido
INNER JOIN cid_editorial ON cid_editorial.id=cid_libro.idcid_editorial
INNER JOIN cid_tipoMonografico ON cid_tipoMonografico.id=cid_libro.idcid_tipoMonografico
INNER JOIN cid_circulante ON cid_circulante.id=cid_tipoMonografico.idcid_circulante

WHERE cid_libro.id<>1

";


if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	$i=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			foreach ($row as $key => $value) {
				$tabla[$i][$key]=$value;
				$libros[$row['idLibro']]=$row['Libro'];
				$editoriales[$row['idEditorial']]=$row['Editorial'];
				$apellidos[$row['idApellido']]=$row['Apellido'];
				$nombres[$row['idNombre']]=$row['Nombre'];
				$titulos[$key]=$key;
			}
			$i++;
		}
	} 
	$result->close();
} 

#include("000_buscador_fnSelect.php");
?>

<html>
<? include('../000_head.php');?>
<style type="text/css">
	.alto{
		height: 145px;
	}
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
						<div class="col">
							<label for="exampleFormControlTextarea1" class="form-label">Apellido del Autor </label>
							<select class="form-select alto" aria-label="Default select example" multiple id="apellidos" onblur="creaTabla();">
								<option value="">Seleccione...</option>
								<?
								asort($apellidos);
								foreach ($apellidos as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
								?>
							</select>
						</div>
						<div class="col">
							<label for="exampleFormControlTextarea1" class="form-label">Nombre del Autor</label>
							<select class="form-select alto" aria-label="Default select example" multiple id="nombres" onblur="creaTabla();">
								<option  value="">Seleccione...</option>
								<?
								asort($nombres);
								foreach ($nombres as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
								?>
							</select>
						</div>
						<div class="col">
							<label for="exampleFormControlTextarea1" class="form-label">Título</label>
							<select class="form-select alto" aria-label="Default select example" multiple id="libros" onblur="creaTabla();">
								<option  value="">Seleccione...</option>
								<?
								asort($libros);
								foreach ($libros as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
								?>
							</select>
						</div>
						<div class="col">
							<label for="exampleFormControlTextarea1" class="form-label">Editorial</label>
							<select class="form-select alto" aria-label="Default select example" multiple id="editoriales" onblur="creaTabla();">
								<option  value="">Seleccione...</option>
								<?
								asort($editoriales);
								foreach ($editoriales as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
								?>
							</select>
						</div>
						<div class="col">
							<div class="row">
								<label for="exampleFormControlTextarea1" class="form-label">Tipo de búsqueda</label>
								<select class="form-select" aria-label="Default select example" id="tipoBusqueda" onblur="creaTabla();">
									<option value="O">Seleccione...</option>
									<option value="O">Extensa</option>
									<option value="A">Estricta</option>
								</select>
							</div>
							<div class="row" style="margin-top: 24px;">
								<div class="col-8">
									Búsqueda Estricta
								</div>
								<div class="col">
									<div class="d-grid gap-2">
										<div class="radio_button">
											<input type="checkbox" id="toggleTipoBusqueda" value="A" onchange="creaTabla();">
											<label class="switch_label" for="switch12"></label>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col">
									<div class="d-grid gap-2">
										<button id="reiniciar" class="btn btn-warning btn-block btn-sm">Reiniciar Filtros</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<hr>

						<div class="container-fluid	scroll" style="margin-bottom: 0px;" id="cajaTabla">
						</div>
						<div style="margin-bottom: 0px;"></div>
					</div>
				</div>
			</div>
		</main>
	</body>



	</html>
	<?
#include("navbar_bottom.php");
	?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			creaTabla();
		});

		$("#reiniciar").click(function() {
			$("#apellidos").find('option:selected').prop('selected', false);
			$("#nombres").find('option:selected').prop('selected', false);
			$("#libros").find('option:selected').prop('selected', false);
			$("#editoriales").find('option:selected').prop('selected', false);
			creaTabla();
		});

		function creaTabla(){

			apellidos=$('#apellidos').val();
			nombres=$('#nombres').val();
			editoriales=$('#editoriales').val();
			libros=$('#libros').val();
			tipoBusqueda=$('#tipoBusqueda').val();
			$.post("buscadorLibros_select.php", {
				id: 1,
				apellidos: apellidos,
				nombres: nombres,
				editoriales:editoriales,
				libros:libros,
				tipoBusqueda:tipoBusqueda			
			})
			.done(function(response){
				l(response);
				var counter = 0;
				var j=JSON.parse(response);
				var k=j.data;
				var HTML='<table id="example" class="display" style="width:100%;">';
				HTML+='<thead>'+
				'<tr>'+
				'<th>IdBase</th>'+
				'<th>Cota</th>'+
				'<th>Apellido</th>'+
				'<th>Nombre</th>'+
				'<th>Libro</th>'+
				'<th>Editorial</th>'+
				'<th>Ver Detalle</th>'+
				'</tr>'+
				'</thead>'+
				'<tbody>';
				$.each(k, function(counter){
					var curr = k[counter];
					HTML += '<tr>'+
					'<td>'+curr.IdBase+'</td>'+
					'<td>'+curr.Cota+'</td>'+
					'<td>'+curr.Apellido+'</td>'+
					'<td>'+curr.Nombre+'</td>'+
					'<td>'+curr.Libro+'</td>'+
					'<td>'+curr.Editorial+'</td>'+
					'<td>'+curr.Ver+'</td>'+
					'</tr>';               
				});
				HTML += '</tbody>'+'</table>';
				l(HTML);
				var caja=$('#cajaTabla');
				caja.empty();
				caja.append(HTML);
				creaDT();
			})
			.fail(function() {
				alert("Error");
			});
		}

		$("#actualizar").click(function() {
			creaTabla();
		});

		function creaDT() {
			$('#example').DataTable({
				scrollX: true,
				fixedHeader: true,
				processing: true,
				bFilter: true,
				columns: [
				{ data: 'IdBase' },
				{ data: 'Cota' },
				{ data: 'Apellido' },
				{ data: 'Nombre' },
				{ data: 'Libro' },
				{ data: 'Editorial' },
				{ data: 'Ver' }
				],
				dom: 'Bfrtip',
				stateSave: true,
				lengthMenu: [
				[ 5, 10, 25, 50, -1 ],
				[ '5 filas','10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
				],
				buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print', 'colvis','pageLength'
				],
				"pageLength":100,
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
				},
			});
			$('#example').draw();
		}

		function l(variable){ console.log(variable); }
	</script>

