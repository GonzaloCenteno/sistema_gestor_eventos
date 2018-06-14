
$(document).ready(function () {
    $("#li_config_materiales").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Materiales").jqGrid({
        url: 'getMateriales',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'Nombre Material', 'Tipo Material', 'Stock', 'Usuario'],
        rowNum: 10, sortname: 'id_material', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE MATERIALES REGISTRADOS', align: "center",
        colModel: [
            {name: 'id_material', index: 'id_material', hidden: true},
            {name: 'nombre_material', index: 'nombre_material', align: 'center', width: 80},
            {name: 'tipo_material', index: 'tipo_material', align: 'center', width: 70},
            {name: 'sctock', index: 'sctock', align: 'center', width: 15},
            {name: 'id_pers', index: 'id_pers', align: 'center', width: 70}
        ],
        pager: '#pager_table_Materiales',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Materiales').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Materiales').jqGrid('getDataIDs')[0];
                            $("#table_Materiales").setSelection(firstid);    
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

function limpiar_formulario() {
    $("#dlg_nombre_material").val('');
    $("#dlg_tipo_material").val('');
    $("#dlg_stock").val('');
}


function nuevo_material() {
    $("#dialog_nuevo_material").dialog({
        autoOpen: false, modal: true, width: 550, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO MATERIAL :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_material(1);
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

function guardar_editar_material(tipo) {

    nombre_material = $("#dlg_nombre_material").val();
    tipo_material = $("#dlg_tipo_material").val();
    stock = $("#dlg_stock").val();
    
    if(nombre_material == "")
    {
        mostraralertasconfoco("* El Campo Nombre Material es Obligatorio","#dlg_nombre_material");
        return false;
    }

    if(tipo_material == "")
    {
        mostraralertasconfoco("* El Campo Tipo Material es Obligatorio","#tipo_material");
        return false;
    }

    if(stock == "")
    {
        mostraralertasconfoco("* El Campo Stock es Obligatorio","#dlg_stock");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Materiales', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'materiales/create',
            type: 'GET',
            data: {
                nombre_material:nombre_material,
                tipo_material:tipo_material,
                stock:stock
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
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
    else if (tipo == 2) {

        id_material = $("#dlg_id_material").val();

        MensajeDialogLoadAjax('table_Materiales', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'materiales/'+id_material+'/edit',
            type: 'GET',
            data: {
                nombre_material:nombre_material,
                tipo_material:tipo_material,
                stock:stock
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
                $("#dlg_nombre_material").val(datos[0].nombre_material);
                $("#dlg_tipo_material").val(datos[0].tipo_material);
                $("#dlg_stock").val(datos[0].sctock);
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
    
    nombre_material = $('#table_Materiales').jqGrid ('getCell', id_material, 'nombre_material');
    
    swal({
          title: '¿Está Seguro que desea Eliminar El Material ' + nombre_material + ' ?',
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