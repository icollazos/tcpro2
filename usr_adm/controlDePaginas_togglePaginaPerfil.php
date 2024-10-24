<?

//inicializando
session_start();


#$P=1; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);

$idPerfil=$_GET['idPerfil'];
$pagina=$_GET['pagina'];

$sql="SELECT id FROM adm_paginaPerfil WHERE idadm_perfil='$idPerfil' AND pagina='$pagina'";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0) {
		$sql2="DELETE FROM adm_paginaPerfil WHERE idadm_perfil='$idPerfil' AND  pagina='$pagina'";
		if ($result = $mysqli->query($sql2)) {}
	} else {
		$sql2="INSERT INTO adm_paginaPerfil (pagina, idadm_perfil) VALUES ('$pagina','$idPerfil')";
		if ($result = $mysqli->query($sql2)) {}
	}
}
p($P,$sql2);
header("Location: controlDePaginas.php");

