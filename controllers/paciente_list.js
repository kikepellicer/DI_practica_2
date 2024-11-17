var paginasTotales;
var personasTotales;
function llamada(){
    $.ajax({
        method: "POST",
        url: "sw_paciente.php",
        data:{
            action:"get",
            id: $( '#idFiltroPaciente' ).val(),
            sip: $( '#sipFiltroPaciente' ).val(),
            dni: $( '#dniFiltroPaciente' ).val(),
            nombre: $( '#nombreFiltroPaciente' ).val(),
            apellido1: $( '#apellido1FiltroPaciente' ).val(),
            apellido2: $( '#apellido2FiltroPaciente' ).val(),
            telefono: $( '#telefonoFiltroPaciente').val(),
            sexo: $( '#sexoFiltroPaciente' ).val(),
            fecha: $( '#fechaFiltroPaciente').val(),
            localidad: $( '#localidadFiltroPaciente' ).val(),
            calle: $( '#calleFiltroPaciente' ).val(),
            numero: $( '#numeroFiltroPaciente' ).val(),
            puerta: $( '#puertaFiltroPaciente' ).val(),
            piso: $( '#pisoFiltroPaciente' ).val(),
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
                        "<td>"+response.data[i].sip+"</td>" +
                        "<td>"+response.data[i].dni+"</td>" +
                        "<td>"+response.data[i].nombre+"</td>" +
                        "<td>"+response.data[i].apellido1+"</td>" +
                        "<td>"+response.data[i].apellido2+"</td>" +
                        "<td>"+response.data[i].telefono+"</td>" +
                        "<td>"+response.data[i].sexo+"</td>" +
                        "<td>"+response.data[i].fecha_nacimiento+"</td>" +
                        "<td>"+response.data[i].localidad+"</td>" +
                        "<td>"+response.data[i].calle+"</td>" +
                        "<td>"+response.data[i].numero+"</td>" +
                        "<td>"+response.data[i].puerta+"</td>" +
                        "<td>"+response.data[i].piso+"</td>" +
                        "<td><input type='button' value='Editar'name='Editar' onclick=location.href='paciente_form.html?id="+response.data[i].id+"'></td>" +
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

    $('#enviarPaciente').click(function () {
        $('#pagina').val('1');
        llamada();
    });

    $('#limpiarPaciente').click(function(){
        $( '#idFiltroPaciente').val("");
        $( '#sipFiltroPaciente' ).val("");
        $( '#dniFiltroPaciente' ).val("");
        $( '#nombreFiltroPaciente' ).val("");
        $( '#apellido1FiltroPaciente' ).val("");
        $( '#apellido2FiltroPaciente' ).val("");
        $( '#telefonoFiltroPaciente').val("");
        $( '#sexoFiltroPaciente' ).val("");
        $( '#fechaFiltroPaciente').val("")
        $( '#localidadFiltroPaciente').val("");
        $( '#calleFiltroPaciente' ).val("");
        $( '#numeroFiltroPaciente' ).val("");
        $( '#puertaFiltroPaciente' ).val("");
        $( '#pisoFiltroPaciente' ).val("");
        $('#pagina').val('1');
        llamada();
    });

    $('#insertarBotonPaciente').click(function(){
        window.location.href = "paciente_form.html";
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

