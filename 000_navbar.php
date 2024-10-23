<?
session_start();
#$P=1;
$selectDoc='';
$fechaInicio=$_SESSION['fvp']['fechaInicio'];
$fechaFinal=$_SESSION['fvp']['fechaFinal'];
if(isset($_POST['fechaInicio'])){
	$fechaInicio=$_POST['fechaInicio'];
	$_SESSION['fvp']['fechaInicio']=$fechaInicio;
}
if(isset($_POST['fechaFinal'])){
	$fechaFinal=$_POST['fechaFinal'];
	$_SESSION['fvp']['fechaFinal']=$fechaFinal;
}
$fechaInicioSQL=substr($fechaInicio, 6,4).'/'.substr($fechaInicio, 3,2).'/'.substr($fechaInicio, 0,2);
$fechaFinalSQL=substr($fechaFinal, 6,4).'/'.substr($fechaFinal, 3,2).'/'.substr($fechaFinal, 0,2);
$_SESSION['fvp']['fechaInicioSQL']=$fechaInicioSQL;
$_SESSION['fvp']['fechaFinalSQL']=$fechaFinalSQL;

#p($P,$_SESSION['fvp']);

$idUsuario=$_SESSION['fvp']['idUsuario'];
$nivelDeUsuario=$_SESSION['fvp']['nivel'];

$sql="SELECT idadm_perfil, descriptor FROM adm_usuario WHERE id='$idUsuario'";
#p($P,$sql);
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$iduniPerfil=$row['idadm_perfil'];
			$_SESSION['fvp']['nivel']=$iduniPerfil;
			$nombreUsuario=$row['descriptor'];
				#p($P,$row);
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
			#echo $row['descriptor'].' '.$row['alias'].' ||| ';
			$sel='<li><a href="index.php?view='.trim($row['descriptor']).'">'.substr($row['alias'],4,50) .'</a></li>';
			#$sel='?view='.trim($row['descriptor']).'">'.substr($row['alias'],4,50);
			#$selectView.=$sel;
			$trim=trim(strtoupper(substr($row['alias'], 0,3)));
			#p($P,$trim);
			$selectView[$trim].=$sel;
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

foreach ($_SESSION['fvp']['uniViews'] as $key => $value) {
}

/*
p($P,$_SESSION['fvp']);
p($P,$_SESSION['fvp']['view']);
p($P,$_SESSION['fvp']['ctrlViews'][$_SESSION['view']]);
*/
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container-fluid">
		
		<!--
		<a class="navbar-brand" href="#" style="margin-left: 40px;"><img src="../logo.png" class="" alt="" width="24px;" style=""></a>
	-->
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<div class="collapse navbar-collapse justify-content-center" id="navbarCenteredExample" >
				<ul class="navbar-nav mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="#"><h2 style="color: white;"><?echo $nombrePagina;?></h2></a>
					</li>
				</ul>
			</div>
			<ul class="navbar-nav position-absolute end-0 mx-3">
				<? if($_SESSION['fvp']['idUsuario']){ ?>
					<li class="nav-item">
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?echo 'http://igorcollazos.alwaysdata.net/sinbypass/crudV.php?from=index.php&tabla=adm_usuario&idRegistro='.$_SESSION['fvp']['idUsuario'];?>">Usuario actual:&nbsp;<?echo $idUsuario. ' - '.$nombreUsuario. ' | Nivel: '.$nivelDeUsuario  ;?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn btn-outline-warning" href="../gen_logout.php">Salir</a>
					</li>

				<? } else { ?>

					<li class="nav-item">
						<a class="nav-link" href="../gen_login.php">Login/Register</a>
					</li>
				<? } ?>
			</ul>
		</div>
	</div>
</nav>


<!--


			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">IAEDPG</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">

							<p class="navbar-text">Fechas</p>
							<form class="navbar-form navbar-right" action="" method="post">
								<div class="form-group" style="margin-right: 0px;">
									<div class='input-group date' id='dtp2' style="width: 180px;">
										<input type='text' class="form-control" name="fechaFinal" value="<?echo $fechaFinal?>" placeholder="Final" onblur="this.form.submit();" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar">
											</span>
										</span>
									</div>
								</div>
							</form>
							<script type="text/javascript">$(function () { $('#dtp2').datetimepicker({ locale: 'es', format: 'DD/MM/YYYY' }); });</script>
							<form class="navbar-form navbar-right" action="" method="post">
								<div class="form-group"  style="margin-right: 0px;">
									<div class='input-group date' id='dtp1'  style="width: 180px;">
										<input type='text' class="form-control" name="fechaInicio" value="<?echo $fechaInicio?>" placeholder="Inicio" onblur="this.form.submit();"/>
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar">
											</span>
										</span>
									</div>
								</div>
							</form>
							<script type="text/javascript">$(function () { $('#dtp1').datetimepicker({ locale: 'es', format: 'DD/MM/YYYY' }); });</script>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
					<? if($nivelDeUsuario<4){ ?>
						<li class="dropdown">
							<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración&nbsp;<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?echo $selectViewAdm;?>
							</ul>
						</li>
					<? } ?>
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Procura&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?echo $selectViewPrc;?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proyectos&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?echo $selectViewPry;?>
							<?echo $selectViewEnt;?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Producción &nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?echo $selectViewBlq;?>
							<?echo $selectViewPan;?>
							<?echo $selectViewAcc;?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Indicadores&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?echo $selectViewInd;?>
							<li><a href="consultas.php">Ejecutar Consultas</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="index.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Monitor&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="monitor_procura.php">Monitor de Procura</a></li>
							<li><a href="monitor_bloques.php">Monitor de Producción de Bloques</a></li>
							<li><a href="monitor_produccionAccesorios.php">Monitor de Producción de Accesorios</a></li>
							<li><a href="monitor_paneles.php">Monitor de Producción de Paneles</a></li>
							<li><a href="monitor_entregaProyecto.php">Monitor de Ejecución de Proyecto</a></li>
						</ul>
					</li>
					<li class="text-right">
						<p class="navbar-text">Rango de Fechas</p>
						<form class="navbar-form navbar-right">
							<div class="form-group" style="margin-right: 0px;">
								<div class='input-group date' id='dtp2' style="width: 120px;">
									<input type='text' class="form-control" name="fechaInicio" value="" placeholder="Final"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar">
										</span>
									</span>
								</div>
							</div>
						</form>
						<form class="navbar-form navbar-right">
							<div class="form-group"  style="margin-right: 0px;">
								<div class='input-group date' id='dtp1'  style="width: 120px;">
									<input type='text' class="form-control" name="fechaInicio" value="" placeholder="Inicio"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar">
										</span>
									</span>
								</div>
							</div>
						</form>
					</li>


				</ul>

			</div>
		</div>
	</nav>
</div>
-->



</div>
