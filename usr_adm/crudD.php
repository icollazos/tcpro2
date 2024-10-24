<?

//inicializando
session_start();
$uniUsuario=$_SESSION['fvp']['uniUsuario'];

$P=1; //define si los pre se ven o no
include('../000_conexion.php');
//p($P,$_SESSION);

$idRegistro=$_GET['idRegistro'];
$tabla=$_GET['tabla'];
$from=$_GET['from'];
//p($P,$_GET);
if(isset($_POST['confirmado'])){
	$idRegistro=$_POST['idRegistro'];
	$tabla=$_POST['tabla'];
	$mysqli=conectar($datosConexion);
	$sql="UPDATE $tabla  SET borrar='1' WHERE id='$idRegistro'";
	$sql="DELETE FROM $tabla WHERE id='$idRegistro'";
	if ($result = $mysqli->query($sql)) {}
	if($tabla="aaa_actor"){
		$sql="DELETE FROM aaa_actor2 WHERE id='$idRegistro'";
		if ($result = $mysqli->query($sql)) {}		
	}
	header("Location: $from");
}

$panelAlerta=panel("danger","Eliminando Registros","Estás a punto de eliminar el registro");

$seccion="principal";
$nombrePagina="CRUD";

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
//p($P,$vista);

foreach ($vista as $key => $value) {
	if(substr($key, 0,2)!='id'){
		$tablaSalida.="<tr><td>".$key."</td><th><small>".$value."</small></th></tr>";
	}
}
//echo $from;
$href="index.php?view=$tabla";
if(substr($from, 0,9)=="consulta_"){
	$href=$from;
}
?>
<html>
<? include('../000_head.php'); ?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Detalle del Registro</h3>
				</div>
				<div class="panel-body" style="min-height: 0px;">
					<table id="example" class="display" style="width:100%">
						<thead><th>Campo</th><th>Valor</th></thead>
						<? echo $tablaSalida;?>
					</table>
				</div>
				<div class="panel-footer text-center">
					<form method="post" action="">
						<input type="hidden" name="idRegistro" value="<? echo $idRegistro; ?>"/>
						<input type="hidden" name="tabla" value=<? echo '"'.$tabla.'"'; ?>/>
						<button type="submit" name="confirmado" value="1" class="btn btn-danger">Bórralo</button>
						<a href="<?echo $href;?>" class="btn btn-primary">Sácame de Aquí</a>
					</form>
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
