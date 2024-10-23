<?

//inicializando
session_start();


include('00_conexion.php');
$view=$_GET['view'];
$destino=str_replace("|", "?", $view);

header("Location: $destino");
die();



$seccion="principal";
$nombrePagina="CRUD";

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']="socBeneficio";
}
if(isset($_GET['view'])){
	$view=$_GET['view'];
	$_SESSION['fvp']['view']=$view;
}
$view=$_SESSION['fvp']['view'];

in_array($view, $_SESSION['fvp']['tablasSeguras']) ? $tablaSegura=TRUE : $tablaSegura=FALSE ;

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$mysqli=conectar($datosConexion);
$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}



$sql="SELECT descriptor, alias, rango FROM ctrlViews ORDER BY alias ASC";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if($row['rango']<3){
				$_SESSION['fvp']['ctrlViews'][$row['descriptor']]=$row['alias'];
			}
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 
//p($P,$ctrlViews);

$sql ="SELECT * FROM v_$view ";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			foreach ($row as $key => $value) {
				if($key=='id' OR ( strlen($key)>2 AND substr($key, 0,2)!='id') ){
					$tabla[$row['id']][$key]=$value;
					$titulos[$key]=$key;
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
	$t.='<th>'.$value.'</th>';
}
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
	<form action="crudU.php" method="get">
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


<body style="margin-top:18px;background: #dddddd">

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
									<form action="crudC.php" method="POST">
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
		$('#example').DataTable({
			"scrollX": true
		});
	} );
</script>





<!--
<div class="container">
   <div class="row">
      <div class='col-sm-6'>
         <div class="form-group">
            <div class='input-group date' id='datetimepicker1'>
               <input type='text' class="form-control" />
               <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
               </span>
            </div>
         </div>
      </div>


     <script type="text/javascript">
         $(function () {
             $('#datetimepicker1').datetimepicker({
                 locale: 'es',
                 format: 'DD/MM/YYYY'
             });
         });
      </script>


   </div>
</div>
-->


