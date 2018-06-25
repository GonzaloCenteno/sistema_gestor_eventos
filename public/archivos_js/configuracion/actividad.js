
$(document).ready(function () {
    $("#li_config_actividad").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Actividad").jqGrid({
        url: 'getActividad',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'NOMBRE ACTIVIDAD', 'TURNO','PONENTE'],
        rowNum: 10, sortname: 'id_actividad', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE ACTIVIDADES REGISTRADAS', align: "center",
        colModel: [
            {name: 'id_actividad', index: 'id_actividad', hidden: true},
            {name: 'nombre_actividad', index: 'nombre_actividad', align: 'center', width: 50},
            {name: 'desc_turno', index: 'desc_turno', align: 'center', width: 50},
            {name: 'name', index: 'name', align: 'center', width: 50}
        ],
        pager: '#pager_table_Actividad',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Actividad').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Actividad').jqGrid('getDataIDs')[0];
                            $("#table_Actividad").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_actividad();
        }
    });

    $("#vw_buscar_actividad").keypress(function (e) {
            if (e.which == 13) {
                buscar_actividades();
            }
    });

});

function limpiar_formulario() {
    $("#dlg_nombre_actividad").val('');
    $("#dlg_turno").val('');
    $("#dlg_ponente").val('');
    $("#hiddendlg_ponente").val('');
    $("#hiddendlg_turno").val('');
}

var aux1_turnos=0;
function autocompletar_turnos(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_turnos',
        success: function (data) {
            var $datos = data;
            $("#dlg_turno").autocomplete({
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

var aux1_ponente=0;
function autocompletar_ponentes(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_ponentes',
        success: function (data) {
            var $datos = data;
            $("#dlg_ponente").autocomplete({
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

function nueva_actividad() {
    $("#dialog_nueva_actividad").dialog({
        autoOpen: false, modal: true, width: 650, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVA ACTIVIDAD :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_actividad(1);
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
    
    if(aux1_turnos==0)
    {
        autocompletar_turnos('dlg_turno');
        aux1_turnos=1;
    }
    
    if(aux1_ponente==0)
    {
        autocompletar_ponentes('dlg_ponente');
        aux1_ponente=1;
    }
    
}

function guardar_editar_actividad(tipo) {

    nombre_actividad = $("#dlg_nombre_actividad").val();
    id_turno = $("#hiddendlg_turno").val();
    desc_turno = $("#dlg_turno").val();
    id_ponente = $("#hiddendlg_ponente").val();
    nombre_ponente = $("#dlg_ponente").val();
   
    
    if(nombre_actividad == "")
    {
        mostraralertasconfoco("* El Campo Nombre Actividad es Obligatorio","#dlg_nombre_actividad");
        return false;
    }

    if(id_turno == "")
    {
        mostraralertasconfoco("* El Campo Descripcion Turno es Obligatorio","#dlg_turno");
        return false;
    }
    
    if(id_ponente == "")
    {
        mostraralertasconfoco("* El Campo Nombre Ponente es Obligatorio","#dlg_ponente");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Actividad', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'actividad/create',
            type: 'GET',
            data: {
                nombre_actividad:nombre_actividad,
                id_turno:id_turno,
                id_ponente:id_ponente
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Actividad');
                fn_actualizar_grilla('table_Actividad');
                $("#dialog_nueva_actividad").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Actividad');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {

        id_actividad = $("#dlg_id_actividad").val();

        MensajeDialogLoadAjax('table_Actividad', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'actividad/'+id_actividad+'/edit',
            type: 'GET',
            data: {
                nombre_actividad:nombre_actividad,
                id_turno:id_turno,
                id_ponente:id_ponente
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Actividad');
                fn_actualizar_grilla('table_Actividad');
                $("#dialog_nueva_actividad").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Actividad');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_actividad()
{
    id_actividad = $('#table_Actividad').jqGrid ('getGridParam', 'selrow');

    if (id_actividad) {

        $("#dialog_nueva_actividad").dialog({
            autoOpen: false, modal: true, width: 650, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR ACTIVIDAD :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_actividad(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nueva_actividad").dialog('open');
        
        if(aux1_turnos==0)
        {
            autocompletar_turnos('dlg_turno');
            aux1_turnos=1;
        }

        if(aux1_ponente==0)
        {
            autocompletar_ponentes('dlg_ponente');
            aux1_ponente=1;
        }

        MensajeDialogLoadAjax('dialog_nueva_actividad', '.:: Cargando ...');

        $.ajax({url: 'actividad/'+id_actividad,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_actividad").val(datos[0].id_actividad);
                $("#dlg_nombre_actividad").val(datos[0].nombre_actividad);
                $("#hiddendlg_turno").val(datos[0].id_turno);
                $("#dlg_turno").val(datos[0].desc_turno);
                $("#hiddendlg_ponente").val(datos[0].id_ponente);
                $("#dlg_ponente").val(datos[0].name);
                MensajeDialogLoadAjaxFinish('dialog_nueva_actividad');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nueva_actividad');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Actividad");
    }
}


function eliminar_actividad(){
    id_actividad = $('#table_Actividad').jqGrid ('getGridParam', 'selrow');
    
    if(id_actividad == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Actividad");
        return false;
    }
    
    nombre_actividad = $('#table_Actividad').jqGrid ('getCell', id_actividad, 'nombre_actividad');
    
    swal({
          title: '¿Está Seguro que desea Eliminar La Actividad: ' + nombre_actividad + ' ?',
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
              fn_elimiar_actividad();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_actividad() {
    id_actividad = $('#table_Actividad').jqGrid ('getGridParam', 'selrow');

    $.ajax({
        url: 'actividad/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_actividad_eliminar").data('token'),id_actividad: id_actividad},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Actividad');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_actividades(){
    actividades = $("#vw_buscar_actividad").val();
    fn_actualizar_grilla('table_Actividad','getActividad?actividades='+actividades);
}