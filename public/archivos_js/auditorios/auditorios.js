
$(document).ready(function () {
    $("#li_config_auditorios").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Actividad").jqGrid({
        url: 'getAuditorios',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID','Nombre', ],
        rowNum: 10, sortname: 'id_auditorio', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE AUDITORIOS REGISTRADOS', align: "center",
        colModel: [
            {name: 'id_auditorio', index: 'id_auditorio', hidden: true},
             {name: 'nombre_auditorio', index: 'nombre_auditorio', align: 'center', width: 20},
            {name: 'capacidad', index: 'capacidad', align: 'center', width: 20},
            {name: 'disponibilidad', index: 'disponibilidad', align: 'center', width: 20},
            {name: 'ubicacion', index: 'ubicacion', align: 'center', width: 20}
        ],
        pager: '#pager_table_Auditorios',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Auditorios').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Auditorios').jqGrid('getDataIDs')[0];
                            $("#table_Auditorios").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_auditorio();
        }
    });

    $("#vw_buscar_auditorios").keypress(function (e) {
            if (e.which == 13) {
                buscar_auditorios();
            }
    });

});

function limpiar_formulario() {
    $("#dlg_capacidad").val('');
    $("#dlg_ubicacion").val('');
}


//MANTENIMIENTO DE AUDITORIOS

function nuevo_auditorio() {
    $("#dialog_nuevo_auditorio").dialog({
        autoOpen: false, modal: true, width: 550, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: CREAR NUEVO AUDITORIO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_editar_auditorio(1);
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

function guardar_editar_auditorio(tipo) {

    capacidad = $("#dlg_capacidad").val();
    disponibilidad = $("#dlg_disp").val();
    ubicacion = $("#dlg_ubicacion").val();
    nombre = $("#dlg_nombre").val();

    if(capacidad == "")
    {
        mostraralertasconfoco("* El Campo Capacidad es Obligatorio","#dlg_capacidad");
        return false;
    }

    if(ubicacion == "")
    {
        mostraralertasconfoco("* El Campo Ubicacion es Obligatorio","#dlg_ubicacion");
        return false;
    }
      if(nombre == "")
    {
        mostraralertasconfoco("* El Campo nombre es Obligatorio","#dlg_nombre");
        return false;
    }


    if (tipo == 1) {
        MensajeDialogLoadAjax('table_Auditorios', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'auditorios/create',
            type: 'GET',
            data: {
                nombre:nombre,
                disponibilidad:disponibilidad,
                capacidad:capacidad,
                ubicacion:ubicacion,
               
            },
            success: function(r) 
            {
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Auditorios');
                fn_actualizar_grilla('table_Auditorios');
                $("#dialog_nuevo_auditorio").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Auditorios');
                console.log('error');
                console.log(data);
            }
        });
    }
    else if (tipo == 2) {
        id_auditorio = $("#dlg_id_auditorio").val();
        MensajeDialogLoadAjax('table_Auditorios', '.:: Cargando ...');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'auditorios/'+id_auditorio+'/edit',
            type: 'GET',
            data: {
                capacidad:capacidad,
                ubicacion:ubicacion
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Auditorios');
                fn_actualizar_grilla('table_Auditorios');
                $("#dialog_nuevo_auditorio").dialog("close");
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('table_Auditorios');
                console.log('error');
                console.log(data);
            }
        });
    }
 
}

function modificar_auditorio()
{
    id_auditorio = $('#table_Auditorios').jqGrid ('getGridParam', 'selrow');

    if (id_auditorio) {

        $("#dialog_nuevo_auditorio").dialog({
            autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: EDITAR AUDITORIO :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success bg-color-green",
                click: function () {
                    guardar_editar_auditorio(2);
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        });
        $("#dialog_nuevo_auditorio").dialog('open');


        MensajeDialogLoadAjax('dialog_nuevo_auditorio', '.:: Cargando ...');

        $.ajax({url: 'auditorios/'+id_auditorio,
            type: 'GET',
            success: function(datos)
            {
                $("#dlg_id_auditorio").val(datos[0].id_auditorio);
                $("#dlg_capacidad").val(datos[0].capacidad);
                $("#dlg_ubicacion").val(datos[0].ubicacion);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_auditorio');

            },
            error: function(data) {
                mostraralertas("Hubo un Error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
                MensajeDialogLoadAjaxFinish('dialog_nuevo_auditorio');
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Auditorios");
    }
}

function eliminar_auditorio(){
    id_auditorio = $('#table_Auditorios').jqGrid('getGridParam', 'selrow');

    if(id_auditorio == null)
    {
        mostraralertasconfoco("No hay Registros seleccionados","#table_Auditorios");
        return false;
    }

    swal({
          title: '¿Está Seguro que desea Eliminar El Auditorio?',
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
              fn_elimiar_auditorio();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_elimiar_auditorio() {
    id_auditorio = $('#table_Auditorios').jqGrid('getGridParam', 'selrow');

    $.ajax({
        url: 'auditorios/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_usuarios_Eliminar").data('token'),id_auditorio: id_auditorio},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Auditorios');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_auditorios(){
    auditorios = $("#vw_buscar_auditorios").val();
    fn_actualizar_grilla('table_Auditorios','getAuditorios?auditorios='+auditorios);
}