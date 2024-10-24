<?
session_start();
$uniUsuario=$_SESSION['fvp']['uniUsuario'];
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$_SESSION['fvp']['P']=$P;
$_SESSION['fvp']['datosConexion']=$datosConexion;

p($P,$_POST);




if(isset($_POST['tabla'])){
	$_SESSION['fvp']['tabla']=$_POST['tabla'];
	$_SESSION['fvp']['from']=$_POST['from'];
}
$tabla=$_SESSION['fvp']['tabla'];
$from=$_SESSION['fvp']['from'];

if(isset($_POST['idRegistro'])){
	$idRegistro=$_POST['idRegistro'];
	$_SESSION['fvp']['idRegistro']=$idRegistro;
	p($P,$idRegistro);
	$_SESSION['fvp']['postInicial']=$_POST;
	$_SESSION['fvp']['valoresIniciales']=cargaValoresIniciales($tabla,$idRegistro);
	$valoresIniciales=$_SESSION['fvp']['valoresIniciales'];
	#p($P,$valoresIniciales);
} else {
	unset($_SESSION['fvp']['valoresIniciales']);
}

$tablasSeguras=array('persona','legExpediente');
in_array($tabla, $tablasSeguras) ? $seguro=1 : $seguro=0;


$ruta=$_SESSION['fvp']['ruta'];


?>

<? include('../000_head.php'); ?>
<body>
		<? include("../000_navbar.php"); ?>
	<main>
		<? include("../00_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white" style="width: 85%;">
			<br>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Nuevo Archivo de Documentación para <strong><? echo ucwords($tabla);?></strong></h3>
				</div>
				<div class="panel-body" style="min-height: 0px;">
					<div class="">

						<form enctype="multipart/form-data" action="documentacion.php" method="POST">
							<input type="hidden" name="MAX_FILE_SIZE" value="512000" />
							<p> Enviar mi archivo: <input name="subir_archivo" type="file" /></p>
							<p> <input type="submit" class="btn btn-primary" value="Enviar Archivo" /></p>
							<a href="documentacion.php?view=<?echo $tabla;?>" class="btn btn-default">Volver</a>
						</form>
						<br>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>

<script type="text/javascript">
	function filtra( padre, hijo){
		console.log("FILTRAR");
		var e=document.getElementById(padre);
		var idPadre = e.value; 
		$.ajax({
			type: "POST",
			url: "ajaxSelect.php",
			data: {
				padre: padre,
				hijo: hijo,
				idPadre: idPadre
			},
			cache: false,
			success: function(data) {
			//console.log("CARGO SELECT");
			data=JSON.parse(data);
			var hijos=data['hijos'];
			var options=data['options'];	
			for (var i = 0; i < (hijos.length - 1) ; i++) {
				var select=document.getElementById(hijos[i]);
				select.innerHTML='';
				var op = document.createElement("option");
				op.setAttribute("value", 0);
				var txt = document.createTextNode("Seleccione...");
				op.appendChild(txt);
				select.appendChild(op);
				if(hijos[i]!='idPersona'){
				}
			}
			poblar(hijo,options);
		},
		error: function(xhr, status, error) {
			console.error(xhr);
		}
	});
	}

	function p(a){
		if(a==1){
			alert("P");
		}
	}

	function poblar(hijo,options){
	//console.log("POBLAR");
	let select=document.getElementById(hijo);
	for (var i = 0; i < options.length; i++) {
		var op = document.createElement("option");
		op.setAttribute("value", options[i].id);
		var txt = document.createTextNode(options[i].descriptor);
		op.appendChild(txt);
		select.appendChild(op);
	}
}
</script>
