
$(document).ready(function () {
    $("#li_config_asistencia").addClass('active');
    $("#menu_control").addClass('open');
    $("#menu_control").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Asistencia_persona").jqGrid({
        url: 'getAsistencia_persona',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'PERSONA', 'EMAIL', 'TIPO PERSONA', 'NACIONALIDAD', 'TIPO DOC.', 'Nº IDENTIFICACION'],
        rowNum: 10, sortname: 'id', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE ASISTENCIAS', align: "center",
        colModel: [
            {name: 'id', index: 'id', hidden: true},
            {name: 'name', index: 'name', align: 'center', width: 40},
            {name: 'email', index: 'email', align: 'center', width: 12},
            {name: 'tipo_persona', index: 'tipo_persona', align: 'center', width: 12},
            {name: 'nacionalidad', index: 'nacionalidad', align: 'center', width: 12},
            {name: 'tip_doc_ident', index: 'tip_doc_ident', align: 'center', width: 12},
            {name: 'num_ident', index: 'num_ident', align: 'center', width: 12}
        ],
        pager: '#pager_table_Asistencia_persona',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Asistencia_persona').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Asistencia_persona').jqGrid('getDataIDs')[0];
                            $("#table_Asistencia_persona").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            modificar_asistencias();
        }
    });
    
    jQuery("#table_detalle_asistencia").jqGrid({
        url: 'buscar_eventos_by_usuarios?indice='+0,
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'NOMBRE EVENTO', 'ASISTENCIA','ID_ASISTENCIA','TURNO'],
        rowNum: 10, sortname: 'id_turno', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE EVENTOS', align: "center",
        colModel: [
            {name: 'id_turno', index: 'id_turno', hidden: true},
            {name: 'nombre_evento', index: 'nombre_evento', align: 'center', width: 400},
            {name: 'check', index: 'check', align: 'center', width: 200},
            {name: 'id_asistencia', index: 'id_asistencia', align: 'center', width: 10, hidden:true},
            {name: 'desc_turno', index: 'desc_turno', align: 'center', width: 90}
        ],
        pager: '#pager_table_detalle_asistencia',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_detalle_asistencia').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_detalle_asistencia').jqGrid('getDataIDs')[0];
                            $("#table_detalle_asistencia").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
        }
    });

    $("#vw_buscar_asistencias").keypress(function (e) {
            if (e.which == 13) {
                buscar_asistencias();
            }
    });
    
    $("#dlg_nro_recibo").keypress(function (e) {
            if (e.which == 13) {
                buscar_recibo();
            }
    });

});

function buscar_recibo()
{
    nro_recibo = $("#dlg_nro_recibo").val();

    if (nro_recibo == '') {
        mostraralertasconfoco('* Debes Escribir un Numero de Recibo...', '#dlg_nro_recibo');
        return false;
    }
    
    MensajeDialogLoadAjax('dialog_nueva_asistencia', '.:: Cargando ...');
        $.ajax({url: 'buscar_nro_recibo',
        type: 'GET',
        data:{nro_recibo:nro_recibo},
        success: function(data) 
        {
            if (data.msg === 'si'){
                MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
                MensajeExito('Numero de Recibo Encontrado', 'La Operacion se Ejecuto Correctamente.');

                $('#dlg_concepto').val(data.concepto);
                $('#dlg_name').val(data.name);
                $('#dlg_tipo_persona').val(data.tipo_persona);
                $('#dlg_nacionalidad').val(data.nacionalidad);
                $('#dlg_tipo_doc').val(data.tip_doc_ident);
                $('#dlg_numero_identificacion').val(data.num_ident);
                id_usuario = $('#id_usuario').val(data.id);
                
                if (id_usuario == null) {
                    jQuery("#table_detalle_asistencia").jqGrid('setGridParam', {url: 'buscar_eventos_by_usuarios?indice='+0 }).trigger('reloadGrid');
                }else{
                    jQuery("#table_detalle_asistencia").jqGrid('setGridParam', {url: 'buscar_eventos_by_usuarios?indice='+$('#id_usuario').val() }).trigger('reloadGrid');
                }
                
            }else if(data.msg === 'existe'){
                mostraralertasconfoco("Mensaje del Sistema, EL NUMERO DE RECIBO YA FUE REGISTRADO");
                limpiar_formulario();
                MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
            }else{
                mostraralertasconfoco("Mensaje del Sistema, EL NUMERO DE RECIBO NO EXISTE");
                limpiar_formulario();
                MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
            }
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
            MensajeDialogLoadAjaxFinish('dlg_verif_administrativa');
        }
    }); 
}


function limpiar_formulario() {
    $("#dlg_nro_recibo").val('');
    $("#dlg_concepto").val('');
    $("#dlg_name").val('');
    $("#dlg_tipo_persona").val('');
    $("#dlg_nacionalidad").val('');
    $("#dlg_tipo_doc").val('');
    $("#dlg_numero_identificacion").val('');
    $("#id_usuario").val('');
    jQuery("#table_detalle_asistencia").jqGrid('setGridParam', {url: 'buscar_eventos_by_usuarios?indice='+0 }).trigger('reloadGrid');
}


function nueva_asistencia() {
    $("#dlg_nro_recibo").removeAttr('disabled');
    $("#dialog_nueva_asistencia").dialog({
        autoOpen: false, modal: true, width: 800, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: REGISTRAR ASISTENCIA :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_asistencia();
                    MensajeExito('Registro de Asistencias','La operacion fue Exitosa');
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

function guardar_asistencia()
{
    id_usuario = $("#id_usuario").val();
    nro_recibo = $("#dlg_nro_recibo").val();

    if (nro_recibo == '') {
        mostraralertasconfoco('* El Campo Numero de Recibo es Obligatorio...', '#dlg_nro_recibo');
        return false;
    }
    
    if (id_usuario == '') {
        mostraralertasconfoco('* La tabla esta vacia...', '#id_usuario');
        return false;
    }
    
    $('input[type=checkbox][name=estado_asistencia]').each(function() {
        fn_guardar_asistencia($(this).attr('id_turno'),$(this).attr('id_usuario'),$(this).is(':checked')?1:0);
    });  
}

function fn_guardar_asistencia(id_turno,id_usuario,estado) {

     MensajeDialogLoadAjax('dialog_nueva_asistencia', '.:: Cargando ...');

    $.ajax({
        url: 'asistencia/create',
        type: 'GET',
        data: {
            id_turno :id_turno,
            id_usuario :id_usuario,
            estado :estado
        },
        success: function (data) {
            MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
            dialog_close('dialog_nueva_asistencia');

            jQuery("#table_Asistencia_persona").jqGrid('setGridParam', {
             url: 'getAsistencia_persona'
            }).trigger('reloadGrid');
        },
        error: function (data) {
            return false;
        }
    });
}


function buscar_asistencias(){
    nombre = $("#vw_buscar_asistencias").val();
    fn_actualizar_grilla('table_Asistencia_persona','getAsistencia_persona?nombre='+nombre);
}

function modificar_asistencias(){
    $("#dlg_nro_recibo").attr('disabled',true);
    $("#dialog_nueva_asistencia").dialog({
        autoOpen: false, modal: true, width: 800, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:  EDITAR ASISTENCIAS :.",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Guardar Materiales",
            "class": "btn btn-warning bg-color-green",
            click: function () {
                 crear_materiales();
            }
        },{
            html: "<i class='fa fa-save'></i>&nbsp; Guardar",
            "class": "btn btn-success bg-color-green",
            click: function () {
                 actualizar_asistencia();
                 MensajeExito('Actualizacion de Asistencia','La operacion fue Exitosa');
            }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () {
                $(this).dialog("close");
            }
        }],
    });
    $("#dialog_nueva_asistencia").dialog('open');


    MensajeDialogLoadAjax('dialog_nueva_asistencia', '.:: Cargando ...');

    id_usuario = $('#table_Asistencia_persona').jqGrid ('getGridParam', 'selrow');
    
    $.ajax({url: 'asistencia/'+id_usuario,
        type: 'GET',
        success: function(r)
        {
            $("#dlg_nro_recibo").val(r[0].nro_recibo);
            $("#dlg_concepto").val(r[0].concepto);
            $("#dlg_name").val(r[0].name);
            $("#dlg_tipo_persona").val(r[0].tipo_persona);
            $("#dlg_nacionalidad").val(r[0].nacionalidad);
            $("#dlg_tipo_doc").val(r[0].tip_doc_ident);
            $("#dlg_numero_identificacion").val(r[0].num_ident);
            id_usuario = $('#id_usuario').val(r[0].id);
            if (id_usuario == null) {
                jQuery("#table_detalle_asistencia").jqGrid('setGridParam', {url: 'recuperar_asistencias?indice='+0 }).trigger('reloadGrid');
            }else{
                jQuery("#table_detalle_asistencia").jqGrid('setGridParam', {url: 'recuperar_asistencias?indice='+$('#id_usuario').val() }).trigger('reloadGrid');
            }
            MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
        },
        error: function(data) {
            mostraralertas("Hubo un Error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
            MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
        }
    });
}

function actualizar_asistencia()
{
    id_usuario = $("#id_usuario").val();
    nro_recibo = $("#dlg_nro_recibo").val();

    if (nro_recibo == '') {
        mostraralertasconfoco('* El Campo Numero de Recibo es Obligatorio...', '#dlg_nro_recibo');
        return false;
    }
    
    if (id_usuario == '') {
        mostraralertasconfoco('* La tabla esta vacia...', '#id_usuario');
        return false;
    }
    
    $('input[type=checkbox][name=estado_asistencia_1]').each(function() {
        fn_actualizar_asistencia($(this).attr('id_asistencia'),$(this).attr('id_turno'),$(this).attr('id_usuario'),$(this).is(':checked')?1:0);
    });  
}

function fn_actualizar_asistencia(id_asistencia,id_turno,id_usuario,estado) {

     MensajeDialogLoadAjax('dialog_nueva_asistencia', '.:: Cargando ...');

    $.ajax({
        url: 'asistencia/'+id_asistencia+'/edit',
        type: 'GET',
        data: {
            id_asistencia:id_asistencia,
            id_turno :id_turno,
            id_usuario :id_usuario,
            estado :estado
        },
        success: function (data) {
            MensajeDialogLoadAjaxFinish('dialog_nueva_asistencia');
            dialog_close('dialog_nueva_asistencia');

            jQuery("#table_Asistencia_persona").jqGrid('setGridParam', {
             url: 'getAsistencia_persona'
            }).trigger('reloadGrid');
        },
        error: function (data) {
            return false;
        }
    });
}

function limpiar_formulario_material(){
    $("#hiddendlg_material").val('');
    $("#dlg_material").val('');
    $("#dlg_cantidad").val('');
    $("#hidden_stock").val('');
}


function crear_materiales(){
    $("#dialog_asistencia_materiales").dialog({
        autoOpen: false, modal: true, width: 800, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: REGISTRAR MATERIALES :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    fn_guardar_material_asistencia();
                    MensajeExito('Registro de Asistencias','La operacion fue Exitosa');
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        close: function (event, ui) {
            limpiar_formulario_material();
        },
        open: function () {
            limpiar_formulario_material();
        }
    }).dialog('open');
    
    if(aux1_material==0)
    {
        autocompletar_materiales('dlg_material');
        aux1_material=1;
    }
}


var aux1_material=0;
function autocompletar_materiales(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_materiales',
        success: function (data) {
            var $datos = data;
            $("#dlg_material").autocomplete({
                source: $datos,
                focus: function (event, ui) {
                    $("#" + textbox).val(ui.item.label);
                    $("#hidden" + textbox).val(ui.item.value);
                    $("#" + textbox).attr('maxlength', ui.item.label.length);
                    $("#hidden_stock").val(ui.item.stock);
                    return false;
                },
                select: function (event, ui) {
                    $("#" + textbox).val(ui.item.label);
                    $("#hidden" + textbox).val(ui.item.value);
                    $("#hidden_stock").val(ui.item.stock);
                    return false;
                }
            });
        }
    });
}

function fn_guardar_material_asistencia(){
    
    id_material = $("#hiddendlg_material").val();
    material = $("#dlg_material").val();
    cantidad = $("#dlg_cantidad").val();
    stock = $("#hidden_stock").val();

    if (id_material == '') {
        mostraralertasconfoco('* El Campo Nombre Material es Obligatorio...', '#dlg_material');
        return false;
    }
    
    if (cantidad == '') {
        mostraralertasconfoco('* El Campo Cantidad Material es Obligatorio...', '#dlg_cantidad');
        return false;
    }
    
    if (stock == 0) {
        mostraralertasconfoco('* El Material ya no Tiene stock...', '#dlg_cantidad');
        return false;
    }
    
    if ((stock - cantidad) < 0) {
        mostraralertasconfoco('* La cantidad que deseas guardar excede el stock en inventario...', '#dlg_cantidad');
        return false;
    }
    
    id_turno = $('#table_detalle_asistencia').jqGrid ('getGridParam', 'selrow');
    
    if (id_turno) {
        
        id_asistencia = $('#table_detalle_asistencia').jqGrid ('getCell', id_turno, 'id_asistencia');
        id_usuario = $('#id_usuario').val();
        
        MensajeDialogLoadAjax('dialog_asistencia_materiales', '.:: Cargando ...');
    
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'agregar_materiales_asistencia/'+id_asistencia,
            type: 'GET',
            data: {
                id_turno:id_turno,
                id_usuario:id_usuario,
                id_material:id_material,
                cantidad:cantidad
            },
            success: function(r) 
            {
                MensajeExito("Se Modifico Correctamente","Su Registro Fue Modificado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('dialog_asistencia_materiales');
                limpiar_formulario_material();
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('dialog_asistencia_materiales');
                console.log('error');
                console.log(data);
            }
        });
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#buscar_eventos_by_usuarios");
    }

    
}