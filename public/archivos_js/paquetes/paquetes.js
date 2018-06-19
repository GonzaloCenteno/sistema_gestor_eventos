
$(document).ready(function () {
    $("#li_config_paquetes").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Paquetes").jqGrid({
        url: 'getPaquetes',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'Descripcion', 'Precio Paquete'],
        rowNum: 10, sortname: 'id_paquete', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE PAQUETES REGISTRADOS', align: "center",
        colModel: [
            {name: 'id_paquete', index: 'id_paquete', hidden: false, align:'center',width: 10},
            {name: 'descripcion', index: 'descripcion', align: 'center', width: 120},
            {name: 'precio_paquete', index: 'precio_paquete', align: 'center', width: 20},
        ],
        pager: '#pager_table_Paquetes',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Paquetes').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Paquetes').jqGrid('getDataIDs')[0];
                            $("#table_Paquetes").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_paquete();
        }
    });

    $("#vw_buscar_paquetes").keypress(function (e) {
            if (e.which == 13) {
                buscar_paquetes();
            }
    });

});

function limpiar_formulario() {
    $("#dlg_nombre_paquete").val('');
}


function nuevo_paquete() {
    $("#dialog_nuevo_paquete").dialog({
        autoOpen: false, modal: true, width: 550, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO PAQUETE :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_paquete(1);
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

function guardar_editar_paquete(tipo) {

    descripcion = $("#dlg_nombre_paquete").val();
    
    if(descripcion == "")
    {
        mostraralertasconfoco("* El Campo Nombre del Paquete es Obligatorio","#dlg_nombre_paquete");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Paquetes', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'paquetes/create',
            type: 'GET',
            data: {
                descripcion:descripcion
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Paquetes');
                fn_actualizar_grilla('table_Paquetes');
                $("#dialog_nuevo_paquete").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Paquetes');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {

        id_paquete = $("#dlg_id_paquete").val();

        MensajeDialogLoadAjax('table_Materiales', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'paquetes/'+id_paquete+'/edit',
            type: 'GET',
            data: {
                descripcion:descripcion
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Paquetes');
                fn_actualizar_grilla('table_Paquetes');
                $("#dialog_nuevo_paquete").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Paquetes');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_paquete()
{
    id_paquete = $('#table_Paquetes').jqGrid ('getGridParam', 'selrow');

    if (id_paquete) {

        $("#dialog_nuevo_paquete").dialog({
            autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR PAQUETE :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_paquete(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nuevo_paquete").dialog('open');

        MensajeDialogLoadAjax('dialog_nuevo_paquete', '.:: Cargando ...');

        $.ajax({url: 'paquetes/'+id_paquete,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_paquete").val(datos[0].id_paquete);
                $("#dlg_nombre_paquete").val(datos[0].descripcion);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_paquete');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_paquete');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Paquetes");
    }
}

function eliminar_paquete(){
    id_paquete = $('#table_Paquetes').jqGrid ('getGridParam', 'selrow');
    
    if(id_paquete == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Paquetes");
        return false;
    }
    
    descripcion = $('#table_Paquetes').jqGrid ('getCell', id_paquete, 'descripcion');
    
    swal({
          title: '¿Está Seguro que desea Eliminar El Paquete: ' + descripcion + ' ?',
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
              fn_elimiar_paquete();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_paquete() {
    id_paquete = $('#table_Paquetes').jqGrid ('getGridParam', 'selrow');

    $.ajax({
        url: 'paquetes/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_paquetes_eliminar").data('token'),id_paquete: id_paquete},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Paquetes');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_paquetes(){
    descripcion = $("#vw_buscar_paquetes").val();
    fn_actualizar_grilla('table_Paquetes','getPaquetes?descripcion='+descripcion);
}