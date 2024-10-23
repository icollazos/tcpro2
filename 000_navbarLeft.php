<?
session_start();
$P=0;

$misDatos=$_SESSION['fvp']['misDatos'];

$idUsuario=$_SESSION['fvp']['idUsuario'];

$nivelDeUsuario=$_SESSION['fvp']['nivel'];
$prefijo=$_SESSION['fvp']['prefijo'];

$arrayPerfiles=array(2=>"ADM",3=>"ANA");
$prefijoCarpeta='adm';

$sql="SELECT idadm_perfil FROM adm_usuario WHERE id='$idUsuario'";
#p($P,$sql);
if ($result = $mysqli->query($sql)) {
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			$iduniPerfil=$row['idadm_perfil'];
			$_SESSION['fvp']['nivel']=$iduniPerfil;
		}
	}
}

$sql="SELECT adm_views.id as id, adm_views.descriptor as descriptor, adm_views.alias as alias FROM adm_views INNER JOIN adm_viewPerfil ON adm_views.id = adm_viewPerfil.idadm_views WHERE adm_viewPerfil.idadm_perfil='$iduniPerfil' order by alias asc";

if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			#echo $row['descriptor'].' --- ';
			$sel='<li><a class="link-dark rounded" href="index.php?view='.trim($row['descriptor']).'">'.substr($row['alias'],4,50) .'</a></li>';
			#$sel='?view='.trim($row['descriptor']).'">'.substr($row['alias'],4,50);
			#$selectViewLeft.=$sel;
			$trim=trim(strtoupper(substr($row['alias'], 0,3)));
			$selectViewLeft[$trim][]=$sel;
		}
	} else {
	}
	$result->close();
} else {
	$sqlResult = mysqli_error($mysqli);
} 

//////////////////////////////////////// AQUI ASIGNO LAS SECCIONES DEL NAVBARLEFT PARA PERFILES DE USUARIO
$controlPermisos[0]=explode(',','Configuracion,Administracion,Monitor,Principal,Referencia,Graficos,Textos');
$controlPermisos[1]=explode(',','Configuracion,Administracion,Monitor,Principal,Referencia,Graficos,Textos');
$controlPermisos[2]=explode(',','Configuracion,Administracion,Monitor,Principal,Referencia,Graficos,Textos');
$controlPermisos[3]=explode(',','Monitor,Principal,Referencia,Graficos,Textos'); 									///// ANALISTA

$i=0;
$arrayPaginas[$i]['bloque']='CON';
$arrayPaginas[$i]['pagina']='usr_adm/generadorAleatorio.php';
$arrayPaginas[$i]['alias']='Generador Aleatorio';
$i++;
$arrayPaginas[$i]['bloque']='CON';
$arrayPaginas[$i]['pagina']='usr_adm/controlDeVistas.php';
$arrayPaginas[$i]['alias']='Control de Vistas';
$i++;
$arrayPaginas[$i]['bloque']='CON';
$arrayPaginas[$i]['pagina']='usr_adm/controlDePaginas.php';
$arrayPaginas[$i]['alias']='Control de Páginas';
$i++;
$arrayPaginas[$i]['bloque']='MON';
$arrayPaginas[$i]['pagina']='usr_adm/consultas.php';
$arrayPaginas[$i]['alias']='Ejecutar Consultas';
$i++;
$arrayPaginas[$i]['bloque']='PRI';
$arrayPaginas[$i]['pagina']='usr_adm/filtrado_consulta.php';
$arrayPaginas[$i]['alias']='Consulta principal';
$i++;
$arrayPaginas[$i]['bloque']='TEX';
$arrayPaginas[$i]['pagina']='usr_adm/pry_textoIndividual.php';
$arrayPaginas[$i]['alias']='Carga Texto Individual';
$i++;
$arrayPaginas[$i]['bloque']='TEX';
$arrayPaginas[$i]['pagina']='usr_adm/pry_textoValor_tabla.php';
$arrayPaginas[$i]['alias']='Etiquetado';
$i++;
$arrayPaginas[$i]['bloque']='TEX';
$arrayPaginas[$i]['pagina']='usr_adm/pry_frasesClave.php';
$arrayPaginas[$i]['alias']='Frases Clave';
$i++;
$arrayPaginas[$i]['bloque']='TEX';
$arrayPaginas[$i]['pagina']='usr_adm/pry_chatbot.php';
$arrayPaginas[$i]['alias']='Chat Bot';
$i++;
/*
$arrayPaginas[$i]['bloque']='TEX';
$arrayPaginas[$i]['pagina']='usr_adm/pry_textoValor_crear.php';
$arrayPaginas[$i]['alias']='Entrenar Robot';
$i++;
*/
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/gra_unaVariable.php';
$arrayPaginas[$i]['alias']='Una variable';
$i++;
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/gra_dosVariables.php';
$arrayPaginas[$i]['alias']='Dos variables';
$i++;
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/gra_nubeCategorias.php';
$arrayPaginas[$i]['alias']='Nube de Categorías';
$i++;
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/gra_nube.php';
$arrayPaginas[$i]['alias']='Nube de Palabras';
$i++;
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/gra_grafo.php';
$arrayPaginas[$i]['alias']='Mapa Conceptual';
$i++;
$arrayPaginas[$i]['bloque']='GRA';
$arrayPaginas[$i]['pagina']='usr_adm/pry_dashboard.php';
$arrayPaginas[$i]['alias']='Dashboard';
$i++;

foreach ($arrayPaginas as $key => $value) {
	$conteo[$value['bloque']]++;
}

$niv=$_SESSION['fvp']['nivel'];
$sql="SELECT pagina FROM adm_paginaPerfil WHERE idadm_perfil='$niv' ORDER BY pagina ASC";
#echo($sql);
if ($result = $mysqli->query($sql)) {
	$sqlResult=1;
	$sqlRows=0;
	if ($result->num_rows> 0){
		while ($row = $result->fetch_assoc()){
			foreach ($arrayPaginas as $key => $value) {
				if($row['pagina']==$value['pagina']){
					$selectViewLeft[$value['bloque']][]='<li><a class="link-dark rounded" href="'.(substr($value['pagina'],8,1000)).'">'.$value['alias'].'</a></li>';

				}
			}
		}
	}
} 


#array de secciones
$seccion=array();

$tt=count($selectViewLeft['CON'])+$conteo['CON'];
if($tt>0 and in_array('Configuracion', $controlPermisos[$nivelDeUsuario])){
	$seccion['Configuracion']['Titulo'] = "Configuración";
	$seccion['Configuracion']['Datos'][] = $selectViewLeft['CON'];	
};
$tt=count($selectViewLeft['ADM'])+$conteo['ADM'];
if($tt>0 and in_array('Administracion', $controlPermisos[$nivelDeUsuario])){
	$seccion['Administracion']['Titulo'] = "Administración";
	$seccion['Administracion']['Datos'][] = $selectViewLeft['ADM'];	
};
$tt=count($selectViewLeft['IND'])+count($selectViewLeft['MON'])+$conteo['IND']+$conteo['MON'];
if($tt>0 and in_array('Monitor', $controlPermisos[$nivelDeUsuario])){
	$seccion['Monitor']['Titulo'] = "Monitor";
	$seccion['Monitor']['Datos'][] = $selectViewLeft['IND'];
	$seccion['Monitor']['Datos'][] = $selectViewLeft['MON'];	
};
$tt=count($selectViewLeft['REF'])+$conteo['REF'];
if($tt>0 and in_array('Referencia', $controlPermisos[$nivelDeUsuario])){
	$seccion['Referencia']['Titulo'] = "Referencia";
	$seccion['Referencia']['Datos'][] = $selectViewLeft['REF'];
};
$tt=count($selectViewLeft['PRI'])+$conteo['PRI'];
if($tt>0 and in_array('Principal', $controlPermisos[$nivelDeUsuario])){
	$seccion['Principal']['Titulo'] = "Principal";
	$seccion['Principal']['Datos'][] = $selectViewLeft['PRI'];
};
$tt=count($selectViewLeft['GRA'])+$conteo['GRA'];
if($tt>0 and in_array('Graficos', $controlPermisos[$nivelDeUsuario])){
	$seccion['Graficos']['Titulo'] = "Graficos";
	$seccion['Graficos']['Datos'][] = $selectViewLeft['GRA'];
};
$tt=count($selectViewLeft['TEX'])+$conteo['TEX'];
if($tt>0 and in_array('Textos', $controlPermisos[$nivelDeUsuario])){
	$seccion['Textos']['Titulo'] = "Textos";
	$seccion['Textos']['Datos'][] = $selectViewLeft['TEX'];
};


foreach ($seccion as $key => $value) {
	$activo=1;
	foreach ($value['Datos'] as $v) {
		$s[$key]=seccion($key,$seccion[$key],$activo);
	}
}


function seccion($key,$seccion,$activo){
	$titulo=$seccion['Titulo'];
	$z.='<li class="mb-1">';
	$z.='<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#col_'.
	$key.'" aria-expanded="false">';
	$z.=$titulo;
	$z.='</button>';
	$z.='<div class="collapse show" id="col_'.$key.'">';
	$z.='<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">';
	foreach ($seccion['Datos'] as $key => $value) {
		foreach ($value as $key2 => $value2) {
			$z.=$value2;
		}
	}
	$z.='</ul>';
	$z.='</div></li>';
	if($activo){
		return $z;	
	}
}

function bloque($bloque){
	$z='';
	$i=0;
	foreach ($bloque['Datos'] as $key => $value) {
		$i+=count($value);
	}
	return ($i);
}

?>

<div class="flex-shrink-0 p-3 bg-light" style="width: 15%; border-left: 0px; border-bottom: 0px; border-top: 0px;">
	<?
	/*
	echo $_SESSION['fvp']['idUsuario'].' ';
	echo $_SESSION['fvp']['nivel'];
	*/	
	?>

	<ul class="list-unstyled ps-0 scroll">
		<? 
		$cuenta=bloque($seccion['Principal']['Datos']);
		echo $s['Principal']; 

		$cuenta=bloque($seccion['Textos']['Datos']);
		echo $s['Textos']; 

		$cuenta=bloque($seccion['Graficos']['Datos']);
		echo $s['Graficos']; 

		$cuenta=bloque($seccion['Referencia']['Datos']);
		echo $s['Referencia']; 

		$cuenta=bloque($seccion['Monitor']['Datos']);
		echo $s['Monitor']; 

		$cuenta=bloque($seccion['Configuracion']['Datos']);
		echo $s['Configuracion']; 

		$cuenta=bloque($seccion['Administracion']['Datos']);
		echo $s['Administracion']; 
		?>
		<br><br><br><br><br>
	</ul>
</div>

<script type="text/javascript">
	function toggleMisDatos(){
		var span=$("#misDatos");
		var t=span.text();
		if(t=='mis'){
			t='todos los';
		} else {
			t='mis';
		}
		span.text(t);
			$.post("../fn_toggleMisDatos.php", {
				t: t
			})
			.done(function(response){
				location.reload();
			})
			.fail(function() {
			});
	}


</script>


















