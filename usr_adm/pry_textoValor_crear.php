<?
session_start();
$uniUsuario=$_SESSION['fvp']['uniUsuario'];
include('../000_conexion.php');
$mysqli=conectar($datosConexion);
$P=1;
$_SESSION['fvp']['P']=$P;

$td=$_POST['tabla'];
$from=$_POST['from'];
$idVariable=$_GET['idVariable'];
$idTexto=$_GET['idTexto'];

$sql="SELECT id, descriptor, textoLimpio, textoTarzan FROM aaa_texto WHERE id='$idTexto'";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$t['id']=$row['id'];
			$t['descriptor']=$row['descriptor'];
			$t['textoLimpio']=$row['textoLimpio'];
			$t['textoTarzan']=$row['textoTarzan'];
		}
	} 
	$result->close();
} 

$sql="SELECT aaa_dicDescarte.descriptor as d FROM aaa_dicDescarte WHERE idaaa_idioma=2";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$dd[]=strtolower($row['d']);
		}
	} 
	$result->close();
} 

$tt=explode(" ", $t['descriptor']);
$q=0;
foreach ($tt as $key => $value) {
	
	$t2[$key]['original']=$value;
	
	if(!in_array(strtolower($value),$dd)){
		$t2[$key]['clase']="palabra";
		$t2[$key]['idNuevo']=$q;
		$q++;
	}  else {
		$t2[$key]['clase']="gris";
	}

	$t2[$key]['limpio']=limpiar($value);
}
#p($P,$t2);

function limpiar($x){
	$x=strtolower($x);
	$busca = 		['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü'];
	$reemplaza = 	['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'n', 'u', 'u'];
	$x = str_replace($busca, $reemplaza, $x);
	return preg_replace('/[^a-z0-9]/', '', $x);
}


$lemas=str_replace("_ ", "", $t['textoTarzan']);
$lemas=str_replace(".", " ", $lemas);
$lemas=str_replace("  ", " ", $lemas);
$lemas=str_replace("  ", " ", $lemas);
$lemas=explode(" ",$lemas);
foreach ($lemas as $key => $value) {
	$pares[]=$lemas[$key].'-'.$lemas[$key+1];
}
$lemas=array_unique($lemas);
sort($lemas);
#p($P,$lemas);

?>


<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="../calendar/css/calendar_style.css">
<style>
	.palabra {
		cursor: pointer;
		border-radius: 3px;
		padding-left: 0px;
		padding-right: 5px; 
	}
	.gris {
		/*color:#aaa;*/
	}
</style>
<html>
<? include('../000_head.php'); ?>
<script src="frn_funciones.js"></script> <!-- funciones de selects indispensables-->

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="col">
				<div class="card">
					<h5 class="card-header">Entrenamiento del Robot</h5>
					<div class="card-body">
						<div class="row">
							<h5 class="card-title">Texto original</h5>
							<p class="card-text">
								<?
								foreach ($t2 as $key => $value) {
									echo '&nbsp;<span id="'.$value['idNuevo'].'" value="'.$value['limpio'].'"class="'.$value['clase'].'"> '.$value['original'].'</span>';
								}
								?>
							</p>
						</div>
						<hr>
						<div class="row">
							<div class="col-6">
								<table class="table" id="tablaValores">
									<thead>
										<tr>
											<th>Id</th>
											<th>Valor</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="col">
								<input type="hidden" id="inputIdVariable" value="<?echo $_GET['idVariable']?>">
								<input type="hidden" id="inputIdTexto" value="<?echo $_GET['idTexto']?>">
								<label for="" class="form-label">Seleccione el valor a asignar</label>
								<select class="form-control" id="valor">
									<? foreach ($opciones as $key => $value) { echo '<option value="'.$key.'">'.$value.'</option>'; }?>
								</select>
								<label for="" class="form-label">Verifique sus evidencias y grabe</label><br>
								<button href="#" class="btn btn-primary btn-sm" onclick="enviar()">Grabar</button><br>
								<label for="" class="form-label">Volver a la tabla principal</label><br>
								<a href="https://igorcollazos.alwaysdata.net/tcpro/usr_adm/pry_textoValor_tabla.php" class="btn btn-success btn-sm">Salir</a>
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
	const palabras = document.querySelectorAll('.palabra');
	palabras.forEach(function(palabra) {
		palabra.addEventListener('click', function() {
			this.classList.toggle('bg-warning');
		});
	});

	$(document).ready(function() {
		iniciarSelect();
	});
	$(document).ready(function() {
		iniciarTabla();
});

</script>



<script type="text/javascript">


	function iniciarSelect(){
		l("iniciar select")
		var sel=$("#valor");
		sel.empty();
		var q=0;
		var argumentos={};
		argumentos['idVariable'] =<?echo $_GET['idVariable']?>;
		argumentos['idTexto']=<?echo $_GET['idTexto']?>;
		argumentos['funcionLlamada']="iniciarSelect";
		l("argumentos");
		l(argumentos);
		postData('pry_textoValor_funciones.php', { 
			argumentos:argumentos
		})
		.then(data => {
			l("Recibiendo Datos Select")
			l(data);
			creaSelect("valor",data);
		});	
	}

	function iniciarTabla(){
		l("Iniciar Tabla");
		var q=0;
		var argumentos={};
		argumentos['idVariable'] =<?echo $_GET['idVariable']?>;
		argumentos['idTexto']=<?echo $_GET['idTexto']?>;
		argumentos['funcionLlamada']="iniciarTablaV";
		l("argumentos");
		l(argumentos);
		postData('pry_textoValor_funciones.php', { 
			argumentos:argumentos
		})
		.then(data => {
			l("Recibiendo Datos Tabla")
			l(data);
			creaTabla("valor",data);
		});	
		/*
		*/
	}

	function creaTabla(id,data){
		l("CREANDO TABLA 2")
		var b=$('#tablaValores tbody');
		b.empty();
		l(data);
		$.each(data, function(index, item) {
			const $fila = $('<tr></tr>');
			$fila.append($('<td></td>').text(item.value));
			$fila.append($('<td></td>').text(item.text));			
			b.append($fila);
		});
	}

	
	function enviar(){
		l("ENVIANDO")
		const palabras = document.querySelectorAll('.bg-warning');
		l(palabras);
		var q=0;
		var argumentos={};
		argumentos['idTexto']=<?echo $_GET['idTexto'];?>;
		argumentos['lemapares']={};
		var a = new Array();
		for (var i = 0; i < palabras.length   ; i++) {
			l(palabras[i].getAttribute('value'));
			a[q]={
				'id'	: palabras[i].getAttribute('id'),
				'value'	: palabras[i].getAttribute('value')
			};
			q++;
		}
		l(a);
		argumentos['lemapares']=a;
		var id;
		var valor;
		argumentos['valor']=$("#valor").val();
		l("argumentos");
		l(argumentos);
		argumentos['funcionLlamada']="creaTextoValor";
		if($("#valor").val()==0 || palabras.length==0 ){
			alert("¡Debes seleccionar un valor y asociarle al menos una palabra!");
		} else {
			postData('pry_textoValor_funciones.php', { 
				argumentos:argumentos
			})
			.then(data => {
				l("Recibiendo Datos Texto")
				$('#valor option[value="'+argumentos['valor']+'"]').remove();
				var elementosConClase = document.querySelectorAll('.bg-warning');
				elementosConClase.forEach(function(elemento) {
					elemento.classList.remove('bg-warning');
				});
				l(data);
				iniciarTabla();
			});			
		}
		iniciarTabla();
	}

</script>

<script src="../calendar/js/jquery.min.js"></script>
<script src="../calendar/js/popper.js"></script>
<script src="../calendar/js/bootstrap.min.js"></script>
<script src="../calendar/js/main.js"></script>

