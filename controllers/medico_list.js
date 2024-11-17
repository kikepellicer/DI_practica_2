var paginasTotales;
var personasTotales;

function llamada(){
	$.ajax({
		method: "POST",
		url: "sw_medico.php",
		data:{
			//Todo lo que le enviamos
			action:"get",
			id: $( '#idFiltro' ).val(),
			dni: $( '#dniFiltro' ).val(),
			numero_colegiado: $( '#numero_colegiadoFiltro' ).val(),
			nombre: $( '#nombreFiltro' ).val(),
			apellido1: $( '#apellido1Filtro' ).val(),
			apellido2: $( '#apellido2Filtro' ).val(),
			telefono: $( '#telefonoFiltro').val(),
			sexo: $( '#sexoFiltro' ).val(),
			especialidad_id: $( '#especialidad_idFiltro' ).val(),
			pagina: $( '#pagina' ).val(),
			numeros_personas: $( '#numeros_personas').val(),
		},
		//Para parsear el JSON a array de objetos
		dataType:"json",
	})
		.done(function (response){
			if(response.success){
			personasTotales=response.registros[0].registrosTotales;
			paginasTotales= Math.ceil(personasTotales/$( '#numeros_personas').val());
			console.log(paginasTotales);
			$("table tbody").empty();
			$('#paginas_totales').empty();
			$('#registros_totales').empty();
			for (i=0; i<response.data.length; i++) {
				$("table tbody").append("<tr>" +
					"<td>"+response.data[i].id+"</td>" +
					"<td>"+response.data[i].dni+"</td>" +
					"<td>"+response.data[i].numero_colegiado+"</td>" +
					"<td>"+response.data[i].nombre+"</td>" +
					"<td>"+response.data[i].apellido1+"</td>" +
					"<td>"+response.data[i].apellido2+"</td>" +
					"<td>"+response.data[i].telefono+"</td>" +
					"<td>"+response.data[i].sexo+"</td>" +
					"<td>"+response.data[i].especialidad_id+"</td>" +
					"<td><input type='button' value='Editar'name='Editar' onclick=location.href='medico_form.html?id="+response.data[i].id+"'></td>" +
					"<td><input type='button' value='Eliminar'name='Borrar' id='eliminar' onclick='borrar("+response.data[i].id+")'></td>"+
					"</tr>");
			}
				$( '#paginas_totales' ).append(paginasTotales);
				$( '#registros_totales' ).append(personasTotales);
		}
	});
}

$(document).ready(function(){
	$( '#pagina' ).val("1");
	llamada();

	$('#numeros_personas').click(function(){
		$('#pagina').val('1');
		llamada();
	});

	$('#principio').click(function(){
		$('#pagina').val('1');
		llamada();
	});

	$('#siguiente').click(function(){
		if($('#pagina').val()  < paginasTotales && $('#pagina').val() >= 1 ) {
			let suma_pagina = parseInt($('#pagina').val()) + 1;
			$('#pagina').val(suma_pagina);
			llamada();
		}
	});

	$('#atras').click(function () {
		if($('#pagina').val() > 1 && $('#pagina').val() <= paginasTotales){
			let atras_pagina = parseInt($('#pagina').val()) - 1;
			$('#pagina').val(atras_pagina);
			llamada();
		}
	});

	$('#final').click(function () {
		let pagTotal= paginasTotales;
		$('#pagina').val(pagTotal);
		llamada();
	});

	$('#enviar').click(function () {
		$('#pagina').val('1');
		llamada();
	});

	$('#limpiar').click(function(){
		$( '#idFiltro' ).val("");
		$( '#dniFiltro' ).val("");
		$( '#numero_colegiadoFiltro' ).val("");
		$( '#nombreFiltro' ).val("");
		$( '#apellido1Filtro' ).val("");
		$( '#apellido2Filtro' ).val("");
		$( '#telefonoFiltro').val("");
		$( '#sexoFiltro' ).val("");
		$( '#especialidad_idFiltro').val("");
		$('#pagina').val('1');
		llamada();
	});

	$('#insertarBoton').click(function(){
		window.location.href = "medico_form.html";
	});

	$('#medicos').click(function(){
		window.location.href = "medico_list.html";
	});

	$('#pacientes').click(function(){
		window.location.href = "paciente_list.html";
	});

	$('#citas').click(function(){
		window.location.href = "cita_list.html";
	});
});

