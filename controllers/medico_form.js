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

function insertar() {
    if (window.confirm("¿Estas Seguro?")) {
        $.ajax({
            method: "POST",
            url: "sw_medico.php",
            data: {
                action: "insert",
                numero_colegiado: $('#numero_colegiadoInsertar').val(),
                dni: $('#dniInsertar').val(),
                nombre: $('#nombreInsertar').val(),
                apellido1: $('#apellido1Insertar').val(),
                apellido2: $('#apellido2Insertar').val(),
                telefono: $('#telefonoInsertar').val(),
                sexo: $('#sexoInsertar').val(),
                especialidad_id: $('#especialidad_idInsertar').val(),
            },
            dataType: "json"
        })
            .done(function (response) {
                if (response.success) {
                    alert("Medico Insertado Correctamente")
                } else {
                    alert("Error Al Insertar el Medico")
                }
            })
    }
}

function borrar(id){
    if (window.confirm("¿Estas seguro?")) {
        $.ajax({
            method: "POST",
            url: "sw_medico.php",
            data: {
                action: "delete",
                id: id
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Medico Eliminado Correctamente")
                    llamada();
                }else{
                    alert("Error Al Eliminar el Medico")
                }
            })
    }
}

function modificar() {
    if (window.confirm("¿Estas seguro de modificarlo?")) {
        $.ajax({
            method: 'POST',
            url: "sw_medico.php",
            data: {
                action: "update",
                id: recogerParams("id"),
                numero_colegiado: $('#numero_colegiadoInsertar').val(),
                dni: $('#dniInsertar').val(),
                nombre: $('#nombreInsertar').val(),
                apellido1: $('#apellido1Insertar').val(),
                apellido2: $('#apellido2Insertar').val(),
                telefono: $('#telefonoInsertar').val(),
                sexo: $('#sexoInsertar').val(),
                especialidad_id: $('#especialidad_idInsertar').val(),
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Medico Modificado Correctamente")
                }else{
                    alert("Error Al Modificar el Medico")
                }
            })
    }
}

$(document).ready(function () {
    var idParam = recogerParams("id");
    if (idParam !== false) {
        $.ajax({
            method: 'POST',
            url: 'sw_medico.php',
            action: 'get',
            data: {
                id: recogerParams('id')
            },
            dataType: 'json'
        })
            .done(function(response) {
                $('#numero_colegiadoInsertar').val(response.data[0].numero_colegiado);
                $('#dniInsertar').val(response.data[0].dni);
                $('#nombreInsertar').val(response.data[0].nombre);
                $( '#apellido1Insertar').val(response.data[0].apellido1);
                $( '#apellido2Insertar').val(response.data[0].apellido2);
                $( '#telefonoInsertar').val(response.data[0].telefono);
                $( '#sexoInsertar').val(response.data[0].sexo);
                $( '#especialidad_idInsertar' ).val(response.data[0].especialidad_id);
            });
    }

    $('#volver').click(function () {
        window.location.href= "medico_list.html";
    });

    $('#insertar').click(function (){
        insertar();
    });

    $('#modificar').click(function (){
        modificar();
    });

});
