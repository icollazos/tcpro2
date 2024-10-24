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
$nombrePagina='Consulta general de: '.$esteAmbito;

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

$hayFecha=0;
if(in_array("fecha", $camposInternos)){
		$hayFecha=1; 
	}
/*
p($P,$camposInternos);
p($P,$camposExternos);
die();
*/

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


$arrayDesplegable=arrayDesplegable();


?>


<html>
<? include('../000_head.php');?>
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
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Ámbito</label>
									<form action="" method="GET">
										<select class="form-select argumento-select" id="esteAmbito" name="esteAmbito" onchange="this.form.submit();">
											<option value="<?echo $esteAmbito?>"><?echo $esteAmbito?></option>
											<?	
											$opcionesAmbito=opcionesAmbitoConsultaPrincipal();
											foreach ($opcionesAmbito as $key => $value) { 
												echo '<option value="'.$key.'">'.$value.'</option>'; 
											}
											?>
										</select>
									</form>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Tipo de búsqueda</label>
									<select class="form-select argumento-select" aria-label="Default select example" id="tipoBusqueda" onblur="creaSalida();">
										<option value="O">Seleccione...</option>
										<option value="O">Extensa</option>
										<option value="A">Estricta</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Buscar por palabra</label>
									<input type="text" class="form-control argumento-input" id="keywords" placeholder="Escriba palabras separadas por comas" onblur="creaSalida();">
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Excepto</label>
									<input type="text" class="form-control argumento-input" id="excepto" placeholder="Escriba palabras separadas por comas" onblur="creaSalida();">
								</div>
							</div>
							<textarea type="hidden" id="campo_texto" style="height: 0px; width: 0px; border-width: 0px;"> value="<? echo ($string2Excel); ?>"><? echo ($string2Excel); ?></textarea>
							<? if ($hayFecha) { ?>
							<div class="row">
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Año Inicial</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="anoInicio" onblur="creaSalida();">
										<option value="2019">Seleccione...</option>
										<? for ($i=2023; $i < 2030; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
									</select>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Mes Inicial</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="mesInicio" onblur="creaSalida();">
										<option value="01/01">Seleccione...</option><option value="01/01">Enero</option><option value="02/01">Febrero</option><option value="03/01">Marzo</option><option value="04/01">Abril</option><option value="05/01">Mayo</option><option value="06/01">Junio</option><option value="07/01">Julio</option><option value="08/01">Agosto</option><option value="09/01">Septiembre</option><option value="10/01">Octubre</option><option value="11/01">Noviembre</option><option value="12/01">Diciembre</option>
									</select>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Año Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="anoFinal" onblur="creaSalida();">
										<option value="2026">Seleccione...</option>
										<? for ($i=2023; $i < 2030; $i++) { echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
									</select>
								</div>
								<div class="col">
									<label for="exampleFormControlTextarea1" class="form-label">Mes Final</label>
									<select class="form-select alto argumento-select" aria-label="Default select example" id="mesFinal" onblur="creaSalida();">
										<option value="12/31">Seleccione...</option><option value="01/31">Enero</option><option value="02/28">Febrero</option><option value="03/31">Marzo</option><option value="04/30">Abril</option><option value="05/31">Mayo</option><option value="06/30">Junio</option><option value="07/31">Julio</option><option value="08/31">Agosto</option><option value="09/30">Septiembre</option><option value="10/31">Octubre</option><option value="11/30">Noviembre</option><option value="12/31">Diciembre</option>
									</select>
								</div>							
							</div>
						<? } ?>
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
					<div class="row">
						<hr>
						<div class="container-fluid	scroll" style="margin-bottom: 0px;" id="cajaTabla"></div>
						<div class="container-fluid	scroll" style="margin-bottom: 0px;" id="cajaSql_____________________"></div>
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
</html>

<div class="col">
	<div class="row">


	</div>
</div>

<?
function desplegable($id,$titulo,$array){
	asort($array);
	$Z='<div class="col col-sm-3"><label class="form-label">'.$titulo.'</label><select multiple class="form-select alto argumento-select campos" id="'.$id.'" onchange="creaSalida()"; style="height:90px;">';
	foreach ($array as $k=>$v) {
		$Z.= '<option value="'.$k.'">'.$v.'</option>';
	}
	$Z.='</select></div>';
	return $Z;	
}
?>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">

	function copiar() {
		var texto = document.getElementById("campo_texto").value;
		navigator.clipboard.writeText(texto);
	}
	function limpiar() {
		$(".campos").find('option:selected').prop('selected', false);
		creaSalida();
	}
	$(document).ready(function() {
		l("Iniciando");
		creaSalida();
	});
	$("#actualizar").click(function() {
		creaSalida();
	});

	function creaSalida(){
		l("Creando Marco");
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
		l("argumentos");
		l(argumentos);

		$.post("filtrado_consulta_select.php", {
			argumentos: argumentos
		})
		.done(function(response){
			l("DONE");
			l(response);
			var counter = 0;
			var j=JSON.parse(response);
			l(j);
			var cajaSql=$('#cajaSql');
			var caja=$('#cajaTabla');
			caja.empty();
			cajaSql.empty();
			if(j['control']!=0){
				l("no hay resultados")
			var retorno=j.data;
			var sql=j.sql;
			var rr=retorno[0].return;
			l(rr);
			var HTML='<table id="example" class="display" style="width:100%;"><thead><tr>';
			var alias=<?echo $aliasJson;?>;
			l("---------------------------------------------------------------");
			l(alias);
			l("---------------------------------------------------------------");
			/*
			*/
			var titulos={};
			var idTitulo=0;
			$.each(rr, function(iterador){
				titulos[idTitulo]=iterador;
				const claves = Object.keys(alias);
				if (claves.includes(iterador)) { 
					ttt=alias[iterador];	
				} else {
					ttt=iterador;
				}
				idTitulo++;
				var curr = rr[iterador];
				if(iterador!='fechaHora'){
					HTML += '<th>'+ttt+'</th>';
				}
			});
			HTML+='<th>Ver</th>';
			HTML+='<th>Borrar</th>';
			HTML+='<th>Editar</th>';
			HTML+='<th>Documentos</th>';
			HTML+='</tr></thead><tbody>';
			$.each(retorno, function(counter){
				var curr = retorno[counter];
				HTML +='<tr>';
				$.each(curr.return, function(iterador){
					var curr2 = curr[iterador];
					if(iterador!='fechaHora'){
						HTML += '<td>' +  curr2.slice(0,30) + '</td>';
					}
				});
				HTML+='<td>'+curr.btn_ver+'</td>';
				HTML+='<td>'+curr.btn_eliminar+'</td>';
				HTML+='<td>'+curr.btn_editar+'</td>';
				HTML+='<td>'+curr.btn_documentos+'</td>';
				HTML+='</tr>';               
			});
			HTML += '</tbody></table>';
			caja.append(HTML);
			cajaSql.append(sql);
			creaDT(titulos);
		} else {
			l("no hay tabla")
			var HTML="";
			cajaSql.empty();
			cajaSql.append(HTML);
		}
		})
		.fail(function() {
			l("Error en la carga de curr");
		});
	}
	function creaDT(titulos) {
		l('ttttttttttttttttttttttttttttttttttttttttttttttt');
		l(titulos);
		var c=[];

		const titul=Object.values(titulos);
		for(const titulo of titul){
			if(titulo!='fechaHora'){
				c.push({ data:titulo});
			}
		}
		c.push({ data:"ver"});
		c.push({ data:"eliminar"});
		c.push({ data:"editar"});
		c.push({ data:"documentos"});


		$('#example').DataTable({
			scrollX: true,
			fixedHeader: true,
			processing: true,
			bFilter: true,

			columns:c,

			dom: 'Bfrtip',
			stateSave: true,
			lengthMenu: [
			[ 5, 10, 25, 50, -1 ],
			[ '5 filas','10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
			],
			buttons: [
			'colvis','pageLength'
			],
			"pageLength":100,
			language: {
				url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
			},
		});
		//$('#example').draw();
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
		$(document).on( 'init.dt', function ( e, settings ) {
			var api = new $.fn.dataTable.Api( settings );
			console.log( 'New DataTable created:', api.table().node() );
			var e=$("#example_filter");
			var b1 = $("<button>Agregar Registro</button>");
			b1.attr("type", "submit");
			b1.attr("id", "b1");
			b1.attr("class", "btn btn-success btn-sm  btn-datatable");
			e.before(b1);
			b1.click(function() {
				$("#formCU").submit();
			});

			var b2 = $("<button>Copia toda la data</button>");
			b2.attr("type", "submit");
			b2.attr("id", "b2");
			b2.attr("class", "btn btn-success btn-sm btn-datatable");
			b2.attr("margin-right", "15px;");
			e.before(b2);
			b2.click(function() {
				copiar();
			});

			var b3 = $("<button>Reiniciar filtros</button>");
			b3.attr("type", "submit");
			b3.attr("id", "b3");
			b3.attr("class", "btn btn-warning btn-sm btn-datatable");
			b3.attr("margin-right", "15px;");
			e.before(b3);
			b3.click(function() {
				limpiar();
			});

		} );


	} );
</script>


<script>


	function l(variable){ console.log(variable); }


</script>

