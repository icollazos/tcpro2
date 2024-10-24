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
$nombrePagina='Consulta general';
$cliente=$_SESSION['cliente'];
//p($P,$cliente);

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
$resultado = $mysqli->query($sql);
$camposExternos2=array();
// Mostrar nombres de los campos
#En esta linea se genera un error debido a que en 000_configurador en el arrau de ambitos se llama a una tabla que no existe
while ($campoQ = $resultado->fetch_assoc()) {
	$c=$campoQ['Field'];
	if($c!='id' AND substr($c, 0,2)=='id' ){
		$camposExternos[]=trim(substr($c, 0,1000));
	} else {
		$camposInternos[]=$c;
	}
}

$sql ="SELECT * FROM $estaVista WHERE id<>1 $clausulaMisDatos ORDER BY id DESC";
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$q=$row;
			$sqlRows++;
			$row2=array();
			foreach ($row as $key => $value) { $row2[]=strip_tags($value); }
			$array2Excel[]=implode("\t", $row2);
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


//$arrayDesplegable=arrayDesplegable();


?>


<html>
<? include('../000_head.php');?>
<script src="frn_funciones.js"></script> <!-- funciones de selects indispensables-->
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
								<div class="col col-2">
									<div class="row">
										<div class="col">
											<label for="exampleFormControlTextarea1" class="form-label">Proyecto</label>
											<select class="form-select argumento-select" aria-label="Default select example" id="proyecto" onchange="selSeguimiento();">
											</select>
											<label for="exampleFormControlTextarea1" class="form-label">Seguimiento</label>
											<select class="form-select argumento-select" aria-label="Default select example" id="seguimiento" onchange="creaSalida();">
											</select>
										</div>
									</div>
								</div>
								<div class="col col-2">
									<label for="exampleFormControlTextarea1" class="form-label">Ámbito</label>
									<select class="form-select argumento-select" id="esteAmbito" name="esteAmbito" onchange="cargaSelects();">
										<option value="<?echo $esteAmbito?>"><?echo $esteAmbito?></option>
										<?	
										$opcionesAmbito=opcionesAmbitoConsultaPrincipal();
										foreach ($opcionesAmbito as $key => $value) { 
											echo '<option value="'.$key.'">'.$value.'</option>'; 
										}
										?>
									</select>
									<label for="exampleFormControlTextarea1" class="form-label">Tipo de búsqueda</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="tipoBusqueda" onchange="creaSalida();">
										<option value="O">Seleccione...</option>
										<option value="O">Extensa</option>
										<option value="A">Estricta</option>
									</select>
								</div>
								<div class="col col-2">
									<label for="exampleFormControlTextarea1" class="form-label">Buscar por palabra</label>
									<input type="text" class="form-control argumento-input" id="keywords" placeholder="Escriba palabras separadas por comas" onchange="creaSalida();">
									<label for="exampleFormControlTextarea1" class="form-label">Excepto</label>
									<input type="text" class="form-control argumento-input" id="excepto" placeholder="Escriba palabras separadas por comas" onchange="creaSalida();">
								</div>
								<div class="col col-6">
									<div class="row"  id="rowFechas">
									</div>
									<div class="row" id="contenedorSelects">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<hr>
						<table id="miTabla" class="display">
							<thead id="th">
								<tr><th></th></tr>
							</thead>
							<tbody id="tb">
								<tr><th></th></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<textarea type="hidden" id="html2Excel" style="height: 150px; width: 500px; display: none;" value=""></textarea>
			<form action="crudCU.php" method="POST" id="formCU">
				<input type="hidden" name="from" value="<?echo $esteArchivo;?>" >
				<input type="hidden" name="table" id="tabla" value="">
			</form>
		</div>
	</main>
</body>
</html>

<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		l("Iniciando");
		selProyecto();
		cargaSelects();
	});
	function llenarFechas(anos) {

		l("CREANDO FECHAS")
		$('#rowFechas').empty();

		const divAnoInicial = $('<div>', { class: 'col-3' });
		const divMesInicial = $('<div>', { class: 'col-3' });
		const divAnoFinal = $('<div>', { class: 'col-3' });
		const divMesFinal = $('<div>', { class: 'col-3' });

		const selectAnoInicial = $('<select>', { id: 'anoInicio', class:'form-select alto argumento-select', onchange: 'creaSalida()' });
		$.each(anos, function(index, ano) {
			selectAnoInicial.append($('<option>', { value: ano, text: ano }));
		});
		divAnoInicial.append($('<label>', { for: 'anoInicio' }).text('Año Inicial')).append(selectAnoInicial);

		const selectMesInicial = $('<select>', { id: 'mesInicio', class:'form-select alto argumento-select', onchange: 'creaSalida()' });
		for (let mes = 1; mes <= 12; mes++) {
			if(mes<10){mes='0'+mes}
				selectMesInicial.append($('<option>', { value: mes, text: mes }));
		}
		divMesInicial.append($('<label>', { for: 'mesInicio' }).text('Mes Inicial')).append(selectMesInicial);

		const selectAnoFinal = $('<select>', { id: 'anoFinal', class:'form-select alto argumento-select', onchange: 'creaSalida()' });

		for (let i = anos.length - 1; i >= 0; i--) {
			selectAnoFinal.append($('<option>', { value: anos[i], text: anos[i] }));
		}
		divAnoFinal.append($('<label>', { for: 'anoFinal' }).text('Año Final')).append(selectAnoFinal);

		const selectMesFinal = $('<select>', { id: 'mesFinal', class:'form-select alto argumento-select', onchange: 'creaSalida()' });
		for (let mes = 12; mes >= 1; mes--) {
			if(mes<10){mes='0'+mes}
				selectMesFinal.append($('<option>', { value: mes, text: mes }));
		}
		divMesFinal.append($('<label>', { for: 'mesFinal' }).text('Mes Final')).append(selectMesFinal);

		$('#rowFechas').append(divAnoInicial, divMesInicial, divAnoFinal, divMesFinal);
	}
	function creaSelectFiltro(items) {
		$('#contenedorSelects').empty();
		$.each(items, function(index, item) {
			const div = $('<div>', { class: 'col-3' });
			const label = $('<label class="form-label">', { for: item.id }).text(item.alias);
			const select = $('<select>', { id: item.id, class: 'form-select alto argumento-select campos', onchange: 'creaSalida()' });
			const optionElement = $('<option>', {
				value: 0,
				text: "TODOS"
			});
			select.append(optionElement);
			$.each(item.options, function(i, option) {
				const optionElement = $('<option>', {
					value: option.value,
					text: option.text
				});
				select.append(optionElement);
			});
			div.append(label).append(select);
			$('#contenedorSelects').append(div);
		});
	}
	function copiar() {
		var texto = $("#html2Excel").val();
		navigator.clipboard.writeText(texto);
	}
	function limpiar() {
		$(".campos").find('option:selected').prop('selected', false);
		$(".argumento-input").val('');
		creaSalida();
	}
	function cargaSelects(){
		l("MIRA CAMPOS");
		var argumentos={};
		var selects = $(".argumento-select");

		selects.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		argumentos['funcionLlamada']="cargaSelects";
		argumentos['cliente']="<?echo $_SESSION['cliente'];?>";
		l(argumentos);
		postData('filtrado_consulta_funciones.php', { 
			argumentos:argumentos
		})
		.then(data => {
			l("Mira Campos Data")
			l(data)
			creaSelectFiltro(data.selects);
			if(data.anos!==null){
				llenarFechas(data.anos);
			} else {
				$("#rowFechas").empty();
			}
			creaSalida();
		});
	}
	function creaSalida(){
		l("Creando Marco");
		var id;
		var valor;
		var argumentos={};
		var selects = $(".argumento-select");
		selects.each(function() {
			var id = $(this).attr("id");
			var valor = $(this).val();
			argumentos[id] = valor;
		});
		argumentos['keywords']=$("#keywords").val();
		argumentos['excepto']=$("#excepto").val();
		argumentos['funcionLlamada']="elegirAmbito";
		crudCU='aaa_'+argumentos['esteAmbito'];
		$("#tabla").val(crudCU);
		l(argumentos);
		postData('filtrado_consulta_funciones.php', { 
			argumentos:argumentos
		})
		.then(data => {
			l("Recibiendo Datos Tabla")
			//l(data)
			llenarDataTable(data);
			llenarHtml2Excel(data);
		});
	}
	function llenarHtml2Excel(data){
		$("#html2Excel").val(data.html2Excel);
	}
	function llenarDataTable(data) {
		if ($.fn.dataTable.isDataTable('#miTabla')) {
			$('#miTabla').DataTable().clear().destroy(); // Destruir la tabla existente
		}
		$('#miTabla thead tr').empty();
		$.each(data.titulos, function(index, titulo) {
			$('#miTabla thead tr').append('<th>' + titulo + '</th>');
		});
		var tbody = $('#miTabla tbody');
		tbody.empty();
		$.each(data.registros, function(index, registro) {
			var fila = '<tr>';
			$.each(data.titulos, function(i, titulo) {
				var r=registro[titulo];
				if (typeof r === 'string'){
					r=r.substring(0,50);
				}
            fila += '<td>' + r + '</td>'; // Acceder a los valores usando los títulos
        });
			fila += '</tr>';
			tbody.append(fila);
		});
		$('#miTabla').DataTable({
			dom: 'Bfrtip',
			scrollX: true,
			stateSave: true,
			lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 rows','10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			buttons: [
			'copy', 
			'csv', 
			'excel', 
			'pdf', 
			'print', 
			'colvis', 
			'pageLength',
			/*
			{	text: 'Agregar Registro',
				className: 'btn btn-success btn-sm',
				action: function ( e, dt, node, config ) {
					$("#formCU").submit();
				}
			},
			*/
			{
				text: 'Copia toda la data',
				className: 'btn btn-success btn-sm',
				action: function ( e, dt, node, config ) {
					copiar();
				}
			},
			{
				text: 'Reiniciar filtros',
				className: 'btn btn-warning btn-sm',
				action: function ( e, dt, node, config ) {
					limpiar();
				}
			}

			],
			"pageLength":5,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		});
	}
	function l(variable){ console.log(variable); }
</script>

