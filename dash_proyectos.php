<?

########################################################################################################## Inicializando
session_start();

if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

include('00_conexion.php');
include('graficas_funciones.php');
$mysqli=conectar($datosConexion);

if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
}
$idUsuario=$_SESSION['fvp']['idUsuario'];
$aliasCampos=$_SESSION['fvp']['aliasCampos'];
$seccion="principal";
$nombrePagina="Gráficas";
$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$panelAlerta=array('', panel("warning","No se encontraron registros","La consulta no devuelve resultados"));
$tipoGrafico="TORTA";
$arrayAgrupamiento=array('diaria','semanal','mensual','anual');
//p($P,$arrayAgrupamiento);

//cargaAliasTablas($datosConexion);

######################################################################################################### Cargando parámetros

if(!isset($_SESSION['fvp']['view'])){
	$_SESSION['fvp']['view']="persona";
}

if(isset($_POST)){
	if(isset($_POST['view'])){
		unset($_SESSION['fvp']['gr']['campo']);
		unset($_SESSION['fvp']['gr']['ejex']);
		unset($_SESSION['fvp']['gr']['campoFecha']);
	}
	if(isset($_POST['limpiarCheckbox'])){
		unset($_SESSION['fvp']['gr']['checkbox']);
		$_SESSION['fvp']['gr']['checkbox']=array();
	}
	foreach ($_POST as $key => $value) {
		$_SESSION['fvp']['gr'][$key]=$value;
	}
}

$parametros=$_SESSION['fvp']['gr'];

#p($P,$parametros); 

################################################### Inicializa parametros de gráficos, para que desde el inicio funcione
$arrayParametros=arrayParametros();
foreach ($arrayParametros as $key => $value) {
	if(!isset($parametros[$key])){
		$parametros[$key]=$value;
	}
}

#p($P,$parametros);
$tipoGrafico=$parametros['tipoGrafico'];
$view=$parametros['view'];
$campo=$parametros['campo'];
$ejex=$parametros['ejex'];

$filtro=$parametros['filtro'];
$checkbox=$parametros['checkbox'];

$fecha1=$parametros['fecha1'];
$fecha2=$parametros['fecha2'];
$_SESSION['fvp']['gr']['fecha1']=$fecha1;
$_SESSION['fvp']['gr']['fecha2']=$fecha2;
$campoFecha=$parametros['campoFecha'];
$agrupamientoFecha=$parametros['agrupamientoFecha'];

if(in_array($tipoGrafico, array('line', 'area', 'curvas', 'lineas', 'area', 'curvas'))){
	$parametros['fechasRellenas']=rellenarFechas($agrupamientoFecha,$fecha1,$fecha2);
} else {
	unset($parametros['fechasRellenas']);
}




$data=consultaSimple($datosConexion,$parametros);
$grafico1=graficar($data,'pie');




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
							<? echo selectTabla ($datosConexion,$parametros); ?>
							<? echo selectCampos ($datosConexion,$view,'campo','Seleccione el campo principal','general');?>
							<? echo selectCampos ($datosConexion,$view,'filtro','Seleccione un filtro','general');?>
							<? echo checkbox ($datosConexion,$view,$checkbox,'filtro'); ?>
							<hr>
							<? 
							if(detectaFechas($datosConexion,$view)>0){
								echo selectCampos ($datosConexion,$view,'campoFecha','Seleccione el campo de Fechas','fecha');
								echo label('Indique el rango de fechas');
								echo inputFecha ('fecha1','Fecha de Inicio');
								echo inputFecha ('fecha2','Fecha Final');								
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-body">
							<div id="container" class="chart" style="width:100%; margin-top: 50px; margin-bottom: 50px; "></div>
						</div>
						<div class="panel-body">
							<? 
							#echo p($P,$_SESSION['fvp']['sql']);
							#echo p($P,$data);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>    		
</div>
</div>
</body>
</html>


<script type="text/javascript">
	$(document).ready(function() {
		$('#example').DataTable({
			"scrollX": true,
			"order": [[ 0, "desc" ]]
		});
	} );
</script>

<?
echo $grafico1 ;
?>


<script> 
	Highcharts.chart('container2', {
		chart: { type: 'bar' }, 
		title: { text: '' }, tooltip: { enabled: false }, plotOptions: { area: { stacking: 'normal', lineColor: '#666666', lineWidth: 1, marker: { lineWidth: 1, lineColor: '#666666' } } },yAxis: { title: { text: 'Cantidad' } },xAxis: { categories: ['No Definido','Sí','No'] },series: [
		{name: 'No Definido' ,data:[2,0,1]},
		{name: 'Distrito Capital' ,data:[2,0,1]},
		{name: 'Amazonas' ,data:[4,6,0]}]});</script><script>const myChart = new Chart(document.getElementById('myChart'),config);</script>

</script>
<script>const myChart = new Chart(document.getElementById('myChart'),config);</script>

<script> 
	Highcharts.chart('container2', { 
		chart: { type: 'bar' },
    title: { text: 'Stacked bar chart' },
    xAxis: { categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas'] },
    yAxis: { min: 0, title: {  text: 'Total fruit consumption' } },
    legend: { reversed: true },
    plotOptions: { series: { stacking: 'normal' } },
    series: 
    [
    { name: 'John', data: [5, 3, 4, 7, 2] }, 
    { name: 'Jane', data: [2, 2, 3, 2, 1] }, 
    { name: 'Joe', data: [3, 4, 4, 2, 5] }
    ]
});
</script>
<script>const myChart = new Chart(document.getElementById('myChart'),config);</script>
