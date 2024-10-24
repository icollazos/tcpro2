<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=0; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;


$misDatos=$_SESSION['fvp']['misDatos'];

$seccion="principal";

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']=$esteAmbito;
}
$nivelDeUsuario=$_SESSION['fvp']['nivel'];
p($P,$nivelDeUsuario);

if($nivelDeUsuario>4){
	$disabled="disabled";
}
#p($P,$disabled);

if(isset($_GET['view'])){
	$view=$_GET['view'];
	$_SESSION['fvp']['view']=$view;
}
$view=$_SESSION['fvp']['view'];

$idUsuario=$_SESSION['fvp']['idUsuario'];

$clausulaMisDatos='';
$sql="SELECT column_name
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'v_$view';";
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

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);


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
$nombrePagina=strtoupper($aliasCampos[$_SESSION['fvp']['view']]);
#p($P,$aliasCampos);

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: ../gen_login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
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

$sql ="SELECT * FROM v_$view WHERE id<>1 AND borrar='0'";
$sql ="SELECT * FROM v_$view WHERE id<>1 $clausulaMisDatos ORDER BY id DESC LIMIT 0,5000";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			foreach ($row as $key => $value) {
				if($key=='id' OR ( strlen($key)>2 AND substr($key, 0,2)!='id') ){
					if( ! in_array ($key, array ('fechaNacimiento_YYYY', 'fechaNacimiento_MM', 'fechaNacimiento_DD', 'fechaNacimiento_SEMANA' ) )){
						$tabla[$row['id']][$key]=substr($value, 0, 30);
						$titulos[$key]=$key;
						$string2.=implode("\t", $row);
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
$sqlMisDatos=$sql;
#p($P,$tabla);
/*
p($P,$sql);
p($P,$titulos);
*/

$t='<thead><tr>';
foreach ($titulos as $key => $value) {
	if(isset($aliasCampos[$value])){
		$v = $aliasCampos[$value];
	} else {
		$v=$value;
		$v=str_replace("_", " ", $v);
		$v=str_replace("descriptor", "", $v);
		$v=str_replace("id ", " ", $v);
	}
	$t.='<th>'.$v.'</th>';		
}
$t.='<th style="width:5%">Documentos</th>';
$t.='<th style="width:5%">Ver</th>';
$t.='<th style="width:5%">Editar</th>';
$t.='<th style="width:5%">Eliminar</th>';
$t.='</tr></thead><tbody>';
foreach ($tabla as $key => $value) {
	$t.='<tr>';
	foreach ($value as $key2 => $value2) {
		$t.='<td><small>'.$value2.'</small></td>';	
	}
	$t.='<td>
	<form action="documentacion.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="view" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-info btn-sm" onclick="this.form.submit();">
	Ver
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudV.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-info btn-sm" onclick="this.form.submit();">
	Ver
	<span class="glyphicon glyphicon-search" aria-hidden="true" onclick="this.form.submit();"></span>
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudCU.php" method="POST">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-warning btn-sm"  onclick="this.form.submit();" '.$disabled.'>
	Editar
	</button>
	</form>
	</td>';
	$t.='<td>
	<form action="crudD.php" method="get">
	<input type="hidden" name="from" value="'.$esteArchivo.'">
	<input type="hidden" name="tabla" value="'.$view.'">
	<input type="hidden" name="idRegistro" value="'.$key.'">
	<button class="btn btn-danger btn-sm"  onclick="this.form.submit();" '.$disabled.'>
	Eliminar
	</button>
	</form>
	</td>';
	$t.='</tr>';
}
$t.='</tbody>';



if($_POST['accion']=='limpiarTabla'){
	$tabla=$_POST['tabla'];
	$sql="DELETE FROM $tabla WHERE id>1";
	p($P,$sql);
	if ($result = $mysqli->query($sql)) {}
}



$array = array(
  "Nombre",
  "Apellido",
  "Edad",
);

$string = "";

for ($i = 0; $i < count($array); $i++) {
  $string .= $array[$i] . "\t";
}

$string .= "\n";


// Almacena el string en un campo de texto


?>

<html>
<? include('../000_head.php');?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<? 
			echo $panelAlerta;
			/*
			echo $misDatos;
			p($P,$listaCampos);
			p($P,$clausulaMisDatos);
			p($P,$sqlMisDatos);
			*/
			?>
			<form action="crudCU.php" method="POST" id="formCU">
				<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
				<input type="hidden" name="tabla" value="<? echo $view;?>">
				<!--<button type="submit" class="btn btn-primary btn-sm">Agregar Registro</button>-->
			</form>
			<form action="" method="POST" id="limpiarTabla">
				<input type="hidden" name="accion" value="limpiarTabla">
				<input type="hidden" name="tabla" value="<? echo $view;?>">
				<!--<button type="submit" class="btn btn-primary btn-sm">Limpiar</button>-->
			</form>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
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

<script>
function copiar() {
	var texto = document.getElementById("campo_texto").value;
	navigator.clipboard.writeText(texto);
}
</script>


</html>
<?
#include("000_navbarBottom.php");
?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var view='<?echo $view;?>';
		$('#example').DataTable( {
			dom: 'Bfrtip',
			scrollX: true,
			stateSave: true,
			lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 rows','10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'colvis', 'pageLength'
			],
			"pageLength":5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		} );
		$(document).on( 'init.dt', function ( e, settings ) {
			var api = new $.fn.dataTable.Api( settings );
			console.log( 'New DataTable created:', api.table().node() );
			var e=$("#example_filter");
			var b1 = $("<button>Agregar Registro</button>");
			b1.attr("type", "submit");
			b1.attr("id", "b1");
			b1.attr("class", "btn btn-success btn-sm  btn-datatable");
			e.before(b1);
			b1.click(function() {
				$("#formCU").submit();
			});
			/*
			var b2 = $("<button>Limpiar tabla</button>");
			b2.attr("type", "submit");
			b2.attr("id", "b2");
			b2.attr("class", "btn btn-warning btn-sm btn-datatable");
			b2.attr("margin-right", "15px;");
			e.before(b2);
			b2.click(function() {
				$("#limpiarTabla").submit();
			});
			*/
			var b3 = $("<button>Copia toda la data</button>");
			b3.attr("type", "submit");
			b3.attr("id", "b3");
			b3.attr("class", "btn btn-success btn-sm btn-datatable");
			b3.attr("margin-right", "15px;");
			e.before(b3);
			b3.click(function() {
				$("#limpiarTabla").submit();
			});

		} );


	} );
</script>


<script>


	function l(variable){ console.log(variable); }

	$(document).ready(function() {

  // Create a new button
  var button = $("<button class='btn btn-primary'>Link</button>");

  // Add the button to the datatable
  $("#example").dataTable().buttons().add(button);

  // Set the href of the button
  button.attr("href", "http://www.example.com");

  // Set the target of the button
  button.attr("target", "_blank");
});
</script>