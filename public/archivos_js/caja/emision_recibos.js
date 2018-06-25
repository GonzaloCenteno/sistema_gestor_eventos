
$(document).ready(function () {
    $("#li_config_emision_recibos").addClass('active');
    $("#menu_caja").addClass('open');
    $("#menu_caja").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_emision_recibos").jqGrid({
        url: 'getRecibosProductos',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'Nº RECIBO', 'PERSONA', 'CONCEPTO', 'MONTO TOTAL', 'FECHA REGISTRO', 'ESTADO'],
        rowNum: 10, sortname: 'id_recibo', sortorder: 'desc', viewrecords: true, caption: 'RECIBOS EMITIDOS PARA PRODUCTOS', align: "center",
        colModel: [
            {name: 'id_recibo', index: 'id_recibo', hidden: true},
            {name: 'nro_recibo', index: 'nro_recibo', align: 'center', width: 20},
            {name: 'nombre_persona', index: 'nombre_persona', align: 'center', width: 100},
            {name: 'concepto', index: 'concepto', align: 'center', width: 100},
            {name: 'monto_total', index: 'monto_total', align: 'center', width: 30},
            {name: 'fecha_registro', index: 'fecha_registro', align: 'center', width: 30},
            {name: 'estado', index: 'estado', align: 'center', width: 30, hidden: true}
        ],
        pager: '#pager_table_emision_recibos',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_emision_recibos').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_emision_recibos').jqGrid('getDataIDs')[0];
                            $("#table_emision_recibos").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            estado = $('#table_emision_recibos').jqGrid ('getCell', Id, 'estado');
            if (estado == 0) {
                anular_recibo_producto();
            }else if (estado == 1){
                 mostraralertasconfoco("El Recibo Ya fue Pagado");
            }else{
                mostraralertasconfoco("El Recibo Ya fue Anulado");
            }
            
        }
    });

    $("#vw_buscar_productos").keypress(function (e) {
            if (e.which == 13) {
                buscar_recibo_productos();
            }
    });

});


var aux1_producto=0;
function autocompletar_productos(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_productos',
        success: function (data) {
            var $datos = data;
            $("#dlg_concepto").autocomplete({
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
                    $("#dlg_monto").val(ui.item.precio);

                    return false;
                }
            });
        }
    });
}
    

function limpiar_formulario() {
    $("#dlg_nombre_persona").val('');
    $("#dlg_concepto").val('');
    $("#dlg_monto_total").val('');
    $("#dlg_monto").val('');
    $("#dlg_cantidad").val('');
}


function nueva_emision_recibo() {
    $("#dialog_nuevo_emision_recibo").dialog({
        autoOpen: false, modal: true, width: 650, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: EMISION RECIBO - PRODUCTO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_emision_recibo();
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        close: function (event, ui) {
            limpiar_formulario();
        },
        open: function () {
            limpiar_formulario();
        }
    }).dialog('open');
    
    if(aux1_producto==0)
    {
        autocompletar_productos('dlg_concepto');
        aux1_producto=1;
    }
}

function guardar_emision_recibo() 
{

    persona = $("#dlg_nombre_persona").val();
    concepto = $("#dlg_concepto").val();
    monto_total = $("#dlg_monto_total").val();
   
    
    if(persona == "")
    {
        mostraralertasconfoco("* El Campo Nombre Persona es Obligatorio","#dlg_nombre_persona");
        return false;
    }

    if(concepto == "")
    {
        mostraralertasconfoco("* El Campo Producto es Obligatorio","#dlg_concepto");
        return false;
    }
    
    if(monto_total == "")
    {
        mostraralertasconfoco("* El Campo Monto Total es Obligatorio","#dlg_monto_total");
        return false;
    }


    MensajeDialogLoadAjax('table_emision_recibos', '.:: Cargando ...');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'emision_recibos/create',
        type: 'GET',
        data: {
            persona:persona,
            concepto:concepto,
            monto_total:monto_total
        },
        success: function(r) 
        {
            MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('table_emision_recibos');
            fn_actualizar_grilla('table_emision_recibos');
            $("#dialog_nuevo_emision_recibo").dialog("close");
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('table_emision_recibos');
            console.log('error');
            console.log(data);
        }
    });
}


function anular_recibo_producto(){
    id_recibo = $('#table_emision_recibos').jqGrid ('getGridParam', 'selrow');
    
    if(id_recibo == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_emision_recibos");
        return false;
    }
    
    nro_recibo = $('#table_emision_recibos').jqGrid ('getCell', id_recibo, 'nro_recibo');
    
    swal({
          title: '¿Está Seguro que desea Anular El Recibo ' + nro_recibo + ' ?',
          text: "Los Cambios no se podran revertir!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ACEPTAR',
          cancelButtonText: 'CANCELAR',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then(function(result) {
              fn_anular_recibo_producto();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_anular_recibo_producto() {
    id_recibo = $('#table_emision_recibos').jqGrid ('getGridParam', 'selrow');
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'emision_recibos/'+id_recibo+'/edit',
        type: 'GET',
        data: {
            id_recibo: id_recibo
        },
        success: function (data) {
            MensajeAlerta("Se Anulo Correctamente","Su Registro Fue Anulado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_emision_recibos');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_recibo_productos(){
    productos = $("#vw_buscar_productos").val();
    fn_actualizar_grilla('table_emision_recibos','getRecibosProductos?productos='+productos);
}

function calcualar_total(){
    monto = parseFloat($("#dlg_monto").val()) || 0.00;
    cantidad = parseFloat($("#dlg_cantidad").val());
    monto = $("#dlg_monto").val();
    
    if (monto == "") {
        mostraralertasconfoco('Ingrese Monto a Calcular...', '#dlg_monto');
        return false;
    }
    
    if (isNaN(cantidad)) {
        mostraralertasconfoco('Ingrese Cantidad...', '#dlg_cantidad');
        return false;
    }
    
    total = monto * cantidad;
    
    $("#dlg_monto_total").val(total);
}