async function postData(url = url, data = {}) {
	const response = await fetch(url, {
		method: 'POST', 
		mode: 'cors', 
		cache: 'no-cache', 
		credentials: 'same-origin', 
		headers: {
			'Content-Type': 'application/json'
		},
		redirect: 'follow', 
		referrerPolicy: 'no-referrer', 
		body: JSON.stringify(data)
	});
	return response.json();
}
async function getData(url = '', params = {}) {
    // Convertir los parámetros en una cadena de consulta
    const queryString = new URLSearchParams(params).toString();
    const fullUrl = queryString ? `${url}?${queryString}` : url;
    const response = await fetch(fullUrl, {
        method: 'GET', 
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer'
    });
    return response.json();
}
function creaSelect(id,data,todos){
	$('#' + id).empty();
	if(todos==1){
		$('#' + id).append($('<option>', {
			value: 0,
			text: 'TODOS'
		}));
	}
	$.each(data, function(index, valor) {
		$('#' + id).append($('<option>', {
			value: valor.value, 
			text: valor.text
		}));
	});
}
function selProyecto(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaProyectos";
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="proyecto";
		creaSelect(id,data);
		selSeguimiento();
	});
};
function selFrecuentes(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaFrecuentes";
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="frecuentes";
		creaSelect(id,data,1);
		creaSalida();
	});
};
function selSeguimiento(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaSeguimientos";
	argumentos['idaaa_proyecto']=$("#proyecto").val();
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="seguimiento";
		creaSelect(id,data);
		selFrecuentes();
		selVariable()
	});
}
function selVariable(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaVariables";
	argumentos['idaaa_seguimiento']=$("#seguimiento").val();
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="variable";
		creaSelect(id,data);
		selValor();
	});
}
function selValor(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaValores";
	argumentos['idaaa_variable']=$("#variable").val();
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="valor";
		creaSelect(id,data,1);
		creaSalida();
	});
}
function selItem(){
	var id;
	var valor;
	argumentos={};
	argumentos['funcionLlamada']="cargaItems";
	argumentos['idaaa_seguimiento']=$("#seguimiento").val();
	postData('pry_funciones.php', { 
		argumentos:argumentos
	})
	.then(data => {
		id="valor";
		creaSelect(id,data,1);
		creaSalida();
	});
}
function l(variable){ console.log(variable); }

