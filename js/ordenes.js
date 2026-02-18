/* Copyright 2017 Rafael San José Tovar (http://www.rsanjoseo.com) */

var puedoCerrar = false;
var idleTime = 0;

/* Indique en timerIncrement el tiempo para desconectar y la URL de logout */
function timerIncrement() {
    idleTime++;
    if (idleTime >= 5) { // Tiempo en minutos
        window.location = "http://localhost/protesis/auth/logout";
    }
}

function permitirCerrar() {
    puedoCerrar = true;
}

function iCanClose() {
    if (!puedoCerrar) {
        return 'No ha guardado los cambios. Use guardar, cancelar o finalizar';
    }
}

function actualizar() {
    $('.xsf').each(function (index, item) {
        $("#g" + $(item).attr('id')).css('display', $(item).prop('checked') ? '' : 'none');
    });
}

$(document).ready(function ($) {
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minuto

    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });

    //ocultarsubfamilias();
    actualizar();
});

