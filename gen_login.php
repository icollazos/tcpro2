<?

//inicializando
session_start();
$P=1; //define si los pre se ven o no
include('000_conexion.php');

#p($P, $_POST);


unset($_SESSION['fvp']);
unset($_SESSION['salida']);
$x='tioconejo';
if(isset($_GET['x'])){
	$x=$_GET['x'];
}
$logos=explode(',',logos($x));
$membrete=explode(',',membretes($x));;
$logosCreditos=explode(',',logosCreditos($x));
$_SESSION['refCliente']=$x;
$_SESSION['cliente']=cliente($x);
$_SESSION['nomCliente']=nomCliente($x);
//p($P,$logos);

$seccion="principal";
$nombrePagina="Login";

$mysqli=conectar($datosConexion);
#p($P,$mysqli);

$panelAlerta='';

unset($_SESSION['fvp']);

if($_POST){
	$uniUsuario=$_POST['uniUsuario'];
	$uniUsuario=strtolower($uniUsuario);
	$clave=$_POST['clave'];
	$clave=strtolower($clave);
	$mensaje='';
	$view='v_adm_usuario';
	$i=0;
	$prefijos=array(
		'1'=>'gen',
		'2'=>'adm',
		'3'=>'adm'
	);
	$sql ="SELECT id, descriptor, id_perfil_usuario FROM $view WHERE LOWER(descriptor)=LOWER('$uniUsuario') AND LOWER(clave)=LOWER('$clave') ";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		#echo "RESULT";
		$sqlResult=1;
		$sqlRows=0;
		if ($result->num_rows> 0){
			while ($row = $result->fetch_array()){
				$sqlRows++;
				$_SESSION['fvp']['idUsuario']=$row['id'];
				$_SESSION['fvp']['usuarioActivo']=1;
				$_SESSION['fvp']['uniUsuario']=$row['descriptor'];
				$_SESSION['fvp']['id_perfil_usuario']=$row['id_perfil_usuario'];
			}
		} else {
		}
		$result->close();
	} else {
		$sqlResult = mysqli_error($mysqli);
	} 
	if ($sqlRows==0) {
		$mensaje="No encontramos un usuario que cumpla esas condiciones. Por favor intente de nuevo.";
		$panelAlerta=panel('danger','Usuario no identificado',$mensaje);
	} else {

		$id_perfil_usuario=$_SESSION['fvp']['id_perfil_usuario'];
		$prefijo=$prefijos[$id_perfil_usuario];
		$_SESSION['fvp']['prefijo']=$prefijo;

		#p($P,$_SESSION);

		header("Location: usr_".$prefijo."/filtrado_consulta.php");
	}
}

?>

<? include('000_head.php'); ?>
<link rel="stylesheet" href='bs/css/theme_lux.css' />
</head>
<body class="py-4 bg-default">
	<main>
		<div class="container">
			<div class="row justify-content-center align-items-center" style="min-height:0px;">
				<div class="col-6">
					<div class="row">
						<div class="col">
							<div class="card mb-3">
								<div class="text-center">
									<? foreach ($logos as $key => $value) { ?>
										<img src="logos/<? echo $value; ?>" class="card-img-right" alt="..." width="40%" style="margin-top: 50px;">
									<? } ?>
								</div>
								<div class="card-body">
									<br><br>
									<h5 class="text-center" style="font-size: 100%;"><strong><? echo $membrete[0];?></strong></h5>
									<h5 class="text-center" style="font-size: 200%;"><strong><? echo $membrete[1];?></strong></h5>
									<br>
									<form class="form-horizontal" action="" method="post">
										<div class="form-group">
											<br>
											<label for="floatingInput">Usuario</label>
											<input type="text" class="form-control" id="floatingInput" placeholder="Nombre de Usuario" name="uniUsuario">
										</div>
										<div class="form-group">
											<br>
											<label for="floatingPassword">Clave</label>
											<input type="password" class="form-control" id="floatingPassword" placeholder="Clave secreta" name="clave">
										</div>
										<br>
										<hr>
										<div class="d-grid gap-2" style="">
											<button type="submit" class="btn btn-primary btn-block py-2">Entrar</button>
										</div>
									</form>
								</div>
								<div class="text-center">
									<? foreach ($logosCreditos as $key => $value) { ?>
										<img src="logos/<? echo $value; ?>" class="card-img-right" alt="..." width="20%" style="margin-top: 20px;">
									<? } ?>
								</div>
								<div>
									<!--<p class="text-center" style="font-size: 120%;"><strong><br>Powered by TCPRO</strong></p>-->
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<form class="form-horizontal" action="" method="post">
												<input type="hidden" class="form-control" id="floatingInput" placeholder="Nombre de Usuario" name="uniUsuario" value="a">
												<input type="hidden" class="form-control" id="floatingPassword" placeholder="Clave secreta" name="clave" value="a">
												<div class="d-grid gap-2">
													<button type="submit" class="btn btn-info btn-block py-2">Entrar como administrador</button>
												</div>
											</form>
										</div>
										<div class="col">
											<form class="form-horizontal" action="" method="post">
												<input type="hidden" class="form-control" id="floatingInput" placeholder="Nombre de Usuario" name="uniUsuario" value="b">
												<input type="hidden" class="form-control" id="floatingPassword" placeholder="Clave secreta" name="clave" value="b">
												<div class="d-grid gap-2">
													<button type="submit" class="btn btn-info btn-block py-2">Entrar como analista</button>
												</div>
											</form>
										</div>
									</div>
									<br>
									<form class="form-horizontal" action="" method="post">
										<input type="hidden" class="form-control" id="floatingInput" placeholder="Nombre de Usuario" name="uniUsuario" value="ICOLLAZOS">
										<input type="hidden" class="form-control" id="floatingPassword" placeholder="Clave secreta" name="clave" value="ICOLLAZOS">
										<div class="d-grid gap-2">
											<button type="submit" class="btn btn-info btn-block py-2">Entrar como Developer</button>
										</div>
									</form>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-body">
									<h5 class="text-center" style="font-size: 100%;"><strong>Enlaces</strong></h5>
									<a class="btn btn-primary" href="https://igorcollazos.alwaysdata.net/tcpro/gen_login.php?x=bancoCentralChile">BCCH</a>
									<a class="btn btn-primary" href="https://igorcollazos.alwaysdata.net/tcpro/gen_login.php?x=presidenciaArgentina">ARG</a>
								</div>
							</div>
							<!--
							<div class="card mb-3">
								<div class="card-body">
									<div class="text-center">
										<p class="text-center" style="font-size: 100%;"><strong>Desarrollado por Igor Collazos</strong></p>
										<p class="text-center" style="font-size: 100%;"><strong>Todos los derechos reservados</strong></p>
									</div>
								</div>
							</div>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</main>
<br><br><br><br><br><br>
</body>
</html>

