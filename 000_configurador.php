<?
$mysqli=conectar($datosConexion);
p(1,$mysqli);

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
totalUSD_Total en USD
descriptor_tipoOperacion_otrosGastos-Tipo de Operacion
descriptor_tipoBeneficio_otrosGastos-Tipo de Beneficio
tipoNivel-Nivel
tipoOrganismo-Organismo
descriptor_tipoActor_actor-Tipo de Actor
tipoActor-Tipo de Actor
tipoFuerza-Fuerza
tipoRelacion-Relacion
actor2-Actor Asociado
descriptor_seguimiento_item-Seguimiento
descriptor_proyecto_seguimiento-Proyecto
descriptor_tipoSeguimiento_seguimiento-Tipo de Fuente
descriptor_variable_valor-Variable
descriptor_seguimientoEspejo_variable-Seguimiento
descriptor_tipoVariable_variable-Tipo de Variable
descriptor_fuente_seguimiento-Fuente
descriptor_tipoSeguimiento_fuente-Tipo de Fuente
seguimientoEspejo-Seguimiento
textoTarzan-Lemas
";


$aliasAdicionales=explode("\n", $aliasAdicionales);
foreach ($aliasAdicionales as $nuevoAlias) {
	$nuevoAlias=explode("-", $nuevoAlias);
	$alias[$nuevoAlias[0]]=$nuevoAlias[1];
}
$aliasJson=json_encode($alias);
$aliasGeneral=$alias;


function tablasFechas(){
	$tablas[]='aaa_actor';
	return $tablas;
}
function logos($x){
	$logos=array(
	'tioconejo'=>'tcpro.png',
	'presidenciaArgentina'=>'presidenciaArgentina.png',
	'bancoCentralChile'=>'bancoCentralChile.png'
	);
	return $logos[$x];
}
function logosCreditos($x){
	$logos=array(
	'tioconejo'=>'tcpro.png',
	'presidenciaArgentina'=>'datco.jpg',
	'bancoCentralChile'=>'datco.jpg'
	);
	return $logos[$x];
}
function membretes($x){
	$logos=array(
	'tcpro'=>'TCPRO',
	'presidenciaArgentina'=>'Gestión de noticias,Presidencia <br> de la República Argentina',
	'bancoCentralChile'=>'Gestión de noticias,Banco Central de Chile'
	);
	return $logos[$x];
}
function refCliente($x){
	$logos=array(
	'tioconejo'=>'tioconejo',
	'presidenciaArgentina'=>'presidenciaArgentina',
	'bancoCentralChile'=>'bancoCentralChile'
	);
	return $logos[$x];
}
function cliente($x){
	$logos=array(
	'tioconejo'=>'',
	'presidenciaArgentina'=>'2',
	'bancoCentralChile'=>'3'
	);
	return $logos[$x];
}
function nomCliente($x){
	$logos=array(
	'tioconejo'=>'TCPRO',
	'presidenciaArgentina'=>'Presidencia de la República Argentina',
	'bancoCentralChile'=>'Banco Central de Chile'
	);
	return $logos[$x];
}
function chatbot($x){
	$logos=array(
	'tioconejo'=>'',
	'presidenciaArgentina'=>'https://web.powerva.microsoft.com/environments/Default-caf0d501-c689-4fad-9045-3cbcc3a5da8c/bots/cra81_presidenciaDeLaNacion/webchat?__version__=2',
	'bancoCentralChile'=>'https://web.powerva.microsoft.com/environments/Default-caf0d501-c689-4fad-9045-3cbcc3a5da8c/bots/cra81_bancoCentral/webchat?__version__=2',
	);
	return $logos[$x];
}
function restriccion(){
	$z['vertical']=explode(',','proyecto,seguimiento,item,texto,textoValor,dicTextoValor,textoSentimiento');
	$z['lateral']=explode(',','variable,valor,dicRechazo,dicValor');
	$z['ninguna']=explode(',','dicDescarte');
	return $z;
}
function ambitos($archivo){
	$ambitos=array(
		'index.php'=>'proyecto',
		'filtrado_consulta.php'=>'texto',
		'filtrado_consulta_torta.php'=>'proyecto',
		'filtrado_dashboard.php'=>'proyecto',
		'filtrado_ficha.php'=>'proyecto',
		'filtrado_lineal.php'=>'proyecto',
		'filtrado_lineal_totales.php'=>'proyecto',
		'pry_textoIndividual.php'=>'texto',
		'pry_textoValor_tabla.php'=>'texto',
		'pry_textoValor_crear.php'=>'texto',
		'pry_frasesClave.php'=>'texto',
		'pry_dashboard.php'=>'texto',
		'pry_chatbot.php'=>'texto',
		'gra_unaVariable.php'=>'texto',
		'gra_dosVariables.php'=>'texto',
		'gra_nube.php'=>'texto',
		'gra_nubeCategorias.php'=>'texto',
		'gra_grafo.php'=>'texto',
	);
	return $ambitos[$archivo];
}
function opcionesAmbitoTablaCRUD(){
	$opciones=array(
		'proyecto'=>'Proyectos',
		'seguimiento'=>'Seguimientos',
		'item'=>'Items',
		'variable'=>'Variables',
		'valor'=>'Valores',
	);
	return $opciones;
}
function opcionesAmbitoConsultaPrincipal(){
	$opciones=array(
		'texto'=>'Textos',
		'proyecto'=>'Proyectos',
		'seguimiento'=>'Seguimientos',
		'item'=>'Items',
		'variable'=>'Variables',
		'valor'=>'Valores',
		/*
		'dicValor'=>'Diccionario de valores',
		'dicDescarte'=>'Diccionario de descarte',
		'dicRechazo'=>'Diccionario de rechazos',
		'textoValor'=>'Textos / Valores',
		*/
	);
	return $opciones;
}
function opcionesAmbito(){
	$opciones=array(
		'proyecto'=>'Actores',
		'relacion'=>'Relaciones',
		'cv'=>'Carrera',
	);
	return $opciones;
}
function arrayDesplegable(){

	$arrayDesplegable['texto']=array(
		/*
		'id_fuente_seguimiento'=>'Tipo de Fuente',
		*/
	);		
	$arrayDesplegable['item']=array(
		'id_tipoSeguimiento_fuente'=>'Tipo de Fuente',
	);		
	$arrayDesplegable['seguimiento']=array(
		'id_tipoSeguimiento_fuente'=>'Tipo de Fuente',
	);		
	$arrayDesplegable['valor']=array(
		'id_variable_valor'=>'Valores',
		'id_seguimientoEspejo_variable'=>'Variable',
		'id_tipoVariable_variable'=>'Tipo de Variable',
	);		
	$arrayDesplegable['variable']=array(
		'id_tipoVariable_variable'=>'Tipo de Variable',
	);		
	$arrayDesplegable['textoValor']=array(
		'id_valor_textoValor'=>'Valor',
		'id_item_texto'=>'Item',
		'id_variable_valor'=>'Variable',
		'id_seguimiento_item'=>'Seguimiento',
		'id_tipoVariable_variable'=>'Tipo de Variable',
		'id_proyecto_seguimiento'=>'Proyecto',
		'id_fuente_seguimiento'=>'Fuente',
	);		
	$arrayDesplegable['dicValor']=array(
		'id_seguimientoEspejo_variable'=>'Seguimiento',
		'id_tipoVariable_variable'=>'Tipo de Variable',
		'id_variable_valor'=>'Variable',
		'id_valor_dicValor'=>'Valor',
	);		
	return $arrayDesplegable;
}
function arrayDesplegableTotales(){
	$arrayDesplegableTotales['facturaTotalizacion']=array(
		'baseImponible'=>'Base Imponible',
		'otrosImpuestos'=>'Otros Impuestos',
		'responsabilidadSocial'=>'Responsabilidad Social',
		'sumar'=>'SUMAR',
		'montoTercerizacion'=>'Monto de Tercerizacion',
		'otrosAsociados'=>'Otros Asociados',
		'totalUSD'=>'Total en USD',
		'totalBS'=>'Total en Bs',
	);					
	$arrayDesplegableTotales['otrosGastosTotalizacion']=array(
		'id'=>'Numero de operaciones',
		'montoUSD'=>'Monto en USD',
		'montoBS'=>'Monto en BS',
	);					
	return $arrayDesplegableTotales;
}
function rechazos($archivo){
	$r['filtrado_mapa_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto');

	$r['filtrado_lineal_select.php']=explode(",", 
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,tipo1,tipo2,tipo3,tipo4,granel,cantidad,baseImponible,montoB,montoC,montoD,objetoFactura,beneficiario,descriptor_factura_otrosGastos,objetoOtrosGastos');

	$r['filtrado_lineal_totales_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,cantidad,familiasCantidad,fechaBeneficiarioGas,sector,granel,cantidad,beneficiados,descriptor_factura_otrosGastos,descriptor_beneficiario_otrosGastos,objetoOtrosGastos,tasaF,iva,otrosImpuestos,responsabilidadSocial,sumar,otrosAsociados,islr,montoTercerizacion,totalBS,totalUSD,tasaOG,montoUSD,montoBS,baseImponible,objetoFactura');	

	$r['filtrado_consulta_torta_select.php']=explode(",",
		'id,descriptor,fecha,fechaHora,volumen,beneficiarios,apellido,nombre,cedula,telefono,nucleoFamiliar,monto,cantidad,sector,familiasCantidad,granel,baseImponible,montoB,montoC,montoD,objetoFactura,descriptor_factura_otrosGastos,descriptor_beneficiario_otrosGastos,objetoOtrosGastos,tasaF,iva,otrosImpuestos,responsabilidadSocial,sumar,otrosAsociados,islr,montoTercerizacion,totalBS,totalUSD,tasaOG,montoUSD,montoBS,beneficiario');

	return $r[$archivo];
}
function configMapa($ambito){
	/*
	$configMapa['aaa']='municipio_gasTotales';
	$configMapa['social']='municipio_social';
	$configMapa['fft']='municipio_fft';
	return $configMapa[$ambito];
	*/
}
function opcionesAmbitoMapas(){
	/*
	$opciones=array(
		'social'=>'Ayudas sociales',
		'fft'=>'Fundacion Familia Tachirense',
		'gasTotales'=>'Totalización del gas',
	);
	return $opciones;
	*/
}
function j($x){
	echo json_encode($x);
	die();
}


