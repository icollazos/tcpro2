<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=1; //define si los pre se ven o no
include('../000_conexion.php');

$seccion="principal";

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']="cid_libro";
}
$nivelDeUsuario=$_SESSION['fvp']['nivel'];
#p($P,$nivelDeUsuario);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$nombrePagina=$esteArchivo;
$nombrePagina="Control de Páginas";
$mysqli=conectar($datosConexion);

#escanear carpeta raíz
$files = scandir('../');

foreach ($files as $file) {
    if (!is_dir($file)) {
	    if(substr($file, -3)=='php'){
		    $paginas[]=$file;
	    }
    }
}

$carpetas=explode(",", "usr_adm,usr_ana");
foreach ($carpetas as $carpeta) {
$files = scandir("../$carpeta");
foreach ($files as $file) {
    if (!is_dir($file)) {
	    if(substr($file, -3)=='php'){
		    $paginas[]=$carpeta.'/'.$file;
	    }
    }
}
}

#p($P,$archivos);


$sql="SELECT id,descriptor FROM adm_perfil WHERE id>1";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$perfiles[$row['id']]=$row['descriptor'];
		}
		$result->close();
	}
} 



foreach ($paginas as $key => $value) {
	foreach ($perfiles as $key2 => $value2) {
		$tabla[$value][$key2]=0;
	}
}
/*
die();
p($P,$tabla);
*/

$sql="SELECT pagina, idadm_perfil as idPerfil FROM adm_paginaPerfil WHERE pagina<>'No Definido'";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$tabla[$row['pagina']][$row['idPerfil']]=1;
		}
		$result->close();
	}
} 


/*unset($tabla);
$tabla[0]=array(0=>'a',1=>'aa');
$tabla[1]=array(0=>'b',1=>'bb');
$tabla[2]=array(0=>'c',1=>'cc');
*/

$t='<thead><th style="height:120px;"></th>';
foreach ($perfiles as $keys => $values) {
	$t.='<th style="width:1%;"><span class="rot">'.str_replace(" ", "&nbsp;", (substr($values,0,6))) .'.</span></th>';
}
$t.="</thead><tbody>";

foreach ($tabla as $keyFila => $valueFila) {
	$t.='<tr><td>'.$keyFila.'</span></td>';
	foreach ($valueFila as $keyColumna => $valueColumna) {
		if($valueColumna==0){
			$classCelda='danger';
		} else {
			$classCelda="success";
		}
		$t.='<td class="text-center"><a class="btn btn-outline btn-sm btn-'.$classCelda.' text-'.$classCelda.'" href="controlDePaginas_togglePaginaPerfil.php?idPerfil='.$keyColumna.'&pagina='.$keyFila.'">'.$valueColumna.'</a></td>';
		//$t.='<td>'.$valueColumna.'</td>';
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
			'pageLength'
			],
			"pageLength":5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
			fixedHeader: true,

		} );



	} );
</script>
