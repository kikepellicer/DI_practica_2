var paginasTotales;
var personasTotales;

function llamada(){
    $.ajax({
        method: "POST",
        url: "sw_cita.php",
        data:{
            action:"get",
            id: $( '#idFiltroCita' ).val(),
            fecha: $( '#fechaFiltroCita' ).val(),
            medico_id: $( '#medico_idFiltroCita' ).val(),
            enfermero_id: $( '#enfermero_idFiltroCita' ).val(),
            paciente_id: $( '#paciente_idFiltroCita' ).val(),
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
                    if (response.data[i].medico_id == null) {
                        response.data[i].medico_id = "No Tiene Medico Asignado";
                    }

                    if (response.data[i].enfermero_id == null) {
                        response.data[i].enfermero_id = "No Tiene Enfermero Asignado";
                    }

                    if (response.data[i].paciente_id == null) {
                        response.data[i].paciente_id = "No Tiene Paciente Asignado";
                    }

                    $("table tbody").append("<tr>" +
                        "<td>"+response.data[i].id+"</td>" +
                        "<td>"+response.data[i].fecha+"</td>" +
                        "<td>"+response.data[i].medico_id+"</td>" +
                        "<td>"+response.data[i].enfermero_id+"</td>" +
                        "<td>"+response.data[i].paciente_id+"</td>" +
                        "<td><input type='button' value='Editar'name='Editar' onclick=location.href='cita_form.html?id="+response.data[i].id+"'></td>" +
                        "<td><input type='button' value='Eliminar'name='Borrar' id='eliminar' onclick='borrar("+response.data[i].id+")'></td>"+
                        "</tr>");
                }
                $( '#paginas_totales' ).append(paginasTotales);
                $( '#registros_totales' ).append(personasTotales);
            }
        });
}

$(document).ready(function(){
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
        $( '#idFiltroCita' ).val("");
        $( '#fechaFiltroCita' ).val("");
        $( '#medico_idFiltroCita' ).val("");
        $( '#enfermero_idFiltroCita' ).val("");
        $( '#paciente_idFiltroCita' ).val("");
        $('#pagina').val('1');
        llamada();
    });

    $('#insertarBoton').click(function(){
        window.location.href = "cita_form.html";
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