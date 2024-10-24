<?

//inicializando
session_start();


#$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$idPerfil=$_GET['id_perfil'];
$idViews=$_GET['id_views'];

$sql="SELECT id FROM adm_viewPerfil WHERE idadm_perfil='$idPerfil' AND  idadm_views='$idViews'";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0) {
		$sql2="DELETE FROM adm_viewPerfil WHERE idadm_perfil='$idPerfil' AND  idadm_views='$idViews'";
		if ($result = $mysqli->query($sql2)) {}
	} else {
		$sql2="INSERT INTO adm_viewPerfil (idadm_perfil, idadm_views) VALUES ('$idPerfil','$idViews')";
		if ($result = $mysqli->query($sql2)) {}
	}
}
header("Location:controlDeVistas.php");
die();

