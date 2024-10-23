<?

//inicializando
session_start();

$P=1; //define si los pre se ven o no
include('00_conexion.php');

$mysqli=conectar($datosConexion);

actualizarEdadRango($datosConexion);

$sql="SHOW TABLES FROM tioconejo_funvape";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$t=$row['Tables_in_tioconejo_funvape'];
			if(substr($t, 0,3)!='doc' AND substr($t, 0,2)!='v_'){
				$tablas[]=$t;
			}
		}
		$result->close();
	}
} 

p($P,$tablas);

die();


$_SESSION['fvp']['aliasCampos']=$aliasCampos;
$nombrePagina=strtoupper($aliasCampos[$_SESSION['fvp']['view']]);

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

$sql="SELECT descriptor, alias, rango FROM uniViews ORDER BY alias ASC";
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

$sql ="SELECT * FROM v_$view WHERE id<>1";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			foreach ($row as $key => $value) {
				if($key=='id' OR ( strlen($key)>2 AND substr($key, 0,2)!='id') ){
					if( ! in_array ($key, array ('fechaNacimiento_YYYY', 'fechaNacimiento_MM', 'fechaNacimiento_DD', 'fechaNacimiento_SEMANA' ) )){
						$tabla[$row['id']][$key]=$value;
						$titulos[$key]=$key;
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
/*
p($P,$sql);
p($P,$tabla);
p($P,$titulos);
*/

$t='<thead><tr>';
foreach ($titulos as $key => $value) {
	$t.='<th>'.$aliasCampos[$value].'</th>';
}
$t.='<th>Documentos</th>';
$t.='<th>Ver</th>';
$t.='<th>Editar</th>';
$t.='<th>Eliminar</th>';
$t.='</tr></thead><tbody>';
foreach ($tabla as $key => $value) {
	$t.='<tr>';
	foreach ($value as $key2 => $value2) {
		$t.='<td>'.$value2.'</td>';	
	}
	$t.='<td>
	<form action="documentacion.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="view" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-link">
	<span class="glyphicon glyphicon-file" aria-hidden="true" onclick="this.form.submit();"></span>
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudV.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-link">
	<span class="glyphicon glyphicon-search" aria-hidden="true" onclick="this.form.submit();"></span>
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudCU.php" method="POST">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-link">
	<span class="glyphicon glyphicon-pencil" aria-hidden="true" onclick="this.form.submit();"></span>
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudD.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-link">
	<span class="glyphicon glyphicon-trash text-danger" aria-hidden="true" onclick="this.form.submit();"></span>
	</button>
	</form>
	</td>';
	$t.='</tr>';
}
$t.='</tbody>';


?>

<? include('htmlHead.php'); ?>


<body>

	<? include('navbar.php'); ?> 

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<? echo $panelAlerta;?>
				<div class="panel panel-default">
					<div class="panel-body" style="min-height: 100px;">
						<div class="row">
							<div class="col-md-10">
								<h1><strong><?echo $nombrePagina?></strong></h1>
							</div>
							<div class="col-md-2" style="margin-top: 18px;">
								<div class="text-right">
									<form action="crudCU.php" method="POST">
										<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
										<button type="submit" name="tabla" class="btn btn-primary btn-md" value="<? echo $view;?>">
											Agregar Nuevo Registro
										</button>
									</form>
								</div>
							</div>
						</div>
						<hr>
						<table id="example" class="display" style="width:100%">
							<?echo $t;?>
						</table>
					</div>
				</div>
			</div>    		
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        scrollX: true,
        buttons: [
        	'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
