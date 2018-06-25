
$(document).ready(function () {
    $("#li_config_caja").addClass('active');
    $("#menu_caja").addClass('open');
    $("#menu_caja").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });
    estado = $("#tipo_recibo").val();
    fecha_inicio = $("#fecha_inicio").val();
    fecha_fin = $("#fecha_fin").val();
    
    jQuery("#table_Caja").jqGrid({
        url: 'getRecibosEmititos?estado='+estado+'&fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin,
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID','Nº Recibo', 'Persona', 'Concepto', 'Total', 'Fecha Registro', 'Hora Pago', 'Estado', 'usuario'],
        rowNum: 10, sortname: 'id_recibo', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE RECIBOS EMITIDOS', align: "center",
        colModel: [
            {name: 'id_recibo', index: 'id_recibo', width: 20, align:'center', hidden:true},
            {name: 'nro_recibo', index: 'nro_recibo', align: 'center', width: 20},
            {name: 'nombre_persona', index: 'nombre_persona', align: 'center', width: 100},
            {name: 'concepto', index: 'concepto', align: 'center', width: 100},
            {name: 'monto_total', index: 'monto_total', align: 'center', width: 15},
            {name: 'fecha_registro', index: 'fecha_registro', align: 'center', width: 40},
            {name: 'hora_pago', index: 'hora_pago', align: 'center', width: 40},
            {name: 'estado', index: 'estado', align: 'center', width: 10, hidden:true},
            {name: 'id_usuario', index: 'id_usuario', align: 'center', width: 10, hidden:true}
        ],
        pager: '#pager_table_Caja',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Caja').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Caja').jqGrid('getDataIDs')[0];
                            $("#table_Caja").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            estado = $('#table_Caja').jqGrid ('getCell', Id, 'estado');
            if (estado == 0) {
               pagar_recibo(); 
            }else{
                mostraralertasconfoco("El Recibo Ya fue Pagado");
            }
            
        }
    });
});

function limpiar_formulario() {
    $("#dlg_capacidad").val('');
    $("#dlg_ubicacion").val('');
}

function pagar_recibo() {
    id_recibo = $('#table_Caja').jqGrid ('getGridParam', 'selrow');

    if (id_recibo) {
        
        $("#dlg_recibo").val($('#table_Caja').jqGrid ('getCell', id_recibo, 'nro_recibo'));
        $("#dlg_persona").val($('#table_Caja').jqGrid ('getCell', id_recibo, 'nombre_persona'));
        $("#dlg_concepto").val($('#table_Caja').jqGrid ('getCell', id_recibo, 'concepto'));
        $("#dlg_total").val($('#table_Caja').jqGrid ('getCell', id_recibo, 'monto_total'));
        
        $("#dialog_nuevo_pago_caja").dialog({
            autoOpen: false, modal: true, width: 550, 
            show:{ effect: "explode", duration: 400},
            hide:{ effect: "explode", duration: 400}, resizable: false,
            title: ".: REVISION DE DATOS - RECIBO :.",
            buttons: [{
                    html: "<i class='material-icons'>print</i>&nbsp; IMPRIMIR RECIBO",
                    "class": "btn btn-success",
                    click: function () {
                        confirmar_Pago(id_recibo);
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
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Caja");
    }
}

function confirmar_Pago(id_recibo){
   monto = $("#dlg_total").val();
   fecha_inicio = $("#fecha_inicio").val();
   fecha_fin = $("#fecha_fin").val();
    
    $.ajax({
        url: 'caja/'+id_recibo+'/edit',
        type: 'GET',
        data: {
            monto:monto,
            estado:1
        },
        success: function (data) {
            if(data){
                imp_pago_rec(id_recibo);
                fn_actualizar_grilla('table_Caja', 'getRecibosEmititos?estado='+ $("#tipo_recibo").val() +'&fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin);              
                MensajeExito('Conforme', 'EL Pago se ha realizado con Exito');
            }
        },
        error: function (data) {
            MensajeAlerta('Error de Red.', 'Contactese con el Administrador');
        }
    });
}

function imp_pago_rec(id_recibo){
    id_recibo = $('#table_Caja').jqGrid ('getGridParam', 'selrow');

    if(id_recibo==null){
        return false;
    }
    id_usuario = $('#table_Caja').jqGrid ('getCell', id_recibo, 'id_usuario');
    $("#vw_caja_mov_confirm_pago_reporte").dialog({
        autoOpen: false, modal: true, width: 850,height:600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".: IMPRESION DEL RECIBO :.",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Confirmar e Imprimir",
            "class": "btn btn-primary",
            click: function (){
                dialog_close('vw_caja_mov_confirm_pago_reporte');
                dialog_close('dialog_nuevo_pago_caja');
                MensajeExito('Conforme', 'EL Pago se ha realizado con Exito');
                $("#print_recibo_pagado").contents().find("body").html('');
            }
        }]        
    }).dialog('open');
    
    $('#print_recibo_pagado').attr('src','imprimir_recibo?id_recibo='+id_recibo+'&id_usuario='+id_usuario);    
}

function cambiar_tipo(){

    estado = $("#tipo_recibo").val();
    fecha_inicio = $("#fecha_inicio").val();
    fecha_fin = $("#fecha_fin").val();
    
    if (fecha_inicio > fecha_fin) {
        mostraralertasconfoco("La fecha Inicio no puede ser mayor a la fecha fin");
        return false;
    }
    
    if (fecha_fin < fecha_inicio) {
        mostraralertasconfoco("La fecha Fin no puede ser menor a la fecha Inicio");
        return false;
    }

    jQuery("#table_Caja").jqGrid('setGridParam', {
         url: 'getRecibosEmititos?estado='+estado+'&fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin
    }).trigger('reloadGrid');

}

function reimprimir_recibo(){    
    id_recibo = $('#table_Caja').jqGrid ('getGridParam', 'selrow');

    if (id_recibo) {
        estado = $('#table_Caja').jqGrid ('getCell', id_recibo, 'estado');
        if (estado == 1) {
            
            id_usuario = $('#table_Caja').jqGrid ('getCell', id_recibo, 'id_usuario');
            
            $("#vw_caja_mov_confirm_pago_reporte").dialog({
            autoOpen: false, modal: true, width: 850,height:600, show: {effect: "fade", duration: 300}, resizable: false,
            title: ".: IMPRESION DEL RECIBO :.",
            buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Imprimir",
                "class": "btn btn-primary",
                click: function (){
                    dialog_close('vw_caja_mov_confirm_pago_reporte');
                    MensajeExito('Recibo', 'Reimpresión de Recibo');
                    $("#print_recibo_pagado").contents().find("body").html('');
                }
            }]        
            }).dialog('open');    
            $('#print_recibo_pagado').attr('src','imprimir_recibo?id_recibo='+id_recibo+'&id_usuario='+id_usuario);
        }else{
            mostraralertasconfoco("El Recibo debe estar Pagado");
        }
        
    }else{
        mostraralertasconfoco("No Hay Registros Seleccionados","#table_Caja");
    }
}

function reporte_caja(){
    window.open('imprimir_reporte_caja');
}