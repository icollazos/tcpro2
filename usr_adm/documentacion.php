<?

//inicializando
session_start();

$P=0; //define si los pre se ven o no
include('../000_conexion.php');

#die();

$seccion="principal";

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']="persona";
}

if(isset($_GET['view'])){
	$view=$_GET['view'];
	$_SESSION['fvp']['view']=$view;
}
$view=$_SESSION['fvp']['view'];
$_SESSION['crud']['corrida']=0;
unset($_SESSION['fvp']['crud']);

in_array($view, $_SESSION['fvp']['tablasSeguras']) ? $tablaSegura=TRUE : $tablaSegura=FALSE ;

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$mysqli=conectar($datosConexion);



################################### BUSCA EL TITULO DE LA PAGINA

$sql="SELECT descriptor,alias FROM Alias";
#p($P,$sql);
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
//p($P,$aliasCampos);

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

$sql="SELECT descriptor, alias, rango FROM uniViews ORDER BY alias ASC";
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




##################################################### CREA LAS OPCIONES DE SELECCION PARA LA PAGINA ACTUAL

if(isset($_GET['idRegistro'])){
	$_SESSION['fvp']['idRegistro']=$_GET['idRegistro'];
}

$idRegistro=$_SESSION['fvp']['idRegistro'];

$sql="SELECT $view.id as id, $view.descriptor as descriptor FROM $view ORDER BY descriptor ASC";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$arrayOpciones[$row['id']]=$row['descriptor'];
		}
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

$opciones.='<option value="'.$idRegistro.'">'.$arrayOpciones[$idRegistro].'</option>';

$sql="SELECT $view.id as id, $view.descriptor as descriptor FROM $view ORDER BY descriptor ASC";
#p($P,$sql);
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$opciones.='<option value="'.$row['id'].'">'.$row['descriptor'].'</option>';
		}
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

$id=$_GET['idRegistro'];
$sql="SELECT $view.id as id, $view.descriptor as descriptor FROM $view WHERE id='$id'";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$registroActual=$row['descriptor'];
		}
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 


$ruta=$_SESSION['fvp']['ruta'];
$directorio = $ruta;
//p($P,$directorio);

$subir_archivo = $directorio.basename($_FILES['subir_archivo']['name']);
#echo "<div>";
if (move_uploaded_file($_FILES['subir_archivo']['tmp_name'], $subir_archivo)) {
	#header("location: documentacion.php");
     //echo "El archivo es válido y se cargó correctamente.<br><br>";
	   //echo"<a href='".$subir_archivo."' target='_blank'><img src='".$subir_archivo."' width='150'></a>";
} else {
       //echo "La subida ha fallado";
}
#echo "</div>";


$ruta='../archivos/'.$view . '/' . $idRegistro.'/';

if (!file_exists($ruta)) {
	mkdir($ruta, 0777, true);
}

$_SESSION['fvp']['ruta']=$ruta;
$archivos=obtener_estructura_directorios($ruta);
#p($P,$archivos);



?>
<html>
<? include('../000_head.php'); ?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row">
						<div class="col-md-10">
							<h1><strong>Portafolio de: <?echo $registroActual;?></strong></h1>
						</div>
						<div class="col-md-2" style="margin-top: 18px;">
							<div class="text-right">
								<form action="documentacionC.php" method="POST">
									<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
									<button type="submit" name="tabla" class="btn btn-primary btn-md" value="<? echo $view;?>">
										Agregar Documento
									</button>
								</form>
							</div>
						</div>
					</div>
					<hr>
					<div class="col-md-2">
						<form action="" method="GET">
							<div class="form-group">
								<input type="hidden" name="view" value="<?echo $view;?>" >
								<select name="idRegistro" class="form-control" onchange="this.form.submit()">
									<? echo $opciones;?>
								</select>
							</div>
						</form>
					</div>
					<div class="col-md-10">
						<?

						foreach ($archivos as $key => $value) {

							if( in_array($value[1], array('jpg','jpeg','tif','tiff','png')) ){ 
								$file=$ruta.$value[0].'.'.$value[1];
									#p(1,$file);
								$size=getimagesize($file);
									#p(1,$size);
								if($size[0]>$size[1]){
									$style="width:100%;";
								} else {
									$style="height:200px;";
								}

								?>
								<div class="col-xs-6 col-md-2">
									<? echo '<a target="_blank" href="'.$ruta.$value[0].'.'.$value[1].'" class="thumbnail" style="height:250px;">';?>
									<? echo '<img src="'.$ruta . $value[0].'.'.$value[1].'" alt="..." style="'.$style.'">';?>
									<div class="caption" style="height: 36px;">
										<p class="text-center"><? echo (substr($value[0],0,20).'.'.$value[1]); ?></p>
									</div>
								</a>
							</div>
						<? } ?>

						<?
						if( in_array($value[1], array('pdf','PDF')) ){ ?>
							<div class="col-xs-6 col-md-2">
								<? echo '<a target="_blank" href="'.$ruta.$value[0].'.'.$value[1].'" class="thumbnail">';?>
								<? echo '<img src="archivos/PDF.png" alt="..." style="height: 200px;">';?>
								<div class="caption" style="height: 36px;">
									<p class="text-center"><? echo (substr($value[0],0,20).'.'.$value[1]) ?></p>
								</div>
							</a>
						</div>
					<? } ?>

					<?
					if( in_array($value[1], array('xls','XLS','xlsx')) ){ ?>
						<div class="col-xs-6 col-md-2">
							<? echo '<a target="_blank" href="'.$ruta.$value[0].'.'.$value[1].'" class="thumbnail">';?>
							<? echo '<img src="archivos/XLS.png" alt="..." style="height: 200px;">';?>
							<div class="caption" style="height: 36px;">
								<p class="text-center"><? echo (substr($value[0],0,20).'.'.$value[1]) ?></p>
							</div>
						</a>
					</div>
				<? } ?>

				<?
				if( in_array($value[1], array('doc','DOC', 'docx')) ){ ?>
					<div class="col-xs-6 col-md-2">
						<? echo '<a target="_blank" href="'.$ruta.$value[0].'.'.$value[1].'" class="thumbnail">';?>
						<? echo '<img src="archivos/DOC.jpg" alt="..." style="height: 200px;">';?>
						<div class="caption" style="height: 36px;">
							<p class="text-center"><? echo (substr($value[0],0,20).'.'.$value[1]) ?></p>
						</div>
					</a>
				</div>
			<? } ?>

			<?
			if( in_array($value[1], array('ppt','PPT','pptx')) ){ ?>
				<div class="col-xs-6 col-md-2">
					<? echo '<a target="_blank" href="'.$ruta.$value[0].'.'.$value[1].'" class="thumbnail">';?>
					<? echo '<img src="archivos/PPT.jpg" alt="..." style="height: 200px;">';?>
					<div class="caption" style="height: 36px;">
						<p class="text-center"><? echo (substr($value[0],0,20).'.'.$value[1]) ?></p>
					</div>
				</a>
			</div>
		<? } ?>

	<? } ?>


</div>
</div>
</div>
</div>    		
</div>

</div>
</main>
</body>
</html>


<?


function obtener_estructura_directorios($ruta){
    // Se comprueba que realmente sea la ruta de un directorio
	if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
		$gestor = opendir($ruta);
		echo "<ul>";

        // Recorre todos los elementos del directorio
		while (($archivo = readdir($gestor)) !== false)  {

			$ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
			if ($archivo != "." && $archivo != "..") {
                // Si es un directorio se recorre recursivamente
				$x=explode(".", $archivo);
				$z[]=$x;
				if (is_dir($ruta_completa)) {
					obtener_estructura_directorios($ruta_completa);
				}
			}
		}

        // Cierra el gestor de directorios
		closedir($gestor);
		echo "</ul>";
	} else {
		//echo "No es una ruta de directorio valida<br/>";
	}
	return $z;
}


?>