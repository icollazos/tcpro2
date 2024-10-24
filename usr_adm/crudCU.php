<?
session_start();
$uniUsuario=$_SESSION['fvp']['uniUsuario'];
include('../000_conexion.php');
$mysqli=conectar($datosConexion);
$P=0;
$_SESSION['fvp']['P']=$P;
p($P,$_POST);
$td=$_POST['tabla'];
$from=$_POST['from'];


$_SESSION['fvp']['datosConexion']=$datosConexion;

if(isset($_POST['tabla'])){
	$_SESSION['fvp']['tabla']=$_POST['tabla'];
	$_SESSION['fvp']['from']=$_POST['from'];
}
$tabla=$_SESSION['fvp']['tabla'];
$from=$_SESSION['fvp']['from'];


if(isset($_POST['idRegistro'])){
	$idRegistro=$_POST['idRegistro'];
	$_SESSION['fvp']['idRegistro']=$idRegistro;
	#p($P,$idRegistro);
	$_SESSION['fvp']['postInicial']=$_POST;
	$_SESSION['fvp']['valoresIniciales']=cargaValoresIniciales($tabla,$idRegistro);
	$valoresIniciales=$_SESSION['fvp']['valoresIniciales'];
	#p($P,$valoresIniciales);
} else {
	unset($_SESSION['fvp']['valoresIniciales']);
}

$tablasSeguras=$_SESSION['fvp']['tablasSeguras'];
in_array($tabla, $tablasSeguras) ? $seguro=1 : $seguro=0;
#p($P,$tabla);


//$escaleras=cargaEscaleras();
#p($P,$escaleras);


//$hijos=cargaHijos();
#p($P,$hijos);


//$escaleraHijos=cargaEscaleraHijos();
#p($P,$escaleraHijos);

$campos=cargaCampos($tabla,$escaleras);
#p($P,'campos');
#p($P,$campos);
$formularioZ='';

foreach ($campos as $campo => $tipo) {
	#echo $tipo;
	if($tipo=='inputText'){
		$formularioZ.=creaInputText($campo,$valorActual,$seguro);
	}
	if($tipo=='inputFecha'){
		#echo "FEFEFE";
		$formularioZ.=creaInputFecha($campo,$valorActual);
	}
	if($tipo=='select'){
		#echo "SELECT";
		$array=cargaArraySelect($campo);
		#p($P,$array);
		$formularioZ.=creaSelect($array,$campo,0,$mysqli);
	}
	if($tipo=='tipo'){
		$formularioZ.=creaSelectTipo($mysqli,$tabla,$campo);
		#p($P,$array);
	}
}

/*
foreach ($campos as $campo => $tipo) {
	if(is_array($tipo)){
		#p($P,$tipo);
		$item=creaEscalera($campo,$escaleras,$hijos,$mysqli);
		//$formularioZ.=$item;
	}
}
*/




$post=$_POST;
#p($P,$post);
#die();

if(isset($_POST['confirmado']) OR isset($_SESSION['fvp']['idRegistro'])){
	if(isset($_SESSION['fvp']['idRegistro'])) {
		$sql=sqlUpdate($tabla,$_SESSION['fvp']['idRegistro'],$post);
	} else {
		$sql=sqlInsert($post,$campos,$tabla);
	}
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {}
		if($seguro==1) {
			$sql="UPDATE $tabla SET descriptor=id";
			if ($result = $mysqli->query($sql)) {}
		}

	
	if(isset($_POST['confirmado'])){

		$sql="SELECT max(id) as m FROM $tabla";
		if ($result = $mysqli->query($sql)) {
			if ($result->num_rows> 0){
				while ($row = $result->fetch_assoc()){
					$m=$row['m'];
				}
			} 
			$result->close();
		} 
	//echo $tabla.' '.$m;
		mkdir ("archivos/".$tabla."/".$m);
		header("Location: $from");	
		#die();
	}
}

function creaSelectTipo($mysqli,$tabla,$nombre){
	$P=$_SESSION['fvp']['P'];
	#p($P,$tabla);
	#p($P,$nombre);
	$sql="SELECT tabla, campo, valores  FROM adm_master WHERE tabla='$tabla' AND campo='$nombre'";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$op[]=$row['valores'];
			}
		} 
		$result->close();
	} 
	#p($P,$op);

	$valorInicial=$_SESSION['fvp']['valoresIniciales'][$nombre];
	$textoInicial=$_SESSION['fvp']['valoresIniciales'][substr($nombre,2,100)];
	#p($P,"CREA SELECT");
	#p($P,$valorInicial);
	#p($P,$textoInicial);
	#p($P,$hijo);
	$aliasCampos=$_SESSION['fvp']['aliasCampos'];
	$z='
	<div class="form-group">
	<label for="'.$nombre.'" class="col-sm-4 control-label text-left">'.$aliasCampos[$nombre].'</label>
	<div class="col-sm-8">
	<select class="form-control"  id="'.$nombre.'" name="'.$nombre.'" '.$onchange.'>';
	if($valorInicial!=''){
		$z.='<option value="'.$valorInicial.'">Actual: '.$textoInicial.'</option>';
	} else {
		$z.='<option value="">Seleccione...</option>';
	}
	foreach ($op as $key => $value) {
		$z.='<option value="'.$value.'">'.$value.'</option>';
	}
	$z.='</select>
	</div>
	</div>';
	return $z;
}

function cargaCampos($tabla,$escaleras){
	$P=$_SESSION['fvp']['P'];
	#p($P,"CARGA CAMPOS");
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$sql="SHOW COLUMNS FROM $tabla";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$f=$row['Field'];
				if(substr($f,0,2)=='id' AND strlen($f)>2) {
					if(in_array($f, array_keys($escaleras))){
						$z[$f]=$escaleras[$f];
					} else {
						$z[$f]='select';				
					}
				} elseif (substr($f,0,5)=='fecha') {
					$z[$f]='inputFecha';
				}  elseif (substr($f,0,5)=='tipo_') {
					$z[$f]='tipo';
				}
				else {
					$z[$f]='inputText';
				}	
			}
		} 
		$result->close();
	} 
	#p($P,$z);
	$mysqli->close();
	return $z;
}

function cargaValoresIniciales($tabla,$idRegistro){
	$P=$_SESSION['fvp']['P'];
	#p($P,"CARGA VALORES");
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$sql="SELECT * from $tabla WHERE id=$idRegistro";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$post=$row;
			}
		} 
		$result->close();
	} 
	#p($P,$post);
	return $post;
}

function sqlInsert($post,$campos,$tabla){
	$P=$_SESSION['fvp']['P']=$P;
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$keys=array_keys($campos);
	#p($P,$post);
	foreach ($post as $keyp => $valuep) {
		if(!in_array($keyp, array('descriptor','from','tabla','confirmado'))){
			$v=explode('|||||',$valuep);
			if($v[1]){
				$v=$v[1];
			} else {
				$v=$v[0];
			}
			$descriptor.=$v.' ';
		}
	}
	#p($P,$descriptor);
	foreach ($post as $keyp => $valuep) {
		if(in_array($keyp, $keys)){
			$kp=$keyp;
			$vp=$valuep;
			#p($P,$valuep);
			$vp=explode('|||||',$valuep);
			$vp=$vp[0];
			#p($P,$vp);
			if(substr($kp,0,5)=='fecha'){
				$vp=substr($vp,6,10).'-'.substr($vp,3,2).'-'.substr($vp,0,2);
			}
			if($keyp!='id' and $keyp!='descriptor'){
				$cam .="$kp, ";
				$val .="'$vp', ";
			}
			if($keyp=='descriptor'){
				$cam .="$kp, ";
				$val .="'$vp', "; 
			}
		}
	}
	#p($p,$cam);
	$cam=substr($cam, 0,-2);
	$val=substr($val, 0,-2);
	$sql="INSERT INTO $tabla ";
	$sql.= '('.$cam.') VALUES ('. $val.');';
	$control=1;
	if($control==1){
		$sql.="#ejecutando;
		";
	}
	#p($P,$sql);
	//die();
	return $sql;
}

function sqlUpdate($tabla,$idRegistro,$post){
	#$post=cargaValoresIniciales($tabla,$idRegistro);
	$P=$_SESSION['fvp']['P'];
	#p($P,$tabla);
	#p($P,$idRegistro);
	#p($P,$post);
	$escaleras=cargaEscaleras();
	$campos=cargaCampos($tabla,$escaleras);
	$keys=array_keys($campos);
	#p($P,$post);
	foreach ($post as $keyp => $valuep) {
		if(in_array($keyp, $keys)){
			$kp=$keyp;
			$vp=$valuep;
			if(substr($kp,0,5)=='fecha'){
				$vp=substr($vp,6,10).'-'.substr($vp,3,2).'-'.substr($vp,0,2);
			}
			if($keyp!='id'){
				$cam .="$kp = '$vp', ";
			}
		}
	}
	$cam=substr($cam, 0,-2);
	#$cam=str_replace("descriptor", "id", $cam);
	$sql="UPDATE  $tabla SET $cam WHERE id='$idRegistro'";
	p($P,$sql);
	return $sql;
}

function cargaEscaleraHijos(){
	$P=$_SESSION['fvp']['P'];
	#p($P,'Escalera de Hijos');
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$sql="SELECT descriptor FROM adm_cadenas";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$exp=explode(",", $row['descriptor']);
				krsort($exp);
				$a[]=$exp;
			}
		#p($P,$a);
		} 
		$result->close();
	} 
	$mysqli->close();
	foreach ($a as $keya => $valuea) {
		foreach ($valuea as $keyb => $valueb) {
			$b[$keya][]=$valueb;
		}
	}
	foreach ($b as $keyb => $valueb) {
		for ($i=0; $i < count($valueb); $i++) { 
			for ($j=$i+1; $j < count($valueb); $j++) { 
				$z[$valueb[$i]][]=$valueb[$j];
			}		
		}
	}
	foreach ($z as $key => $value) {
		$z[$key]=array_unique($z[$key]);
	}
	#p($P,$b);
	return $z;
}

function creaEscalera($id,$escaleras,$hijos,$mysqli){
	$P=$_SESSION['fvp']['P'];
	#p($P,"CREA ESCALERA");
	$z='';	
	#p($P,$id);
	#p($P,$escaleras);
	#p($P,$hijos);
	$cuenta=count($escaleras);
	#p($P,$cuenta);
	$i=0;
	foreach ($escaleras[$id] as $key => $value) {
	#p($P,"ESCALON");
	#p($P,$hijos);
	#p($P,$key);
		$array=cargaArraySelect($key);
		$h=0;
		if($i<$cuenta-2){
		#p($P,$i);
			$h=$hijos[$key];
		}
		if($h==''){$h=0;}
		$item=creaSelect($array,$key,$h,$mysqli);
		$z.=$item;
		$i++;
	}
	$z.='';
	return $z;
}

function creaSelect($array,$nombre,$hijo,$mysqli){
	$P=$_SESSION['fvp']['P'];
	//p($P,$mysqli);

	$aliasCampos=$_SESSION['fvp']['aliasCampos'];
	#$nombre=$aliasCampos[$nombre];
	$valorInicial=$_SESSION['fvp']['valoresIniciales'][$nombre];
	
	$tablaOrigen=trim(substr($nombre, 2,1000));
	$sql="SELECT descriptor FROM $tablaOrigen WHERE id='$valorInicial'";
	#p($P,$sql);
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$textoInicial=$row['descriptor'];
			}
			$result->close();
		}
	} 
	#p($P,"CREA SELECT");
	#p($P,$nombre);
	#p($P,$valorInicial);
	#p($P,$textoInicial);
	#p($P,"CREA SELECT");
	#p($P,$hijo);
	if($hijo!==0){
	#p($P,"ONCHANGE");
		$onchange.='onchange="filtra(\''.$nombre.'\',\''.$hijo.'\')"'; 
	}
	$z.='<div class="form-group">';
	$z.='<label for="'.$nombre.'" class="col-sm-4 control-label text-left">'.ucwords($aliasCampos[$nombre]).'</label>';
	$z.='<div class="col-sm-4">';
	$z.='<select class="form-control"  id="'.$nombre.'" name="'.$nombre.'" '.$onchange.'>';
	if($valorInicial!=''){
		$z.='<option value="'.$valorInicial.'">Actual: '.$textoInicial.'</option>';
	} else {
		$z.='<option value="">Seleccione...</option>';
	}
	foreach ($array as $key => $value) {
		$z.='<option value="'.$key.'|||||'.$value.'">'.$key.': '.$value.'</option>';
	}
	$z.='</select>';
	$z.='</div>';
	$z.='</div>';
	if(substr($nombre, -9,9)!='municipio'){
		return $z;
	}
}

function creaInputText($nombre,$valorActual,$seguro){
	$P=0;
	#p($P,"CREA INPUT TEXTO");
	#p($P,$nombre);
	$P=$_SESSION['fvp']['P'];
	#p($P,$_SESSION['fvp']);
	$valorInicial=$_SESSION['fvp']['valoresIniciales'][$nombre];
	$aliasCampos=$_SESSION['fvp']['aliasCampos'];
	#p($P,$valorInicial);
	$type='text';
	$label='';
	if($nombre=='id' or $nombre=='fechaHora' or $nombre=='borrar' or substr($nombre, 0, 5)=='rango' ){
		$type='hidden';
	} elseif ($seguro==1 AND $nombre=='descriptor'){ 
		#$label = '<label for="inputEmail3" class="col-sm-4 control-label">Ingrese: '.$nombre.'</label>';
		$type='hidden'; 
	} else {
		$label = '<label for="inputEmail3" class="col-sm-4 control-label">'.(ucwords($aliasCampos[$nombre])).'</label>';
	}
	if($type!='hidden'){
		$z='<div class="form-group">'.$label.
		'<div class="col-sm-4">
		<input class="form-control" type="'.$type.'" name="'.$nombre.'" id="'.$nombre.'" placeholder="Ingrese '.$nombre.'" value="'.$valorInicial.'"/>
		</div>
		</div>';
	};
	return $z;
}

function creaInputFecha($nombre,$valor){
	$P=$_SESSION['fvp']['P'];
	#p($P,"INPUT FECHA");
	$valorInicial=$_SESSION['fvp']['valoresIniciales'][$nombre];
	$aliasCampos=$_SESSION['fvp']['aliasCampos'];

	#p($P,$valorInicial);
	if(strlen($valorInicial)==0){
		$valorInicial="";
	} else {
		$valorInicial=substr($valorInicial, 8,2).'/'.substr($valorInicial, 5,2).'/'.substr($valorInicial, 0,4);
	}
	#p($P,$valorInicial);
	if($nombre!="fechaHora"){
		$z ='
		<div class="form-group">
		<label for="dtp'.$nombre.'" class="col-sm-4 control-label">'.ucwords($aliasCampos[$nombre]).'</label>
		<div class="col-sm-4">
		<div class=\'input-group date\' id=\''.$nombre.'\'>
		<input type=\'text\' class="form-control" name="'.$nombre.'" value="'.$valorInicial.'" placeholder="Escriba una fecha en formato DD/MM/AAAA"/>
		<span class="input-group-addon">
		<span class="glyphicon glyphicon-calendar">
		</span>
		</span>
		</div>
		</div>
		</div>
		<script type="text/javascript">$(function () { $(\'#'.$nombre.'\').datetimepicker({ locale: \'es\', format: \'DD/MM/YYYY\' }); });</script>';
	}
	return $z;
}

function cargaHijos(){
	$P=$_SESSION['fvp']['P'];
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$sql="SELECT descriptor FROM adm_cadenas";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$e=explode(",", $row['descriptor']);
				krsort($e);
				foreach ($e as $e2) {
					$a[]=$e2;
				}
				foreach ($a as $key => $value) {
					if (!isset($b[$a[$key]])) {
						$b[$a[$key]]=$a[$key+1];
					}
				}
				unset($a);
			}
		} 
		$result->close();
	} 
	$mysqli->close();
	foreach ($b as $key => $value) {
		if($value==''){
			unset($b[$key]);
		}
	}
	#p($P,$b);
	return $b;
}

function cargaArraySelect($campo){
	$P=$_SESSION['fvp']['P'];
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	#p($P,$campo);
	$padre=substr($campo, 2,100);
	$sql="SELECT id, descriptor FROM $padre ";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$z[$row['id']]=$row['descriptor'];
			}
		} 
		$result->close();
	} 
	$mysqli->close();
	return $z;
}

function cargaEscaleras(){
	$P=$_SESSION['fvp']['P'];
	$P=$_SESSION['fvp']['P'];
	$mysqli=conectar($_SESSION['fvp']['datosConexion']);
	$sql="SELECT descriptor FROM adm_cadenas";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows> 0){
			while ($row = $result->fetch_assoc()){
				$e=explode(",", $row['descriptor']);
				$id=array_shift($e);
				krsort($e);
				foreach ($e as $e2) {
					$a[]=$e2;
				}
				$b[$id]=$a;
				unset($a);
			}
		} 
		$result->close();
	} 
	#p($P,$b);
	$mysqli->close();
	foreach ($b as $key => $value) {
		$cuenta=0;
		foreach ($value as $key2 => $value2) {
			$tipo='select';
			if($cuenta==0){$tipo='select';}
			$z[$key][$value2]=$tipo;
			$cuenta++;
		}
		$z[$key][$key]='select';
	}
	#p($P,$z);
	return $z;
}
?>


<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="../calendar/css/calendar_style.css">

<html>
<? include('../000_head.php'); ?>
<body>
	<? include("../000_navbar.php"); ?>
	<main style="max-height: 850px;">
		<? include("../000_navbarLeft.php"); ?>
		<div class="flex-shrink-0 p-3 bg-white scroll" style="width: 85%;">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Editando el registro</h3>
				</div>

				<div class="panel-body" style="min-height: 0px;">
					<div class="">

						<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
							<? echo $formularioZ; ?>
							<? if($geo==1){ ?>
								<div class="form-group">
									<label for="Estado" class="col-sm-4 control-label text-left">Estado</label>
									<div class="col-sm-4">
										<select class="form-control" id='estado' name='estado' onchange="PadreHijo();">
											<?
											foreach ($arrayEstados as $key => $value) {
												echo '<option value="'.$key.'">'.$value.'</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="municipio" class="col-sm-4 control-label text-left">Municipio</label>
									<div class="col-sm-4">
										<select class="form-control" id='municipio' name='id<?echo substr($tabla, 0,3) . '_'; ?>municipio'>
										</select>
									</div>
								</div>
								<?
							}
							?>

							<?
							#echo $inputSimple;
							?>
							<? if($selectPadres) { echo "<h4>Referencias Externas</h4>"; } ?>
							<?
							#echo $selectPadres;
							#echo $from;
							$href="index.php?view=$tabla";
							if(substr($from, 0,9)=="consulta_"){
								$href=$from;
							}

							?>
							<input type="hidden" name="from" value="<?echo $from;?>">
							<input type="hidden" name="tabla" value="<?echo $tabla;?>">
							<hr>
							<div class="text-center">
								<button class="btn btn-success" name="confirmado" value="1">
									Graba
								</button>
								<a href="<?echo $href;?>" class="btn btn-primary">Volver</a>
							</div>
						</form>
						<br>
					</div>
				</div>
			</div>

		</div>
	</main>


</body>
</html>


<script src="../calendar/js/jquery.min.js"></script>
  <script src="../calendar/js/popper.js"></script>
  <script src="../calendar/js/bootstrap.min.js"></script>
  <script src="../calendar/js/main.js"></script>


<script type="text/javascript">



	PadreHijo();

	function PadreHijo(){
		var sEstado=$('#estado');
		var sMun=$('#municipio');
		var a=JSON.parse(<?echo json_encode($arrayMunicipios);?>)
		console.log(a);
		var iE=($('#estado option:selected').val());
		console.log(iE);
		var objeto=a[iE];
		console.log(objeto);
		var s=sEstado;
		sMun.empty();
		let text = "";
		var v;
		for (let x in a[iE]) {
			console.log(x);
			var p=a[iE][x];
			v=p[1];
			sMun.append($("<option>", {
				value: x,
				text: x + ' ' + v
			}));
		}
	}



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

$(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example thead tr')
    .clone(true)
    .addClass('filters')
    .appendTo('#example thead');

    var table = $('#example').DataTable({
    	orderCellsTop: true,
    	fixedHeader: true,
    	initComplete: function () {
    		var api = this.api();

            // For each column
            api
            .columns()
            .eq(0)
            .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                    	$(api.column(colIdx).header()).index()
                    	);
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $(
                    	'input',
                    	$('.filters th').eq($(api.column(colIdx).header()).index())
                    	)
                    .off('keyup change')
                    .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                            .column(colIdx)
                            .search(
                            	this.value != ''
                            	? regexr.replace('{search}', '(((' + this.value + ')))')
                            	: '',
                            	this.value != '',
                            	this.value == ''
                            	)
                            .draw();
                        })
                    .on('keyup', function (e) {
                    	e.stopPropagation();

                    	$(this).trigger('change');
                    	$(this)
                    	.focus()[0]
                    	.setSelectionRange(cursorPosition, cursorPosition);
                    });
                });
        },
    });
});

</script>
