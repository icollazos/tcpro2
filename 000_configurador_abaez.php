<?
$mysqli=conectar($datosConexion);

$sql ="SELECT descriptor, alias FROM adm_alias";
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_array()){
			$_SESSION['fvp']['alias'][$row['descriptor']]=$row['alias'];
		}
	}
	$result->close();
} 

$alias=$_SESSION['fvp']['alias'];
$aliasAdicionales="
descriptor_proveedor_factura-Proveedor
descriptor_tipoObjeto_factura-Tipo de Objeto
tipoBeneficio-Tipo de Beneficio
objetoOtrosGastos-Objeto
tipoObjeto-Tipo de Objeto
objetoFactura-Objeto de la Factura
baseImponible-Base Imponible
descriptor_beneficiario_otrosGastos-Beneficiario
descriptor_factura_otrosGastos-Factura
descriptor_tipoBeneficio_otrosGastos-Tipo de Beneficio
descriptor_moneda_otrosGastos-Tipo de Moneda
";


$aliasAdicionales=explode("\n", $aliasAdicionales);
foreach ($aliasAdicionales as $nuevoAlias) {
	$nuevoAlias=explode("-", $nuevoAlias);
	$alias[$nuevoAlias[0]]=$nuevoAlias[1];
}
$aliasJson=json_encode($alias);
$aliasGeneral=$alias;


function tablasFechas(){
	$tablas[]='aaa_factura';
	$tablas[]='aaa_otrosGastos';
	return $tablas;
}

function ambitos($archivo){
	$ambitos=array(
		'index.php'=>'beneficiario',
		'filtrado_consulta.php'=>'factura',
		'filtrado_consulta_torta.php'=>'factura',
		'filtrado_dashboard.php'=>'factura',
		'filtrado_ficha.php'=>'factura',
		'filtrado_lineal.php'=>'factura',
		'filtrado_lineal_totales.php'=>'factura',
	);
	return $ambitos[$archivo];
}

function opcionesAmbitoTablaCRUD(){
	$opciones=array(
		'factura'=>'Facturas',
		'otrosGastos'=>'Otros Gastos',
	);
	return $opciones;
}

function opcionesAmbitoConsultaPrincipal(){
	$opciones=array(
		'factura'=>'Factura',
		'otrosGastos'=>'Otros Gastos',
	);
	return $opciones;
}

function opcionesAmbito(){
	$opciones=array(
		'factura'=>'Facturas',
		'otrosGastos'=>'Otros Gastos',
	);
	return $opciones;
}

function arrayDesplegable(){

	$arrayDesplegable['otrosGastos']=array(
		'id_factura_otrosGastos'=>'Factura',
		'aaa_beneficiario'=>'Beneficiarios',
		'aaa_tipoBeneficio'=>'Tipos de Beneficio',
		'aaa_moneda'=>'Tipos de Moneda',
	);									
	$arrayDesplegable['factura']=array(
		'id_tipoObjeto_factura'=>'Tipos de Objeto',
		'aaa_proveedor'=>'Proveedores'
	);		
	return $arrayDesplegable;
}

function arrayDesplegableTotales(){
	$arrayDesplegableTotales['otrosGastos']=array(
		'monto'=>'Monto'
	);					
	$arrayDesplegableTotales['factura']=array(
		'baseImponible'=>'Base Imponible',
		'montoB'=>'Monto B',
		'montoC'=>'Monto C',
		'montoD'=>'Monto D'
	);
	return $arrayDesplegableTotales;
}

function rechazos($archivo){
	$r['filtrado_mapa_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto');

	$r['filtrado_lineal_select.php']=explode(",", 
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,tipo1,tipo2,tipo3,tipo4,granel,cantidad,baseImponible,montoB,montoC,montoD,objetoFactura,beneficiario,descriptor_factura_otrosGastos,objetoOtrosGastos');

	$r['filtrado_lineal_totales_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,cantidad,familiasCantidad,fechaBeneficiarioGas,sector,granel,cantidad,beneficiados,baseImponible,montoB,montoC,montoD,objetoFactura,beneficiario,descriptor_factura_otrosGastos,objetoOtrosGastos');	

	$r['filtrado_consulta_torta_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,cantidad,sector,familiasCantidad,granel,baseImponible,montoB,montoC,montoD,objetoFactura,descriptor_factura_otrosGastos,descriptor_beneficiario_otrosGastos,objetoOtrosGastos');

	return $r[$archivo];
}


function configMapa($ambito){
	$configMapa['gasTotales']='municipio_gasTotales';
	$configMapa['social']='municipio_social';
	$configMapa['fft']='municipio_fft';
	return $configMapa[$ambito];
}

function opcionesAmbitoMapas(){
	$opciones=array(
		'social'=>'Ayudas sociales',
		'fft'=>'Fundacion Familia Tachirense',
		'gasTotales'=>'Totalización del gas',
	);
	return $opciones;
}


function j($x){
	echo json_encode($x);
	die();
}


