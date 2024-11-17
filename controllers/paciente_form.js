function recogerParams(nombreParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName;

    for (var i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === nombreParam) {
            return sParameterName[1];
        }
    }

    return false;
};

function insertar(){
    if (window.confirm("¿Estas seguro?")) {
        $.ajax({
            method: "POST",
            url: "sw_paciente.php",
            data: {
                action: "insert",
                sip: $('#sipInsertarPaciente').val(),
                dni: $('#dniInsertarPaciente').val(),
                nombre: $('#nombreInsertarPaciente').val(),
                apellido1: $('#apellido1InsertarPaciente').val(),
                apellido2: $('#apellido2InsertarPaciente').val(),
                telefono: $('#telefonoInsertarPaciente').val(),
                sexo: $('#sexoInsertarPaciente').val(),
                fecha: $('#fechaInsertarPaciente').val(),
                localidad: $('#localidadInsertarPaciente').val(),
                calle: $('#calleInsertarPaciente').val(),
                numero: $('#numeroInsertarPaciente').val(),
                puerta: $('#puertaInsertarPaciente').val(),
                piso: $('#pisoInsertarPaciente').val(),
            },
            dataType: "json"
        })
            .done(function(response){
                if(response.success){
                    alert("Paciente Insertado Correctamente")
                }else{
                    alert("Error Al Insertar el Paciente")
                }
            })
    }
}

function borrar(id){
    if (window.confirm("¿Estas seguro?")) {
        $.ajax({
            method: "POST",
            url: "sw_paciente.php",
            data: {
                action: "delete",
                id: id
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Paciente Eliminado Correctamente");
                    llamada();
                }else{
                    alert("Error Al Eliminar el Paciente");
                }
            })

            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Ha ocurrido un error" + errorThrown);
            });
    }
}

function modificar() {
    if (window.confirm("¿Estas seguro de modificarlo?")) {
        $.ajax({
            method: 'POST',
            url: "sw_paciente.php",
            data: {
                action: "update",
                id: recogerParams("id"),
                sip: $('#sipInsertarPaciente').val(),
                dni: $('#dniInsertarPaciente').val(),
                nombre: $('#nombreInsertarPaciente').val(),
                apellido1: $('#apellido1InsertarPaciente').val(),
                apellido2: $('#apellido2InsertarPaciente').val(),
                telefono: $('#telefonoInsertarPaciente').val(),
                sexo: $('#sexoInsertarPaciente').val(),
                fecha: $( '#fechaInsertarPaciente' ).val(),
                localidad: $('#localidadInsertarPaciente').val(),
                calle: $( '#calleInsertarPaciente' ).val(),
                numero: $( '#numeroInsertarPaciente' ).val(),
                puerta: $( '#puertaInsertarPaciente' ).val(),
                piso: $( '#pisoInsertarPaciente' ).val(),
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Paciente Modificado Correctamente")
                }else{
                    alert("Error Al Modificar el Paciente")
                }
            })
    }
}

$(document).ready(function () {
    var idParam = recogerParams("id");
    if (idParam !== false) {
        $.ajax({
            method: 'POST',
            url: 'sw_paciente.php',
            action: 'get',
            data: {
                id: recogerParams('id')
            },
            dataType: 'json'
        })
            .done(function(response) {
                $( '#sipInsertarPaciente' ).val(response.data[0].sip);
                $( '#dniInsertarPaciente' ).val(response.data[0].dni);
                $( '#nombreInsertarPaciente' ).val(response.data[0].nombre);
                $( '#apellido1InsertarPaciente').val(response.data[0].apellido1);
                $( '#apellido2InsertarPaciente').val(response.data[0].apellido2);
                $( '#telefonoInsertarPaciente').val(response.data[0].telefono);
                $( '#sexoInsertarPaciente').val(response.data[0].sexo);
                $( '#fechaInsertarPaciente' ).val(response.data[0].fecha_nacimiento);
                $( '#localidadInsertarPaciente' ).val(response.data[0].localidad);
                $( '#calleInsertarPaciente' ).val(response.data[0].calle);
                $( '#numeroInsertarPaciente' ).val(response.data[0].numero);
                $( '#puertaInsertarPaciente' ).val(response.data[0].puerta);
                $( '#pisoInsertarPaciente' ).val(response.data[0].piso);
            });
    }

    $('#volver').click(function () {
        window.location.href= "paciente_list.html";
    });

    $('#insertar').click(function (){
        insertar();
    });

    $('#modificar').click(function (){
        modificar();
    });

});
