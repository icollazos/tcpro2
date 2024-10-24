<?

//inicializando
session_start();
unset($_SESSION['salida']); ##salida del generador


$P=0; //define si los pre se ven o no
include('../000_conexion.php');
$mysqli=conectar($datosConexion);

$esteArchivo=basename($_SERVER['SCRIPT_NAME']);
$esteAmbito=ambitos($esteArchivo);
if(isset($_GET['esteAmbito'])){	$esteAmbito=$_GET['esteAmbito']; }
$estaTabla='aaa_'.$esteAmbito;
$estaVista='v_'.$estaTabla;
$nombrePagina='Histórico de Gasto para '.$esteAmbito;

$misDatos=$_SESSION['fvp']['misDatos'];

$seccion="principal";

$nivelDeUsuario=$_SESSION['fvp']['nivel'];
#p($P,$nivelDeUsuario);

if($nivelDeUsuario>4){
	$disabled="disabled";
}
#p($P,$disabled);

if(isset($_GET['view'])){
	$view=$_GET['view'];
	$_SESSION['fvp']['view']=$view;
}
$_SESSION['fvp']['view']=$estaVista;
$view=$_SESSION['fvp']['view'];

$idUsuario=$_SESSION['fvp']['idUsuario'];

$clausulaMisDatos='';
$sql="SELECT column_name
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '$estaTabla';";
#p($P,$sql);
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$listaCampos[]=$row['column_name'];
			if($misDatos=='mis'){
				if(substr($row['column_name'], 0,10)=='id_usuario'){
					$clausulaMisDatos =" AND ".$row['column_name']." = $idUsuario ";
				}				
				if($view=='adm_usuario'){
					$clausulaMisDatos =" AND id = $idUsuario ";
				}				
			}
		}
		$result->close();
	}
} 

$_SESSION['crud']['corrida']=0;
unset($_SESSION['fvp']['crud']);
unset($_SESSION['fvp']['idRegistro']);

in_array($view, $_SESSION['fvp']['tablasSeguras']) ? $tablaSegura=TRUE : $tablaSegura=FALSE ;


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

$panelAlerta='';
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: ../gen_login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

$sql="SELECT descriptor, alias, rango FROM adm_views ORDER BY alias ASC";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			if($row['rango']<3){
				$_SESSION['fvp']['uniViews'][$row['descriptor']]=$row['alias'];
			}
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 
//p($P,$_SESSION['fvp']);

$sql = "SHOW COLUMNS FROM $estaVista";
//j($sql);
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if($c!='id' AND substr($c, 0,2)=='id' ){
		//$camposExternos[]='id'.trim(substr($c, 5,1000)).'_'.$esteAmbito;
		$camposExternos[]=$c;
	} else {
		$camposInternos[]=$c;
	}
}
/*
p($P,$camposInternos);
p($P,$camposExternos);
*/

$sql ="SELECT * FROM $estaVista WHERE id<>1 $clausulaMisDatos ORDER BY id DESC";
#echo $sql;
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$sqlRows++;
			$array2Excel[]=implode("\t", $row);
			foreach ($row as $key => $value) {
				if($key=='id' OR ( strlen($key)>2 AND substr($key, 0,2)!='id') ){
					$tabla[$row['id']][$key]=$value;
					$titulos[$key]=$key;
					foreach ($camposExternos as $ce) {
						$arrayGenerador[$ce][$row[$ce]]=$row['descriptor_'.substr($ce, 3,1000)];
					}
				}
			}
		}
	} else {
		$panelAlerta=panel("warning",'Sin registros','La consulta no arrojó resultados');
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

$string2Excel=implode("\n", $array2Excel);

?>


<html>
<? include('../000_head.php');?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<? 
			echo $panelAlerta;
			?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">
					<div class="row" style="margin-top: 24px; margin-bottom: 24px;">
						<div class="col">
							<div class="row">
								<label for="exampleFormControlTextarea1" class="form-label">Ámbito</label>
								<form action="" method="GET">
									<select class="form-select argumento-select" id="esteAmbito" name="esteAmbito" onchange="this.form.submit();">
										<option value="<?echo $esteAmbito?>"><?echo $esteAmbito?></option>
										<?	
										$opcionesAmbito=opcionesAmbito();
										foreach ($opcionesAmbito as $key => $value) { 
											echo '<option value="'.$key.'">'.$value.'</option>'; 
										}
										?>
									</select>
								</form>
							</div>
							<hr>
							<div class="row">
								<label for="exampleFormControlTextarea1" class="form-label">Tipo de búsqueda</label>
								<select class="form-select argumento-select" aria-label="Default select example" id="tipoBusqueda" onblur="creaMarco();">
									<option value="O">Seleccione...</option>
									<option value="O">Extensa</option>
									<option value="A">Estricta</option>
								</select>
							</div>
							<hr>
							<div class="row">
								<button class="btn btn-sm btn-block btn-info" id="boton-tipo-grafico">Cambiar tipo gráfico</button>
							</div>
							<hr>
							<div class="row">
								<textarea hidden type="" id="campo_texto" value="<? echo ($string2Excel); ?>" style="width:0px; height: 0px; border-width: 0px;"><? echo ($string2Excel); ?></textarea>
								<div class="col">
									<div class="d-grid gap-2">
										<div class="row">
											<div class="col">
												<button id="reiniciar" class="btn btn-warning btn-block btn-sm">Reiniciar Filtros</button>
											</div>
											<div class="col">
												<button onclick="copiar()" style="" class="btn btn-info btn-block btn-sm">Copiar para Excel</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="row">

								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Año Inicial</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="anoInicio" onblur="creaMarco();">
										<option value="2019">Seleccione...</option>
										<? for ($i=2019; $i < 2026; $i++) { 
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Mes Inicial</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="mesInicio" onblur="creaMarco();">
										<option value="01/01">Seleccione...</option>
										<option value="01/01">Enero</option>
										<option value="02/01">Febrero</option>
										<option value="03/01">Marzo</option>
										<option value="04/01">Abril</option>
										<option value="05/01">Mayo</option>
										<option value="06/01">Junio</option>
										<option value="07/01">Julio</option>
										<option value="08/01">Agosto</option>
										<option value="09/01">Septiembre</option>
										<option value="10/01">Octubre</option>
										<option value="11/01">Noviembre</option>
										<option value="12/01">Diciembre</option>
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Año Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="anoFinal" onblur="creaMarco();">
										<option value="2026">Seleccione...</option>
										<? for ($i=2019; $i < 2026; $i++) { 
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
									</select>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Mes Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="mesFinal" onblur="creaMarco();">
										<option value="12/31">Seleccione...</option>
										<option value="01/31">Enero</option>
										<option value="02/28">Febrero</option>
										<option value="03/31">Marzo</option>
										<option value="04/30">Abril</option>
										<option value="05/31">Mayo</option>
										<option value="06/30">Junio</option>
										<option value="07/31">Julio</option>
										<option value="08/31">Agosto</option>
										<option value="09/30">Septiembre</option>
										<option value="10/31">Octubre</option>
										<option value="11/30">Noviembre</option>
										<option value="12/31">Diciembre</option>
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col">
									<? 
									$adt=arrayDesplegableTotales();
									echo desplegableTotales($idCampo,$titulo,$adt[$esteAmbito]);
									?>
								</div>
							</div>
						</div>

						<div class="col col-sm-7">
							<div class="row">
								<? 
								$arrayDesplegable=arrayDesplegable();
								foreach ($arrayDesplegable[$esteAmbito] as $key => $titulo) {
									$idCampo="id".$key;
									echo desplegable($key,$titulo,$arrayGenerador[$key]);
								}
								?>
							</div>
						</div>


					</div>




				</div>
				<div class="row">
					<hr>
					<div class="container-fluid	scroll" style="margin-bottom: 0px;" id="cajaMarco"></div>
				</div>
			</div>
		</div>
		<form action="crudCU.php" method="POST" id="formCU">
			<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
			<input type="hidden" name="tabla" value="<?echo $estaTabla;?>">
		</form>
	</div>
</main>
</body>
<?


function desplegableTotales($id,$titulo,$array){
	asort($array);
	$Z='<label class="form-label">Campo a totalizar en: <br><strong>'.$titulo.'</strong></label><select class="form-select alto argumento-select" id="campoTotalizacion" onblur="creaMarco();">';
	foreach ($array as $k=>$v) {
		$Z.= '<option value="'.$k.'">'.$v.'</option>';
	}
	$Z.='</select><hr>';
	return $Z;	
}

function desplegable($id,$titulo,$array){
	asort($array);
	$Z='<div class="col col-sm-3"><label class="form-label">'.$titulo.'</label><select multiple class="form-select alto argumento-select campos" id="'.$id.'" onblur="creaMarco();">';
	foreach ($array as $k=>$v) {
		$Z.= '<option value="'.$k.'">'.$v.'</option>';
	}
	$Z.='</select><hr></div>';
	return $Z;	
}


?>

<script>
	function copiar() {
		var texto = document.getElementById("campo_texto").value;
		navigator.clipboard.writeText(texto);
	}
</script>

</html>
<?
#include("000_navbarBottom.php");
?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


<script type="text/javascript">

	$(document).ready(function() {
		l("Iniciando");
		creaMarco();
	});

	$("#reiniciar").click(function() {
		$(".campos").find('option:selected').prop('selected', false);
		creaMarco();
	});




	function tablita(titulo,array,aliasTitulo){
		var tablita='<div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6"><div class="card card-info" style="margin-bottom:14px;"><div class="card-header">'+aliasTitulo+'</div><div class="card-body"><figure class="highcharts-figure"><div id="grafico_'+titulo+'"></div></figure>';
	/*
	tablita+='<table id="dt_'+titulo+'" class="table table-bordered display" style="width:100%;">';
	tablita+='<tbody>';
	var titulos={};
	var idTitulo=0;
	$.each(array, function(iterador){
		tablita += '<tr>';
		tablita += '<td>'+iterador+'</td>';
		tablita += '<td>'+array[iterador]+'</td>';
		tablita+='</tr>';	
	});
	tablita+='</tbody></table>';
	*/
	tablita+='</div></div></div>';	
	return tablita;
}

function creaMarco(){

	l("creando marco");
	var id;
	var valor;
	var argumentos={};
	var inputs = $(".argumento-input");
	inputs.each(function() {
		var id = $(this).attr("id");
		var valor = $(this).val();
		argumentos[id] = valor;
	});
	var selects = $(".argumento-select");
	selects.each(function() {
		var id = $(this).attr("id");
		var valor = $(this).val();
		argumentos[id] = valor;
	});
	argumentos['campoTotalizacion'] = $("#campoTotalizacion").val();
	l("argumentos");
	l(argumentos);
	anoInicio=$("#anoInicio").val();
	mesInicio=$("#mesInicio").val();
	anoFinal=$("#anoFinal").val();
	mesFinal=$("#mesFinal").val();
	$.post("filtrado_lineal_totales_select.php", {
		argumentos: argumentos
	})
	.done(function(response){
		l("DONE");
		var alias=<?echo $aliasJson;?>;
		//l(alias);
		var counter = 0;
		var j=JSON.parse(response);
		l(j);
		l("Iterando");
		var HTML='<div class="row">';

		$.each(j, function(campo){
			estaTabla=j[campo];
			//l(estaTabla);
			titulo=estaTabla['campo'];
			data=estaTabla['data'];
			aliasTitulo=titulo;
			const claves = Object.keys(alias);
			if (claves.includes(titulo)) { 
				aliasTitulo=alias[titulo];	
			}
			HTML+=tablita(titulo,data,aliasTitulo);
		});			

		HTML+="<div>";
		var caja=$('#cajaMarco');
		caja.empty();
		caja.append(HTML);
		dt("dt_objetoOtrosGastos");

		$.each(j, function(campo){
			var actual=j[campo];
			graficar(actual);
		});			
	})
	.fail(function() {
		l("Error en la carga de curr");
	});

}


$("#actualizar").click(function() {
	creaMarco();
});



</script>


<script>

	function graficar(actual){
		l(actual);
		var titulo=actual.campo;
		var contenedor='grafico_'+titulo;
		var valores=actual.valores;
		var categorias=actual.categorias;
		var s=actual.valores;
		var miSerie=Array.from(Object.values(s));

		Highcharts.chart(contenedor, {
			title: {
				text: '',
				align: 'left'
			},

			subtitle: {
				text: '',
				align: 'left'
			},

			yAxis: {
				title: {
					text: 'Cantidad'
				}
			},

			xAxis: {
				title: {
					text: "Período seleccionado",
				},
				categories: categorias,
			},

			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
			},

			plotOptions: {
				area: {
					stacking: 'normal',
					lineColor: '#666666',
					lineWidth: 1,
					marker: {
						lineWidth: 1,
						lineColor: '#666666'
					}
				},
				column: {
					stacking: 'normal',
					lineColor: '#666666',
					lineWidth: 1,
					marker: {
						lineWidth: 1,
						lineColor: '#666666'
					}
				}
			},

			series: miSerie,

			responsive: {
				rules: [{
					condition: {
						maxWidth: 500
					},
					chartOptions: {
						legend: {
							layout: 'horizontal',
							align: 'center',
							verticalAlign: 'bottom'
						}
					}
				}]
			}

		});

	}

	function dt(titulo){
	//new DataTable('#'+titulo);
}


$(document).ready(function() {

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

function l(variable){ console.log(variable); }


function cambiarTipoGrafico(tipo) {
// Obtener todos los gráficos Highcharts
var charts = Highcharts.charts;
// Recorrer los gráficos y actualizar el tipo
for (var i = 0; i < charts.length; i++) {
	charts[i].update({
		chart: {
			type: tipo
		}
	});
}
}

var botonTipoGrafico = document.getElementById('boton-tipo-grafico');
botonTipoGrafico.onclick = function() {
// Obtener el tipo de gráfico actual
var charts = Highcharts.charts;
var tipoActual = charts[0].options.chart.type;

// Seleccionar el siguiente tipo de gráfico
var siguienteTipo;
switch (tipoActual) {
	case 'column':
	siguienteTipo = 'line';
	break;
	case 'line':
	siguienteTipo = 'area';
	break;
	case 'area':
	siguienteTipo = 'column';
	break;
}

// Cambiar el tipo de gráfico de todos los gráficos
cambiarTipoGrafico(siguienteTipo);
};

</script>