<?

########################################################################################################## Inicializando
session_start();
$P=0;

if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

include('../000_conexion.php');
$nombrePagina="Tablero de Consultas Personalizadas";
$mysqli=conectar($datosConexion);

if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
}


################################################### Inicializa parametros de gráficos, para que desde el inicio funcione


if(!isset($_GET['idind_consulta'])){
	$consulta=2;
} else {
	$consulta=$_GET['idind_consulta'];
}
$sql="SELECT consulta FROM v_ind_consulta WHERE id='$consulta'";
#p($P,$sql);

if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlActual=str_replace("|", "'", $row['consulta']);
		}
	} 
	$result->close();
} 

$error=0;
if ($result = $mysqli->query($sqlActual)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			p($P,$row);

			$r[]=$row;
		}
	} 
	$result->close();
} else {
	$error=1;
	$errorLog = mysqli_error($mysqli);
	$tablaError="<thead><tr><th>Error Detectado</th></thead><tbody><tr><td><br>Se ha detectado el siguiente error en la consulta solicitada<br><br><strong>$errorLog</strong> <br><br>Por favor, corrige la sintaxis de la consulta<br><br></td></tr></tbody>";
}
$titulos=array_keys($r[0]);
$table="<thead><tr>";
foreach ($titulos as $t) {
	$table.="<th>".$t."</th>";
}
$table.="</thead><tbody>";
foreach ($r as $key => $value) {
	$table.="<tr>";
	foreach ($value as $c) {
		$table.="<td>$c</td>";
	}
	$table.="</tr>";
}
$table.="</tbody>";



$sql="SELECT 
ind_modulo.id as iMod, 
ind_modulo.descriptor as modulo, 
ind_consulta.id as iCon, 
ind_consulta.descriptor as consulta
FROM ind_consulta 
INNER JOIN ind_modulo ON ind_modulo.id=ind_consulta.idind_modulo
WHERE ind_modulo.id>1";
#p($P,$sql);

if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$arrayModulos[$row['iMod']]=$row['modulo'];
			$este[$row['iE']]=array(
				'iMod'=>$row['iMod'],
				'iCon'=>$row['iCon'],
				'consulta'=>$row['consulta']
			);
			$arrayConsultas[$row['iMod']][$row['iCon']]=array(
				$row['modulo'],
				$row['consulta']);
		}
	} 
	$result->close();
} 
$arrayConsultas=json_encode($arrayConsultas);
#p($P,$arrayModulos);
#p($P,$arrayConsultas);
	//[{"1":{"iE":"1","iM":"1","m":"No Definido"}},{"2":{"iE":"2","iM":"2","m":"Libertador (Caracas)"}}] 
$arr=json_encode($arr);

?>

<? include('../000_head.php'); ?>


<body>
	<?
	include("../000_navbar.php");
	?>
	<main>
		<?
		include("../000_navbarLeft.php");
		?>

		<div class="flex-shrink-0 p-3 bg-white" style="width: 85%;">
			<br>
			<? echo $panelAlerta;?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="container-fluid	scroll" style="margin-bottom: 800px;">
						<form class="" method="GET" action="">
							<div class="row g-3">
								<div class="col">
									<div class="form-group">
										<label for="modulo" class="col-md-4 control-label text-right">Modulo</label>
										<div class="col-md-8">
											<select class="form-control" id='modulo' name='modulo' onchange="PadreHijo();">
												<?
												foreach ($arrayModulos as $key => $value) {
													echo '<option value="'.$key.'">'.$value.'</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="consulta" class="col-md-4 control-label text-right">Consulta</label>
										<div class="col-md-8">
											<select class="form-control" id='consulta' name='idind_consulta' onchange="this.form.submit();">
												<option value="">Seleccione...</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<hr style="margin-top: 20px;">

							<!--<button class="btn btn-primary" type="submit">Buscar</button>-->
						</form>

						<?
						if(!$error){ 
							echo '<table id="example" class="display" style="width:100%;">'.$table.'</table>';
						} else {
							echo '<table id="tablaError" class="display" style="width:100%;">'.$tablaError.'</table>';
						}
						?>						
						<br><br><br><br><br>
						<div style="margin-bottom: 100px;"></div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>

<script type="text/javascript">



	PadreHijo();

	function PadreHijo(){
		var sModulo=$('#modulo');
		var sConsulta=$('#consulta');
		var a=JSON.parse(<?echo json_encode($arrayConsultas);?>)
		console.log(a);
		var iMod=($('#modulo option:selected').val());
		console.log(iMod);
		var objeto=a[iMod];
		console.log(objeto);
		var s=sModulo;
		sConsulta.empty();
		let text = "";
		var v;
		sConsulta.append($("<option>", {
			value: "",
			text: "Seleccione..."
		}));
		for (let x in a[iMod]) {
			console.log(x);
			var p=a[iMod][x];
			v=p[1];
			sConsulta.append($("<option>", {
				value: x,
				text: v
			}));
		}
	}

	$(document).ready(function() {
		var view='<?echo $view;?>';
		$('#example').DataTable( {
			dom: 'Bfrtip',
			scrollX: true,
			stateSave: true,
			lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 rows','10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'colvis', 'pageLength'
			],
			"pageLength":5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		} );
	} );


		$('#tablaError').DataTable( {
			dom: 'Bfrtip',
			scrollX: true,
			stateSave: true,
			"pageLength":5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		} );

</script>
