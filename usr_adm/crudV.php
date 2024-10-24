<?

//inicializando
session_start();
$uniUsuario=$_SESSION['fvp']['uniUsuario'];

$P=1; //define si los pre se ven o no
include('../000_conexion.php');
//p($P,$_SESSION);

$seccion="principal";
$nombrePagina="CRUD";

$idRegistro=$_GET['idRegistro'];
$tabla=$_GET['tabla'];
$from=$_GET['from'];

$mysqli=conectar($datosConexion);

//p($P,$_SESSION['fvp']);
$viewActual=$_SESSION['fvp']['view'];

$panelAlerta=panel("danger","Eliminando Registros","Estás a punto de eliminar el registro");

$sql ="SELECT * FROM v_$tabla WHERE id='$idRegistro'";
//p($P,$sql);
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			$vista=$row;
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 
#p($P,$vista);

$tabla="";
foreach ($vista as $key => $value) {
	if(substr($key, 0,2)!='id' and $key!="fechaHora" and $key!="borrar"){
		$tabla.="<tr><td>".$key."</td><th>".$value."</th></tr>";
	}
}

?>

<html>
<? include('../000_head.php'); ?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>

		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Detalle del Registro</h3>
					</div>
					<div class="panel-body" style="min-height: 0px;">
						<table id="example" class="display" style="width:100%">
							<thead><th>Campo</th><th>Valor</th></thead>
							<? echo $tabla;?>
						</table>
					</div>
					<div class="panel-footer">
						<a href="index.php?view=<?echo $viewActual;?>" class="btn btn-primary">Volver</a>
					</div>
				</div>
		</div>
	</main>
</body>
</html>



<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			"scrollX": true
		});
	} );
</script>
