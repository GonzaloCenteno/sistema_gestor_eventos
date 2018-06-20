
$(document).ready(function () {
    $("#li_config_turno").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Turnos").jqGrid({
        url: 'getTurnos',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'Nombre Turno', 'Hora Inicio','Hora fin','Auditorio','Evento'],
        rowNum: 10, sortname: 'id_turno', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE TURNOS REGISTRADOS', align: "center",
        colModel: [
            {name: 'id_turno', index: 'id_producto', hidden: true},
            {name: 'desc_turno', index: 'desc_producto', align: 'center', width: 60},
            {name: 'hora_inicio', index: 'desc_producto', align: 'center', width: 20},
            {name: 'hora_fin', index: 'precio', align: 'center', width: 20},
            {name: 'id_auditorio', index: 'precio', align: 'center', width: 20},
            {name: 'id_evento', index: 'precio', align: 'center', width: 20}

        ],
        pager: '#pager_table_Turnos',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Turnos').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Turnos').jqGrid('getDataIDs')[0];
                            $("#table_Turnos").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_producto();
        }
    });

    $("#vw_buscar_materiales").keypress(function (e) {
            if (e.which == 13) {
                buscar_materiales();
            }
    });

});

function limpiar_formulario() {
    $("#dlg_desc_producto").val('');
    $("#dlg_precio").val('');
}


function nuevo_producto() {
    $("#dialog_nuevo_producto").dialog({
        autoOpen: false, modal: true, width: 550, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO PRODUCTO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_producto(1);
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
}

function guardar_editar_producto(tipo) {

    desc_producto = $("#dlg_desc_producto").val();
    precio = $("#dlg_precio").val();
   
    
    if(desc_producto == "")
    {
        mostraralertasconfoco("* El Campo Nombre producto es Obligatorio","#dlg_desc_producto");
        return false;
    }

    if(precio == "")
    {
        mostraralertasconfoco("* El Campo precio es Obligatorio","#dlg_precio");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Productos', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'productos/create',
            type: 'GET',
            data: {
                desc_producto:desc_producto,
                precio:precio,
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Productos');
                fn_actualizar_grilla('table_Productos');
                $("#dialog_nuevo_producto").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Productos');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {

        id_producto = $("#dlg_id_producto").val();
        desc_producto = $("#dlg_desc_producto").val();
        precio = $("#dlg_precio").val();

        MensajeDialogLoadAjax('table_Productos', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'productos/'+id_producto+'/edit',
            type: 'GET',
            data: {
                 desc_producto:desc_producto,
                precio:precio
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Productos');
                fn_actualizar_grilla('table_Productos');
                $("#dialog_nuevo_producto").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Productos');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_producto()
{
    id_producto = $('#table_Productos').jqGrid ('getGridParam', 'selrow');

    if (id_producto) {

        $("#dialog_nuevo_producto").dialog({
            autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR PRODUCTO :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_producto(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nuevo_producto").dialog('open');

        MensajeDialogLoadAjax('dialog_nuevo_producto', '.:: Cargando ...');

        $.ajax({url: 'productos/'+id_producto,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_producto").val(datos[0].id_producto);
                $("#dlg_desc_producto").val(datos[0].desc_producto);
                $("#dlg_precio").val(datos[0].precio);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_producto');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_producto');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Productos");
    }
}


function eliminar_producto(){
    id_producto = $('#table_Productos').jqGrid ('getGridParam', 'selrow');
    
    if(id_producto == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Productos");
        return false;
    }
    
    desc_producto = $('#table_Productos').jqGrid ('getCell', id_producto, 'desc_producto');
    
    swal({
          title: '¿Está Seguro que desea Eliminar El producto ' + desc_producto + ' ?',
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
              fn_elimiar_producto();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_producto() {
    id_producto = $('#table_Productos').jqGrid ('getGridParam', 'selrow');

    $.ajax({
        url: 'productos/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_productos_eliminar").data('token'),id_producto: id_producto},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Productos');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_materiales(){
    materiales = $("#vw_buscar_materiales").val();
    fn_actualizar_grilla('table_Materiales','getMateriales?materiales='+materiales);
}