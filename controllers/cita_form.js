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
    $.ajax({
        method: "POST",
        url: "sw_cita.php",
        data:{
            action: "insert",
            fecha: $('#fechaInsertar').val(),
            medico_id: $('#medico_idInsertar').val(),
            enfermero_id: $('#enfermero_idInsertar').val(),
            paciente_id: $('#paciente_idInsertar').val(),
        },
        dataType:"json"
    })
        .done(function (response) {
            if(response.success){
                alert("Cita Insertada Correctamente")
            }else{
                alert("Error Al Insertar la Cita")
            }
        })
}

function borrar(id){
    if (window.confirm("¿Estas seguro?")) {
        $.ajax({
            method: "POST",
            url: "sw_cita.php",
            data: {
                action: "delete",
                id: id
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Cita Eliminada Correctamente"),
                    llamada();
                }else{
                    alert("Error Al Eliminar la Cita");
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
            url: "sw_cita.php",
            data: {
                action: "update",
                id: recogerParams("id"),
                fecha: $('#fechaInsertar').val(),
                medico_id: $('#medico_idInsertar').val(),
                enfermero_id: $('#enfermero_idInsertar').val(),
                paciente_id: $('#paciente_idInsertar').val(),
            },
            dataType: "json"
        })
            .done(function (response) {
                if(response.success){
                    alert("Cita Modificada Correctamente")
                }else{
                    alert("Error Al Modificar la Cita")
                }
            })
    }
}

$(document).ready(function () {
    var idParam = recogerParams("id");
    if (idParam !== false) {
        $.ajax({
            method: 'POST',
            url: 'sw_cita.php',
            action: 'get',
            data: {
                id: recogerParams('id')
            },
            dataType: 'json'
        })
            .done(function(response) {
                $('#fechaInsertar').val(response.data[0].fecha);
                $('#medico_idInsertar').val(response.data[0].medico_id);
                $('#enfermero_idInsertar').val(response.data[0].enfermero_id);
                $( '#paciente_idInsertar').val(response.data[0].paciente_id);
            });
    }

    $('#volver').click(function () {
        window.location.href= "cita_list.html";
    });

    $('#insertar').click(function (){
        insertar();
    });

    $('#modificar').click(function (){
        modificar();
    });

});
