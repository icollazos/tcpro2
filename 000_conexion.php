<?

error_reporting(0);
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$_SESSION['P']=1; 
if(!isset($_SESSION['fvp']['fechaInicio'])){
	$_SESSION['fvp']['fechaInicio']='01/01/1000';
}
if(!isset($_SESSION['fvp']['fechaFinal'])){
	$_SESSION['fvp']['fechaInicio']='31/12/2023';
}
$datosConexion=array(
	'host'=>'mysql-igorcollazos.alwaysdata.net',
	'user'=>'191240',
	'password'=>'!1QazzaQ1!',
	'port'=>'',
	'database'=>'igorcollazos_tcpro'
);
$_SESSION['datosConexion']=$datosConexion;

include("000_configurador.php");


$_SESSION['fvp']['tablasSeguras']=array('per_persona','leg_expediente');

$_SESSION['fvp']['pares']=array(
	'pie'=>'Torta',
	'bar'=>'Barras',
	'column'=>'Columnas',
	'line'=>'Líneas',
	'curvas'=>'Curvas',
	'area'=>'Áreas',
	'stackedcolumn'=>'Columnas Apiladas',
	'stackedbar'=>'Barras Apiladas',
);

function p($p,$a) { 
	if($p){
		echo "<pre>"; 
		print_r($a);
		echo "</pre>"; }
	}; 


	function dtp($id){
		return '<div class="form-group"><div class=\'input-group date\' id=\'datetimepicker'.$id.'\'><input type=\'text\' class="form-control" name=data'.$id.'"/><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div><script type="text/javascript">$(function () {$(\'#datetimepicker'.$id.'\').datetimepicker({locale: \'es\',format: \'DD-MM-YYYY\'});});</script>';
	}

	function conectar($datosConexion){
		$conn = new mysqli($datosConexion['host'],$datosConexion['user'],$datosConexion['password'],$datosConexion['database']);
		return $conn;
	}

	function well($mensaje,$class){
		if($mensaje!=''){
			return '<div class="well well-lg '.$class.'">'.$mensaje.'</div>';
		}
	}

	function panel($class,$titulo,$body){
		if($body!=''){
			return '<div class="panel panel-'.$class.'">
			<div class="panel-heading">
			<h3 class="panel-title">'.$titulo.'</h3>
			</div>
			<div class="panel-body">
			'.$body.'
			</div>
			</div>';
		}
	}

	?>