<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador

$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Chat Bot';

$misDatos=$_SESSION['fvp']['misDatos'];

$refCliente=$_SESSION['refCliente'];
$cliente=$_SESSION['cliente'];
$nomCliente=nomCliente($_SESSION['refCliente']);
$chatbot=chatbot($_SESSION['refCliente']);

$_SESSION['fvp']['view']=$estaVista;
$view=$_SESSION['fvp']['view'];

$idUsuario=$_SESSION['fvp']['idUsuario'];
unset($_SESSION['fvp']['crud']);
unset($_SESSION['fvp']['idRegistro']);
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: ../gen_login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}


?>


<? include('../000_head.php');?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<? 
			echo $panelAlerta;
			?>
			<div class="row">
				<div class="col col-4">
				</div>
				<div class="col col-4">
					<div class="card">
						<div class="card-header">
							Chatbot <?echo $nomCliente;?>
						</div>
						<div class="card-body">
							<iframe src="<?echo $chatbot;?>" frameborder="1" style="height: 740px; width: 100%;"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
</body>
</html>

<script type="text/javascript">
	function l(variable){ console.log(variable); }
</script>

