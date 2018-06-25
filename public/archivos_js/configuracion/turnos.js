
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
            {name: 'id_turno', index: 'id_turno', hidden: true},
            {name: 'desc_turno', index: 'desc_turno', align: 'center', width: 30},
            {name: 'hora_inicio', index: 'hora_inicio', align: 'center', width: 20},
            {name: 'hora_fin', index: 'hora_fin', align: 'center', width: 20},
            {name: 'nombre_auditorio', index: 'nombre_auditorio', align: 'center', width: 40},
            {name: 'nombre_evento', index: 'nombre_evento', align: 'center', width: 40}
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
            modificar_turno();
        }
    });

    $("#vw_buscar_turnos").keypress(function (e) {
            if (e.which == 13) {
                buscar_turnos();
            }
    });

});

function limpiar_formulario() {
    $("#dlg_descripcion_turno").val('');
    $("#dlg_hora_inicio").val('');
    $("#dlg_hora_fin").val('');
    $("#hiddendlg_auditorio").val('');
    $("#hiddendlg_evento").val('');
    $("#dlg_auditorio").val('');
    $("#dlg_evento").val('');
}

var aux1_turno=0;
function autocompletar_eventos_turno(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_eventos',
        success: function (data) {
            var $datos = data;
            $("#dlg_evento").autocomplete({
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

var aux1_auditorio=0;
function autocompletar_auditorios(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_auditorios',
        success: function (data) {
            var $datos = data;
            $("#dlg_auditorio").autocomplete({
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

function nuevo_turno() {
    $("#dialog_nuevo_turno").dialog({
        autoOpen: false, modal: true, width: 650, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO TURNO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_turno(1);
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
    
    if(aux1_turno==0)
    {
        autocompletar_eventos_turno('dlg_evento');
        aux1_turno=1;
    }
    
    if(aux1_auditorio==0)
    {
        autocompletar_auditorios('dlg_auditorio');
        aux1_auditorio=1;
    }
    
}

function guardar_editar_turno(tipo) {

    desc_turno = $("#dlg_descripcion_turno").val();
    hora_inicio = $("#dlg_hora_inicio").val();
    hora_fin = $("#dlg_hora_fin").val();
    id_auditorio = $("#hiddendlg_auditorio").val();
    id_evento = $("#hiddendlg_evento").val();
   
    
    if(desc_turno == "")
    {
        mostraralertasconfoco("* El Campo Nombre Turno es Obligatorio","#dlg_descripcion_turno");
        return false;
    }

    if(hora_inicio == "")
    {
        mostraralertasconfoco("* El Campo Hora Inicio es Obligatorio","#dlg_hora_inicio");
        return false;
    }
    
    if(hora_fin == "")
    {
        mostraralertasconfoco("* El Campo Hora Fin es Obligatorio","#dlg_hora_fin");
        return false;
    }
    
    if(id_auditorio == "")
    {
        mostraralertasconfoco("* El Campo Nombre Auditorio es Obligatorio","#dlg_auditorio");
        return false;
    }
    
    if(id_evento == "")
    {
        mostraralertasconfoco("* El Campo Nombre Evento es Obligatorio","#dlg_evento");
        return false;
    }

    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Turnos', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'turno/create',
            type: 'GET',
            data: {
                desc_turno:desc_turno,
                hora_inicio:hora_inicio,
                hora_fin:hora_fin,
                id_auditorio:id_auditorio,
                id_evento:id_evento
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Turnos');
                fn_actualizar_grilla('table_Turnos');
                $("#dialog_nuevo_turno").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Turnos');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {

        id_turno = $("#dlg_id_turno").val();

        MensajeDialogLoadAjax('table_Turnos', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'turno/'+id_turno+'/edit',
            type: 'GET',
            data: {
                desc_turno:desc_turno,
                hora_inicio:hora_inicio,
                hora_fin:hora_fin,
                id_auditorio:id_auditorio,
                id_evento:id_evento
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Turnos');
                fn_actualizar_grilla('table_Turnos');
                $("#dialog_nuevo_turno").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Turnos');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_turno()
{
    id_turno = $('#table_Turnos').jqGrid ('getGridParam', 'selrow');

    if (id_turno) {

        $("#dialog_nuevo_turno").dialog({
            autoOpen: false, modal: true, width: 650, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR TURNO :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_turno(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nuevo_turno").dialog('open');
        
        if(aux1_turno==0)
        {
            autocompletar_eventos_turno('dlg_evento');
            aux1_turno=1;
        }

        if(aux1_auditorio==0)
        {
            autocompletar_auditorios('dlg_auditorio');
            aux1_auditorio=1;
        }

        MensajeDialogLoadAjax('dialog_nuevo_turno', '.:: Cargando ...');

        $.ajax({url: 'turno/'+id_turno,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_turno").val(datos[0].id_turno);
                $("#dlg_descripcion_turno").val(datos[0].desc_turno);
                $("#dlg_hora_inicio").val(datos[0].hora_inicio);
                $("#dlg_hora_fin").val(datos[0].hora_fin);
                $("#dlg_auditorio").val(datos[0].nombre_auditorio);
                $("#dlg_evento").val(datos[0].nombre_evento);
                $("#hiddendlg_evento").val(datos[0].id_evento);
                $("#hiddendlg_auditorio").val(datos[0].id_auditorio);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_turno');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_turno');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Turnos");
    }
}


function eliminar_turno(){
    id_turno = $('#table_Turnos').jqGrid ('getGridParam', 'selrow');
    
    if(id_turno == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Turnos");
        return false;
    }
    
    desc_turno = $('#table_Turnos').jqGrid ('getCell', id_turno, 'desc_turno');
    
    swal({
          title: '¿Está Seguro que desea Eliminar El Turno ' + desc_turno + ' ?',
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
              fn_elimiar_turno();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_turno() {
    id_turno = $('#table_Turnos').jqGrid ('getGridParam', 'selrow');

    $.ajax({
        url: 'turno/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_turno_eliminar").data('token'),id_turno: id_turno},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Turnos');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_turnos(){
    turnos = $("#vw_buscar_turnos").val();
    fn_actualizar_grilla('table_Turnos','getTurnos?turnos='+turnos);
}