<?
session_start();

include('../000_conexion.php');

$P=1;

$post=$_POST;
//p($P,$post);
$anos=explode(",", "2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030");
$meses=explode(",","01,02,03,04,05,06,07,08,09,10,11,12");
$dias=explode(",","01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31");
$a0=$post['a0'];
$a1=$post['a1'];
$m0=$post['m0'];
$m1=$post['m1'];
$d0=$post['d0'];
$d1=$post['d1'];
$fechaInicio=$anos[$a0].'/'.$meses[$m0].'/'.$dias[$d0];
$fechaFinal=$anos[$a1].'/'.$meses[$m1].'/'.$dias[$d1];
$clausulaFecha = "AND fecha >= '$fechaInicio' AND fecha <= '$fechaFinal'";
//p($P,$clausulaFecha);


if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: login.php");
} else {
	$uniUsuario=$_SESSION['fvp']['uniUsuario'];
}

$mysqli=conectar($datosConexion);
$nombrePagina="Monitor de Pedidos";
if(!isset($_SESSION['fvp']['idUsuario'])){
	header("Location: ../gen_login.php");
}


?>

<? include('../000_head.php'); ?>

<body>
	<? 
	$_SESSION['fvp']['fechaInicioSQL']=$fechaInicioSQL;
	$_SESSION['fvp']['fechaFinalSQL']=$fechaFinalSQL;
	$tablaPrincipal=tablaPrincipal($mysqli,$fechaInicioSQL,$fechaFinalSQL);
	$generador[0]['id']="0";
	?>
	<?
	include("../000_navbar.php");
	?>
	<main>
		<?
		include("../000_navbarLeft.php");
		?>
		<div class="flex-shrink-0 p-3" style="width: 85%;">
			<br>
			<? echo $panelAlerta;?>
			<div class="panel panel-default">
				<div class="panel-body" style="min-height: 100px;">

					<div class="container-fluid	scroll" style="margin-bottom: 800px;">

						<div class="row" style="margin-bottom: 20px;">
							<h2>Rango de Fechas</h2>
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										Seleccione el rango de fechas a reportar
									</div>
									<div class="card-body">
										<form action="" method="POST">
											<input type="hidden" name="vd" value="monitorPedidos"> 
											<div class="row">
												<div class="col-5">
													<div class="row">
														<div class="col-6">
															<h5>Fecha de Inicio</h5>
														</div>
													</div>
													<div class="row">
														<div class="col-4">
															<label for="exampleFormControlInput1" class="form-label">Año</label>
															<select class="form-control" name="a0">
																<?
																$a0=$post['a0'];
																$a0b=$anos[$a0];
																echo "<option value='$a0'>$a0b</option>";
																foreach ($anos as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
														<div class="col-4">
															<label for="exampleFormControlTextarea1" class="form-label">Mes</label>
															<select class="form-control" name="m0">
																<?
																$m0=$post['m0'];
																$m0b=$meses[$m0];
																echo "<option value='$m0'>$m0b</option>";
																foreach ($meses as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
														<div class="col-4">
															<label for="exampleFormControlTextarea1" class="form-label">Día</label>
															<select class="form-control" name="d0">
																<?
																$d0=$post['d0'];
																$d0b=$dias[$d0];
																echo "<option value='$d0'>$d0b</option>";
																foreach ($dias as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-5">
													<div class="row">
														<div class="col-6">
															<h5>Fecha de Inicio</h5>
														</div>
													</div>
													<div class="row">
														<div class="col-4">
															<label for="exampleFormControlInput1" class="form-label">Año</label>
															<select class="form-control" name="a1">
																<?
																$a1=$post['a1'];
																$a1b=$anos[$a1];
																echo "<option value='$a1'>$a1b</option>";
																foreach ($anos as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
														<div class="col-4">
															<label for="exampleFormControlTextarea1" class="form-label">Mes</label>
															<select class="form-control" name="m1">
																<?
																$m1=$post['m1'];
																$m1b=$meses[$m1];
																echo "<option value='$m1'>$m1b</option>";
																foreach ($meses as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
														<div class="col-4">
															<label for="exampleFormControlTextarea1" class="form-label">Día</label>
															<select class="form-control" name="d1">
																<?
																$d1=$post['d1'];
																$d1b=$dias[$d1];
																echo "<option value='$d1'>$d1b</option>";
																foreach ($dias as $key => $value) {
																	echo "<option value='$key'>$value</option>";
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-2">
													<div class="row">
														<div class="col-12">
															<h5>Municipio</h5>
														</div>
													</div>
													<div class="row">
														<div class="col-12">
															<label for="exampleFormControlTextarea1" class="form-label">Seleccione el municipio</label>
															<select class="form-control"  name="municipio">
																<?
																$municipios="Todos,Andrés Bello,Antonio Rómulo Costa,Ayacucho,Bolívar,Cárdenas,Córdoba,Fernández Feo,Francisco de Miranda,García de Hevia,Guásimos,Independencia,Jáuregui,José María Vargas,Junín,Libertad,Libertador,Lobatera,Michelena,Panamericano,Pedro María Ureña,Rafael Urdaneta,Samuel Dario Maldonado,San Cristóbal,San Judas,Tadeo,Seboruco,Simón Rodríguez,Sucre,Torbes,Uribante,Externo";
																$municipios=explode(",", $municipios);
																$i=1;
																foreach ($municipios as $mun) {
																	echo '<option value="'.$i.'">'.$mun.'</option>';
																	$i++;
																}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-4">
													<button type="submit" class="btn btn-primary">Enviar</button>
												</div>
											</div>
										</div>
									</div>					
								</div>
							</div>
							<div class="row" style="margin-bottom: 20px;">
								<?
								$id="0";
								?>

								<div class="col">
									<? 
									$sql="SELECT count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_estadoCaso_denuncia='4'";
									//p($P,$sql);
									$titulo="Pedidos ejecutados";
									$data=data($sql,$mysqli);
									$clase="success";
									echo graficoTips($data['data']['0']['Total'], $tipo,$titulo, $clase);
									?>
								</div>
								<div class="col">
									<? 
									$sql="SELECT count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_estadoCaso_denuncia='2'";
									$titulo="Pedidos pendientes";
									$data=data($sql,$mysqli);
									$clase="danger";
									echo graficoTips($data['data']['0']['Total'], $tipo,$titulo, $clase);
									?>
								</div>
								<div class="col">
									<? 
									$sql="SELECT count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha";
									if ($result = $mysqli->query($sql)) {
										if ($result->num_rows> 0){
											while ($row = $result->fetch_assoc()){
												$todo=$row['Total'];
											}
										} 
										$result->close();
									} 
									$sql="SELECT count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_estadoCaso_denuncia='3'";
									if ($result = $mysqli->query($sql)) {

										if ($result->num_rows> 0){
											while ($row = $result->fetch_assoc()){
												$parte=$row['Total'];
											}
										} 
										$result->close();
									} 
									$dato=((int)(10000*$parte/$todo))/100;
									$titulo="% de ejecución";
									$data=data($sql,$mysqli);
									$clase="warning";
									echo graficoTips($dato, $tipo,$titulo, $clase);
									?>
								</div>
								<div class="col">
									<? 
									$titulo="% de discapacitados";
									$sql="SELECT count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_discapacidad_denuncia>'1'";
									if ($result = $mysqli->query($sql)) {
										if ($result->num_rows> 0){
											while ($row = $result->fetch_assoc()){
												$parte=$row['Total'];
											}
										} 
										$result->close();
									} 
									$dato=((int)(10000*$parte/$todo))/100;
									$clase="info";
									echo graficoTips($data['data']['0']['Total'], $tipo,$titulo, $clase);
									?>
								</div>
								<div class="col">
									<? 
									$titulo="Municipios beneficiados";
									$sql="SELECT distinct(id_municipio_parroquia) FROM `v_den_denuncia`";
									if ($result = $mysqli->query($sql)) {
										if ($result->num_rows> 0){
											while ($row = $result->fetch_assoc()){
												$numeroMun++;
											}
										} 
										$result->close();
									} 
									$clase="info";
									echo graficoTips($numeroMun, $tipo,$titulo, $clase);
									?>
								</div>
							</div>
							<div class="row">

								<div class="col">
									<? 
									$titulo="Municipio clave";
									$sql="SELECT count(id) as cuenta, descriptor_municipio_parroqui as mun FROM `v_den_denuncia` WHERE id_municipio_parroquia<>1 GROUP BY mun ORDER BY cuenta ASC";
									if ($result = $mysqli->query($sql)) {
										if ($result->num_rows> 0){
											while ($row = $result->fetch_assoc()){
												$munClave=$row['mun'];
											}
										} 
										$result->close();
									} 
									$clase="info";
									echo graficoTips($munClave, $tipo,$titulo, $clase);
									?>
								</div>

							</div>
							<br>

							<div class="row" style="margin-bottom: 20px;">
								<div class="col" style="width: 33%;">
									<?
									$id="1";
									$titulo="% de solicitudes por tipo de discapacidad";
									$sql="SELECT descriptor_discapacidad_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_discapacidad_denuncia>'1' GROUP BY A_campo ORDER BY Total DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
								<div class="col"  style="width: 33%;">
									<?
									$id="2";
									$titulo="% de solicitudes por ente";
									$sql="SELECT descriptor_ente_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_ente_denuncia>'1' GROUP BY A_campo ORDER BY Total DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
								<div class="col"  style="width: 33%;">
									<?
									$id="3";
									$titulo="% de solicitudes por estado del caso";
									$sql="SELECT descriptor_estadoCaso_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_estadoCaso_denuncia>'1' GROUP BY A_campo ORDER BY Total DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
							</div>

							<div class="row" style="margin-bottom: 20px;">

								<div class="col" style="width: 33%;">
									<?
									$id="4";
									$titulo="% de solicitudes por estructura PSUV";
									$sql="SELECT descriptor_estructuraPSUV_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_estructuraPSUV_denuncia>'1' GROUP BY A_campo ORDER BY Total DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
								<div class="col"  style="width: 33%;">
									<?
									$id="5";
									$titulo="% de solicitudes por municipio";
									$sql="SELECT descriptor_municipio_parroqui as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_municipio_parroquia>'1' GROUP BY A_campo ORDER BY Total DESC";
									#p(1,$sql);
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
								<div class="col"  style="width: 33%;">
									<?
									$id="6";
									$titulo="% de solicitudes por parroquia";
									$sql="SELECT descriptor_parroquia_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` WHERE 1=1 $clausulaFecha AND id_parroquia_denuncia>'1' GROUP BY A_campo ORDER BY Total DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
							</div>

							<div class="row">
								<div class="col"  style="width: 33%;">
									<?
									$id="7";
									$titulo="% de solicitudes por tipo";
									$sql="SELECT descriptor_tipoSolicitud_denuncia as `A_campo`, count(id) as `Total` FROM `v_den_denuncia` GROUP BY `A_campo` ORDER BY `Total` DESC";
									$data=data($sql,$mysqli);
									$grafico="TORTA";
									$tabla="1";				
									echo card($id,$titulo,$data,$mysqli,$grafico,$tabla,$subtitulos);
									?>
								</div>
							</div>

							<div style="margin-bottom: 100px;"></div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>


<?

function data($sql,$mysqli){
	$z=array();
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
										#p($P,$row);
				$z['data'][]=$row;
			}
		} 
		$result->close();
	} 
	$primero=$z['data'][0];
	foreach ($primero as $key => $value) {
		$z['ref']['TOTAL']='Total';
		if(substr($key, 0,2)=='A_'){
			$z['ref']['A']=$key;
		}
		if(substr($key, 0,2)=='B_'){
			$z['ref']['B']=$key;
		}
	}
	return($z);
}
function card($id,$titulo,$data,$mysqli,$grafico,$tabla){
	echo '<div class="card"><div class="card-header bg-dark text-light">'. $titulo .'</div>';
	if( in_array($grafico, array('COLUMNAS','BARRAS','TORTA'))){
		echo '<div class="card-body">
		<figure class="highcharts-figure" style="margin: 14px;">
		<div id="grafico_'.$id.'"></div>
		</figure>
		</div>';
	}
	$idGrafico="grafico_".$id;
	switch ($grafico) {
		case 'TORTA':
		echo graficoTortaColumnaBarra($idGrafico,$data,'pie');
		break;
		case 'COLUMNAS':
		echo graficoTortaColumnaBarra($idGrafico,$data,'column');
		break;
		case 'BARRAS':
		echo graficoTortaColumnaBarra($idGrafico,$data,'bar');
		break;
		case 'TIPS':
		foreach ($sql as $key => $value) {
			$subtitulo=$subtitulos[$key];
			p(1,"uygewrygwerygrewyurewyukrewyukrewuyewruyewruyerre");
			echo graficoTips($idGrafico,$data,'',$subtitulo);
		}
		break;
		default:
		break;
	}
	if($tabla){
		echo '<div class="card-body" style="margin-top:-40px;"><table id="'.$id.'" class="display" style="width:100%">'.
		dataTable($id,$data).
		'</table></div>'.
		scriptDatatable($id,$data);
	}
	echo '</div>';
}

function graficoTips($data, $tipo,$titulo,$clase){
	echo '<div class="card text-center"><div class="card-header text-bg-'.$clase.'">'. $titulo .'</div><div class="card-body"><span class="display-1">'.$data.'</span></div></div>';
}


function graficoTortaColumnaBarra($id, $data, $tipo){
	$total=$data['ref']['Total'];
	$A=$data['ref']['A'];
	$z.="<script type='text/javascript'>";
	$z.="Highcharts.chart('".$id."', {
		chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: '".$tipo."' },
		title: { text: '', align: 'left' },
		tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
		accessibility: { point: { valueSuffix: '%' } },
		plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' } } },
		series: [{
			name: 'Brands',
			colorByPoint: true,
			data: [";
			foreach ($data['data'] as $key => $value) {
										# code...
				$name=$value[$A];
				$y=$value['Total'];
				$z.="{ name: '$name', y: $y},";
			}
			$z.="] }] });</script>";
			return($z); 
		}



		function datatable($id,$data){
							#$P=1;
			$A=$data['ref']['A'];
			$B=$data['ref']['B'];
			$table="<thead><tr>";
			p($P,$data);
			p($P,$A);
			p($P,$B);
			$table.='<td>'.$value[$A].'</td>';
			if(isset($B)){ $table.='<td>'.$value[$B].'</td>'; }
			$table.="<th>Total</th>";
			$table.="</thead><tbody>";
			foreach ($data['data'] as $key => $value) {
				$table.="<tr class=''>";
				if(isset($value[$A])){
					$table.='<td>'.$value[$A].'</td>';
				}
				if(isset($value[$B])){
					$table.='<td>'.$value[$B].'</td>';
				}
				$table.='<td>'.$value['Total'].'</td>';
				$table.="</tr>";
			}
			$table.="</tbody>";
			$z=$table;
			return($z);
		}

		function scriptDatatable($id,$data){
			echo '<script type="text/javascript">$(document).ready(function() {$(\'#'.$id.'\').DataTable({dom: \'Bfrtip\',scrollX: true,buttons: [],"pageLength":5,language: {url: \'//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json\',},});});</script>';
		}


		function generarMeses($inicio,$final){
			$inicio=explode('-',$inicio);
			$inicio=$inicio[0];
			$final=explode('-',$final);
			$final=$final[0];
			for ($i=$inicio; $i < $final+1; $i++) { 
				for ($j=1; $j <= 12; $j++) { 
					$rango[$i][$j]=0;
				}
			}
			return $rango;
			return ($a1);
		}

		function tablaPrincipal($mysqli,$fechaInicioSQL,$fechaFinalSQL){
	#$P=1;
			$sql="
			SELECT descriptor_ciudad_libro as `Ciudad`, count(id) as `Total de Libros` FROM `v_cid_libro` GROUP BY `ciudad` ORDER BY `Total de Libros` DESC
			";
			$i=0;
			if ($result = $mysqli->query($sql)) {
				if ($result->num_rows> 0){
					while ($row = $result->fetch_assoc()){
						$r[$i]=$row;
						$indice[$row['Insumo']]=$i;
						$i++;
					}
				} 
				$result->close();
			} 
			$titulos=array_keys($r[0]);
			$table="<thead><tr>";
			foreach ($titulos as $t) {
				$table.="<th>".$t."</th>";
			}
			$table.="</thead><tbody>";
			foreach ($r as $key => $value) {
				$table.="<tr class=''>";
				foreach ($value as $c) {
					$table.="<td>$c</td>";
				}
				$table.="</tr>";
			}
			$table.="</tbody>";
			$z['tabla']=$table;
			$z['data']=$r;
			return($z);
		}

		?>

