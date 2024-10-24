<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=1; //define si los pre se ven o no
include('../000_conexion.php');

$post=$_POST;
p($P,$post);

die();

$seccion="principal";

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']="den_denuncia";
}
$nivelDeUsuario=$_SESSION['fvp']['nivel'];
#p($P,$nivelDeUsuario);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$mysqli=conectar($datosConexion);
$sql="SELECT id,descriptor FROM adm_perfil";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$perfiles[$row['id']]=$row['descriptor'];
		}
		$result->close();
	}
} 
#p($P,$perfiles);
$sql="SELECT id,descriptor FROM adm_views";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$views[$row['id']]=$row['descriptor'];
		}
		$result->close();
	}
} 
#p($P,$views);
foreach ($views as $key => $value) {
	foreach ($perfiles as $key2 => $value2) {
		$tabla[$key][$key2]=0;
	}
}


$sql="SELECT idadm_perfil as p, idadm_views as v FROM adm_viewPerfil";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$tabla[$row['v']][$row['p']]=1;
		}
		$result->close();
	}
} 
#p($P,$tabla);

$t='<thead><th style="height:120px;"></th>';
foreach ($perfiles as $keys => $values) {
	$t.='<th style="width:1%;"><span class="rot">'.str_replace(" ", "&nbsp;", (substr($values,0,6))) .'.</span></th>';
}
$t.="</thead><tbody>";

foreach ($tabla as $keyFila => $valueFila) {
	$t.='<tr><td>'.$views[$keyFila].'</span></td>';
	foreach ($valueFila as $keyColumna => $valueColumna) {
		if($valueColumna==0){
			$classCelda='danger';
		} else {
			$classCelda="success";
		}
		$t.='<td class="text-center"><a class="btn btn-outline btn-sm btn-'.$classCelda.' text-'.$classCelda.'" href="controlDeVistas_toggleViewPerfil.php?id_perfil='.$keyColumna.'&id_views='.$keyFila.'">'.$valueColumna.'</a></td>';
	}
	$t.="</tr>";
}
$t.="</tbody>";

?>


<html>
<? include('../000_head.php');?>

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<? echo $panelAlerta;?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row">
						<div class="col-md-10 text-center" style="margin-top: 10px;">
							<h2>Control de Vistas</h2>
						</div>
					</div>
					<hr>
					<div class="container-fluid	scroll" style="margin-bottom: 0px;">
						<table id="example" class="display" style="width:100%;">
							<?echo $t;?>
						</table>
						<div style="margin-bottom: 0px;"></div>
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
		$('#example').DataTable( {
			dom: 'Bfrtip',
			scrollX: true,
			stateSave: true,
			lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 filas', '10 filas', '25 filas', '50 filas', 'Show all' ]
			],
			buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'colvis', 'pageLength'
			],
			"pageLength":-1,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		} );



	} );
</script>
