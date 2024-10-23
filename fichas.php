<?

//inicializando
session_start();

$P=$_SESSION['fvp']['P']; //define si los pre se ven o no
include('00_conexion.php');
$mysqli=conectar($datosConexion);

$seccion="principal";
$nombrePagina="FICHAS DE DETALLE";
$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$aliasCampos=aliasCampos($datosConexion);

#p($P,$aliasCampos);

if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}
$idUsuario=$_SESSION['fvp']['idUsuario'];

$raiz='per_persona';
if(!isset($_SESSION['fvp']['raiz'])){
	$raiz='per_persona';
}
if(isset($_POST['raiz'])){
	$raiz=$_POST['raiz'];
	unset($_SESSION['fvp']['valor']);
} else {
	$raiz=$_SESSION['fvp']['raiz'];
}
$_SESSION['fvp']['raiz']=$raiz;
#p($P,$_SESSION['fvp']['raiz']);

if(!isset($_SESSION['fvp']['valor'])){
	$valor='1';
}
if(isset($_POST['valor'])){
	$valor=$_POST['valor'];
} else {
	$valor=$_SESSION['fvp']['valor'];
}
$_SESSION['fvp']['valor']=$valor;

#p($P,$raiz);
$hijos=hijos($datosConexion,$raiz);


?>

<? include('htmlHead.php'); ?>


<body>

	<? include('navbar.php'); ?> 
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="col-md-3" style="margin-bottom: 24px;">
					<div class="panel panel-default">
						<div class="panel-body"  style="padding-bottom: 24px;">
							<h3><strong><?echo $nombrePagina?></strong></h3>
							<hr>
							<label>Seleccione la tabla base</label>
							<form action="" method="POST">
								<div class="form-group">
									<select name="raiz" class="form-control" onchange="this.form.submit();">
										<option value="<?echo $raiz?>">Actual: <?echo $aliasCampos[$raiz];?></option>
										<?echo opcionesTablas($datosConexion,$aliasCampos,$raiz);?>
									</select>
								</div>
							</form>
							<label>Seleccione el valor a explorar</label>
							<form action="" method="POST">
								<div class="form-group">
									<select name="valor" class="form-control" onchange="this.form.submit();">
										<?echo opcionesValores($datosConexion,$raiz,$valor);?>
									</select>
								</div>
							</form>

						</div>
					</div>
				</div>
				<div class="col-md-9">
					<?
					foreach ($hijos as $hijo => $alias) {
						echo acordeon($hijo, $alias, $datosConexion, $raiz, $valor);
					}
					?>
				</div>
			</div>
		</div>
	</div>

</body>
</html>

<?

function acordeon($hijo, $alias, $datosConexion, $raiz, $valor){
	$P=$_SESSION['fvp']['P'];
	#p($P,$hijo.' - '.$alias.' - '.$raiz.' - '.$valor);
	$mysqli=conectar($datosConexion);
	$aliasCampos=$_SESSION['fvp']['aliasCampos'];
	$sql="SELECT * FROM v_$hijo WHERE id$raiz='$valor' ";
	#echo $sql;
	$tabla='';
	$dt='';
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$tabla.='<div class="panel-group" id="accordion_'.$hijo.'_'.$row['id'].'" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="heading_'.$hijo.'_'.$row['id'].'"><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion_'.$hijo.'_'.$row['id'].'" href="#collapse_'.$hijo.'_'.$row['id'].'" aria-expanded="true" aria-controls="collapseOne">'.$alias.': '. $row['id'].' | '.$row['descriptor'] .'</a></h4></div>
				<div id="collapse_'.$hijo.'_'.$row['id'].'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_'.$hijo.'_'.$row['id'].'">
				<div class="panel-body">
				<table class="display" id="DT_'.$hijo.'_'.$row['id'].'" style="width: 100%;">';
				#$tabla.='<thead><tr><th>#</th><th>Campo</th><th>Valor</th></tr></thead><tbody>';
				$tabla.='<thead><tr><th>Campo</th><th>Valor</th></tr></thead><tbody>';
				$keys=array_keys($row);
				$id=1;
				foreach ($keys as $k) {
					if($k=='id' OR (strlen($k)>2 AND substr($k, 0,2)!='id')){
						if(substr($k,-4)!="YYYY" AND substr($k,-2)!="MM" AND substr($k,-2)!="MM" AND substr($k,-6)!="SEMANA" ){
						#$tabla.="<tr><td>".$id."</td><td>".$k."</td><td>".$row[$k]."</td></tr>";
						$tabla.="<tr><td>".$aliasCampos[$k]."</td><td>".$row[$k]."</td></tr>";
						$id++;
						}
					}
				}
				$tabla.='</tbody></table>
				</div>
				</div>
				</div>
				</div>';
				$dt.=creaDatatable('DT_'.$hijo.'_'.$row['id']);
			}
			$z= '
			<div class="panel-group" id="accordion_'.$hijo.'" role="tablist" aria-multiselectable="true">
			<div class="panel panel-primary">
			<div class="panel-heading" role="tab" id="heading_'.$hijo.'">
			<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion_'.$hijo.'" href="#collapse_'.$hijo.'" aria-expanded="true" aria-controls="collapseOne">'.$alias.'</a></h4>
			</div>
			<div id="collapse_'.$hijo.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_'.$hijo.'">
			<div class="panel-body">'.$tabla.'
			</div>
			</div>
			</div>
			</div>
			';
			$z.=$dt;

		}
		$result->close();
	} 

	return $z;
}

function opcionesTablas($datosConexion,$aliasCampos,$raiz){
	$P=$_SESSION['fvp']['P'];
	$mysqli=conectar($datosConexion);
	$idUsuario=$_SESSION['fvp']['idUsuario'];
	$sql="SELECT idadm_perfil FROM adm_usuario WHERE id='$idUsuario'";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		$sqlResult=1;
		$sqlRows=0;
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$iduniPerfil=$row['idadm_perfil'];
			}
		} else {
		}
		$result->close();
	} else {
		$sqlResult = mysqli_error($mysqli);
	} 
	$sql="SELECT adm_views.id as id, adm_views.descriptor as descriptor, adm_views.alias as alias FROM adm_views INNER JOIN adm_viewPerfil ON adm_views.id = adm_viewPerfil.idadm_views WHERE adm_viewPerfil.idadm_perfil='$iduniPerfil' order by alias asc";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		$sqlResult=1;
		$sqlRows=0;
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				#p($P,$row);
				$opciones[$row['descriptor']]=$row['alias'];
			}
		} else {
		}
		$result->close();
	} else {
		$sqlResult = mysqli_error($mysqli);
	} 
	$z.='<option value="'.$raiz.'">Actual: '.$aliasCampos[$raiz].'</option>';
	foreach ($opciones as $key => $value) {
		$z.='<option value="'.$key.'">'.$value.'</option>';
	}
	return $z;
}

function opcionesValores($datosConexion,$raiz,$valorActual){
	$P=$_SESSION['fvp']['P'];
	$mysqli=conectar($datosConexion);
	$sql="SELECT id,descriptor FROM v_$raiz ";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				#p($P,$row);
				$opciones[$row['id']] =$row['descriptor'];
			}
		}
		$result->close();
	} 
	$z='<option value="'. $valorActual .'">Actual: '. $opciones[$valorActual] .'</option>';
	foreach ($opciones as $k=>$v) {
		$z.='<option value="'. $k .'">'. $v .'</option>';
	}
	$mysqli->close();
	return $z;
}

function hijos($datosConexion,$raiz){
	$P=$_SESSION['fvp']['P'];
	$alias=$_SESSION['fvp']['aliasCampos'];
	$mysqli=conectar($datosConexion);
	$sql="SELECT id,hijo FROM adm_hijos WHERE padre='$raiz'";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$hijos[$row['hijo']]=$alias[$row['hijo']];
			}
			$result->close();
		}
	} 
	$mysqli->close();
	return $hijos;
}

function aliasCampos($datosConexion){
	$P=$_SESSION['fvp']['P'];
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
	#p($P,$aliasCampos);
	return($aliasCampos);
	$mysqli->close();
}
function creaDatatable($id){
	return '
	<script type="text/javascript">
		$(document).ready(function() {
			$(\'#'.$id.'\').DataTable({
				"scrollX": true,
        		"order": [[ 0, "desc" ]],
		        dom: \'Bfrtip\',
		        buttons: [
		            \'excel\',\'pdf\'
		        ]
			});
		} );
	</script>
	';
}

?>






<script type="text/javascript">
	var e=1;
	/*
	var e=document.getElementsByClassName("dt-button buttons-excel buttons-html5");
	*/
	var e=document.getElementsByClassName("dt-button");
	for (let i = 0; i < e.length; i++) {
		e[i].style.backgroundColor = "red";
	}
	console.log(e);
	e.className="btn btn-primary";
</script>