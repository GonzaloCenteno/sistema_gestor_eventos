$(document).ready(function () {
    if(aux1==0)
    {
        autocompletar_eventos('buscar_evento');
        aux1=1;
    }
    
    
});


var aux1=0;
    function autocompletar_eventos(textbox){
        $.ajax({
            type: 'GET',
            url: 'autocompletar_eventos',
            success: function (data) {
                var $datos = data;
                $("#buscar_evento").autocomplete({
                    source: $datos,
                    focus: function (event, ui) {
                        $("#" + textbox).val(ui.item.label);
                        $("#hidden" + textbox).val(ui.item.value);
                        $("#" + textbox).attr('maxlength', ui.item.label.length);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#" + textbox).val(ui.item.label);
                        $("#hidden" + textbox).val(ui.item.value);
                        $("#valor").val(ui.item.precio);

                        return false;
                    }
                });
            }
        });
    }
    
cont = 0;
detalle_total = 0;
function detalle_recibo_eventos() {
    val_soles = parseFloat($("#valor").val()) || 0.00;
    cantidad = parseFloat($("#cantidad").val());
    evento = $("#buscar_evento").val();
    id_evento = $("#hiddenbuscar_evento").val();
    
    if (id_evento == "0") {
        mostraralertasconfoco('Ingrese Nombre Evento...', '#buscar_evento');
        return false;
    }
    
    if (isNaN(cantidad)) {
        mostraralertasconfoco('Ingrese Cantidad...', '#cantidad');
        return false;
    }
    
    total = val_soles * cantidad;

    cont++;
    $('#t_dina_det_recibo').append(
            "<tr>\n\
            <td>" + cont + "</td>\n\
            <td><label class='input'>\n\
            <input id='id_evento_" + cont + "' type='hidden' value='" + id_evento + "'>\n\
            <input id='glosa_din_" + cont + "' type='text' value='" + (evento).toUpperCase() + "' disabled='' class='input-xs'></label></td>\n\
            <td><label class='input'><input id='sub_tot_din_" + cont + "' type='text' value='" + formato_numero(total, 2, '.', '') + "' disabled='' class='input-xs text-align-right' style='font-size:12px'></label></td>\n\
            <td align='center'><button onclick='btn_borrar_detalle(" + cont + ");' class='btn_din' id='btn_eliminar_din_" + cont + "' title='Eliminar'> <img src='img/trash.png' style='width:19px' ></img></button></td>\n\
        </tr>"
            );

    detalle_total = (detalle_total + total);
    $("#vw_em_rec_txt_detalle_total").val(formato_numero(detalle_total, 3, '.', ','));
    for (i = 1; i <= cont; i++) {
        if (i == cont) {
            $("#btn_eliminar_din_" + i).show();
        } else {
            $("#btn_eliminar_din_" + i).hide();
        }
    }
}

function btn_borrar_detalle(num) {
    cont--;
    ultimo_soles = $("#sub_tot_din_" + num).val();
    ultimo_soles = ultimo_soles.replace(',', '');

    detalle_total = (detalle_total - ultimo_soles);
    $("#vw_em_rec_txt_detalle_total").val(formato_numero(detalle_total, 2, '.', ','));
    document.getElementById("t_dina_det_recibo").deleteRow(num);
    $("#btn_eliminar_din_" + cont).show();
}


function grabar_datos(){
    monto = parseFloat($("#valor").val());
    cantidad = parseFloat($("#cantidad").val());
    evento = $("#buscar_evento").val();
    id_evento = $("#hiddenbuscar_evento").val();
    
    if (id_evento == "0") {
        mostraralertasconfoco('Ingrese Nombre Evento...', '#buscar_evento');
        return false;
    }
    
    if (isNaN(cantidad)) {
        mostraralertasconfoco('Ingrese Cantidad...', '#cantidad');
        return false;
    }
    
    if (monto == "") {
        mostraralertasconfoco('Ingrese Nombre Evento...', '#valor');
        return false;
    }
    
    if (evento == "0") {
        mostraralertasconfoco('Ingrese Nombre Evento...', '#buscar_evento');
        return false;
    }
    
    $.ajax({
        url: 'insertar_datos_recibo',
        type: 'GET',
        data: {
            monto: monto
        },
        success: function (data) {
            if (data) {
                registrar_inscripcion(data);
            }
        },
        error: function (data) {
            return false;
        }
    });
}



function registrar_inscripcion(id_recibo) {

    for (i = 1; i <= cont; i++) {
        btn_insert_detalle(i, id_recibo);
        console.log(i);
    }
    swal({
        position: 'top-end',
        type: 'success',
        title: 'TU PETICION FUE CREADA SATISFACTORIAMENTE',
        showConfirmButton: false,
        timer: 1500
      });
      var audio = document.getElementById("audio_smallbox");
      audio.play();
      limpiar_datos();
}

function btn_insert_detalle(num, id_recibo) {
    $.ajax({
        url: 'insertar_datos_inscripcion',
        type: 'GET',
        data: {
            id_evento: $("#id_evento_" + num).val(),
            monto: $("#sub_tot_din_" + num).val(),
            id_recibo:id_recibo
        },
        success: function (data) {
            if (data) {
                return true;
            }
        },
        error: function (data) {
            return false;
        }
    });
}

function limpiar_datos(){
    $("#valor").val('');
    $("#cantidad").val('');
    $("#buscar_evento").val('');
    $("#hiddenbuscar_evento").val('');
    $("#tabla_detalle").empty()
}