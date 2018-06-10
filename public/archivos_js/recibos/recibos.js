
$(document).ready(function () {
    $("#li_config_recibos").addClass('active');
    $("#menu_caja").addClass('open');
    $("#menu_caja").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Recibos").jqGrid({
        url: 'getRecibos',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['Nº Recibo', 'Persona', 'Concepto', 'Total', 'Tipo', 'Paquete', 'Estado'],
        rowNum: 10, sortname: 'numero_recibo', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE RECIBOS REGISTRADOS', align: "center",
        colModel: [
            {name: 'numero_recibo', index: 'numero_recibo', width: 20},
            {name: 'name', index: 'name', align: 'center', width: 100},
            {name: 'concepto', index: 'concepto', align: 'center', width: 50},
            {name: 'monto_total', index: 'monto_total', align: 'center', width: 20},
            {name: 'tipo_recibo', index: 'tipo_recibo', align: 'center', width: 50},
            {name: 'tipo_paquete', index: 'tipo_paquete', align: 'center', width: 50},
            {name: 'nuevo', index: 'nuevo', align: 'center', width: 40},
            
        ],
        pager: '#pager_table_Recibos',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Recibos').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Recibos').jqGrid('getDataIDs')[0];
                            $("#table_Recibos").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_material();
        }
    });

    $("#vw_buscar_materiales").keypress(function (e) {
            if (e.which == 13) {
                buscar_materiales();
            }
    });

});

var aux2=0;
function autocompletar_nombre(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_nombre_persona',
        success: function (data) {
            var $datos = data;
            $("#persona").autocomplete({
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
                    
                    return false;
                }
            });
        }
    });
}

function limpiar_formulario() {
    $("#persona").val('');
    $("#dlg_concepto").val('');
    $("#dlg_monto").val('');
    $("#dlg_tipo").val('');
    $("#dlg_paquete").val('');
}


function nuevo_recibo() {
    $("#dialog_nuevo_recibo").dialog({
        autoOpen: false, modal: true, width: 620, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO RECIBO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_recibo(1);
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

    if(aux2==0)
    {
        autocompletar_nombre('persona');
        aux2=1;
    }
}

function guardar_editar_recibo(tipo) {

    id_persona = $("#hiddenpersona").val();
    persona = $("#persona").val();
    concepto = $("#dlg_concepto").val();
    monto = $("#dlg_monto").val();
    tipo_recibo = $("#dlg_tipo").val();
    tipo_paquete = $("#dlg_paquete").val();

    if(persona == "")
    {
        mostraralertasconfoco("* El Campo Persona es Obligatorio","#persona");
        return false;
    }

    if(concepto == "")
    {
        mostraralertasconfoco("* El Campo Concepto Material es Obligatorio","#dlg_concepto");
        return false;
    }

    if(monto == "")
    {
        mostraralertasconfoco("* El Campo Monto Break Mañana es Obligatorio","#dlg_monto");
        return false;
    }

    if(tipo_recibo == "")
    {
        mostraralertasconfoco("* El Campo Tipo Recibo Tarde es Obligatorio","#dlg_tipo");
        return false;
    }

    if(tipo_paquete == "")
    {
        mostraralertasconfoco("* El Campo Tipo Paquete Tarde es Obligatorio","#dlg_paquete");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Recibos', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'recibos/create',
            type: 'GET',
            data: {
                id_persona:id_persona,
                concepto:concepto,
                monto:monto,
                tipo_recibo:tipo_recibo,
                tipo_paquete:tipo_paquete
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Recibos');
                fn_actualizar_grilla('table_Recibos');
                $("#dialog_nuevo_recibo").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Recibos');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {

        id_material = $("#dlg_id_material").val();

        MensajeDialogLoadAjax('table_Materiales', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'materiales/'+id_material+'/edit',
            type: 'GET',
            data: {
                id_persona:id_persona,
                tipo_materiales:tipo_materiales,
                break_man:break_man,
                break_tard:break_tard
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Materiales');
                fn_actualizar_grilla('table_Materiales');
                $("#dialog_nuevo_material").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Materiales');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_material()
{
    id_material = $('#table_Materiales').jqGrid ('getGridParam', 'selrow');

    if (id_material) {

        $("#dialog_nuevo_material").dialog({
            autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR MATERIAL :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_material(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nuevo_material").dialog('open');


        MensajeDialogLoadAjax('dialog_nuevo_material', '.:: Cargando ...');

        $.ajax({url: 'materiales/'+id_material,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_material").val(datos[0].id_material);
                $("#hiddenpersona").val(datos[0].id_persona);
                $("#persona").val(datos[0].name);
                $("#dlg_tipo_material").val(datos[0].tipo_materiales);
                $("#dlg_break_man").val(datos[0].break_man);
                $("#dlg_break_tar").val(datos[0].break_tard);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_material');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_material');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Materiales");
    }
}

function eliminar_material(){
    id_material = $('#table_Materiales').jqGrid ('getGridParam', 'selrow');

    if(id_material == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Materiales");
        return false;
    }

    swal({
          title: '¿Está Seguro que desea Eliminar El Material?',
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
              fn_elimiar_material();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_material() {
    id_material = $('#table_Materiales').jqGrid ('getGridParam', 'selrow');

    $.ajax({
        url: 'materiales/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_materiales_eliminar").data('token'),id_material: id_material},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Materiales');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_materiales(){
    materiales = $("#vw_buscar_materiales").val();
    fn_actualizar_grilla('table_Materiales','getMateriales?materiales='+materiales);
}