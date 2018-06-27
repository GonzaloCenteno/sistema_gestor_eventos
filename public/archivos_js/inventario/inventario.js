
$(document).ready(function () {
    $("#li_config_inventario").addClass('active');
    $("#menu_inventario").addClass('open');
    $("#menu_inventario").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Inventario").jqGrid({
        url: 'getInventario',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'NOMBRE MATERIAL', 'STOCK'],
        rowNum: 20, sortname: 'id_material', sortorder: 'desc', viewrecords: true, caption: 'LISTA MATERIALES EN INVENTARIO', align: "center",
        colModel: [
            {name: 'id_material', index: 'id_material', hidden: true},
            {name: 'nombre_material', index: 'nombre_material', align: 'center', width: 80},
            {name: 'sctock', index: 'sctock', align: 'center', width: 20}
        ],
        pager: '#pager_table_Inventario',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Inventario').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Inventario').jqGrid('getDataIDs')[0];
                            $("#table_Inventario").setSelection(firstid);    
                        }
        },
        onSelectRow: function (id_material) {
            fn_actualizar_grilla('table_Entrada','getInventario_entradas?id_material='+id_material); 
            fn_actualizar_grilla('table_Salida','getInventario_salidas?id_material='+id_material); 
            material = $('#table_Inventario').jqGrid ('getCell', id_material, 'id_material');
        },
        ondblClickRow: function (id_material) {
            agregar_stock(id_material);
        }
    });
    
    setTimeout(function(){
        
        
        jQuery("#table_Entrada").jqGrid({
            url: 'getInventario_entradas?id_material='+material,
            datatype: 'json', mtype: 'GET',
            height: 'auto', autowidth: true,
            toolbarfilter: true,
            colNames: ['ID', 'CANTIDAD', 'REGISTRO', 'MATERIAL'],
            rowNum: 5, sortname: 'id_material', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE ENTRADAS', align: "center",
            colModel: [
                {name: 'id_material', index: 'id_material', hidden: true},
                {name: 'cantidad', index: 'cantidad', align: 'center', width: 10},
                {name: 'fecha_registro', index: 'fecha_registro', align: 'center', width: 10},
                {name: 'nombre_material', index: 'nombre_material', align: 'center', width: 40}
            ],
            pager: '#pager_table_Entrada',
            rowList: [5, 10, 15, 20],
            gridComplete: function () {
                        var idarray = jQuery('#table_Entrada').jqGrid('getDataIDs');
                        if (idarray.length > 0) {
                        var firstid = jQuery('#table_Entrada').jqGrid('getDataIDs')[0];
                                $("#table_Entrada").setSelection(firstid);    
                            }
            }
        });
       MensajeDialogLoadAjaxFinish('content');
    }, 500);
    
    setTimeout(function(){
        jQuery("#table_Salida").jqGrid({
            url: 'getInventario_salidas?id_material='+material,
            datatype: 'json', mtype: 'GET',
            height: 'auto', autowidth: true,
            toolbarfilter: true,
            colNames: ['ID', 'CANTIDAD', 'REGISTRO', 'MATERIAL'],
            rowNum: 5, sortname: 'id_material', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE SALIDAS', align: "center",
            colModel: [
                {name: 'id_material', index: 'id_material', hidden: true},
                {name: 'cantidad', index: 'cantidad', align: 'center', width: 10},
                {name: 'fecha_registro', index: 'fecha_registro', align: 'center', width: 10},
                {name: 'nombre_material', index: 'nombre_material', align: 'center', width: 40}
            ],
            pager: '#pager_table_Salida',
            rowList: [5, 10, 15, 20],
            gridComplete: function () {
                        var idarray = jQuery('#table_Salida').jqGrid('getDataIDs');
                        if (idarray.length > 0) {
                        var firstid = jQuery('#table_Salida').jqGrid('getDataIDs')[0];
                                $("#table_Salida").setSelection(firstid);    
                            }
            }
        });
       MensajeDialogLoadAjaxFinish('content');
    }, 500);

    $("#vw_buscar_materiales").keypress(function (e) {
            if (e.which == 13) {
                buscar_materiales();
            }
    });

});

var aux1_material_inventario=0;
function autocompletar_materiales_inventario(textbox){
    $.ajax({
        type: 'GET',
        url: 'autocompletar_materiales',
        success: function (data) {
            var $datos = data;
            $("#dlg_material_inventario").autocomplete({
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
    $("#hiddendlg_material_inventario").val('');
    $("#dlg_material_inventario").val('');
}


function nuevo_inventario() {
    $("#dialog_nuevo_producto_inventario").dialog({
        autoOpen: false, modal: true, width: 600, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: AGREGAR MATERIAL A INVENTARIO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_material_inventario();
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
    
    if(aux1_material_inventario==0)
    {
        autocompletar_materiales_inventario('dlg_material_inventario');
        aux1_material_inventario=1;
    }
}

function guardar_material_inventario() {

    id_material = $("#hiddendlg_material_inventario").val();
    material = $("#dlg_material_inventario").val();
   
    
    if(id_material == "")
    {
        mostraralertasconfoco("* El Campo Nombre Material es Obligatorio","#dlg_material_inventario");
        return false;
    }


    MensajeDialogLoadAjax('table_Inventario', '.:: Cargando ...');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'inventario/create',
        type: 'GET',
        data: {
            id_material:id_material
        },
        success: function(data) 
        {
            if (data.msg == 'repetido') {
                mostraralertasconfoco("EL PRODUCTO YA FUE REGISTRADO EN INVENTARIO","#dlg_material_inventario");
                MensajeDialogLoadAjaxFinish('table_Inventario');
                $("#dlg_material_inventario").val('');
                $("#hiddendlg_material_inventario").val('');
            }else{
                MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
                MensajeDialogLoadAjaxFinish('table_Inventario');
                fn_actualizar_grilla('table_Inventario');
                $("#dlg_material_inventario").val('');
                $("#hiddendlg_material_inventario").val('');
            }
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('table_Inventario');
            console.log('error');
            console.log(data);
        }
    });

}

function limpiar_formulario_stock(){
    $("#hiddendlg_material_stock").val('');
    $("#dlg_material_stock").val('');
    $("#dlg_stock").val('');
}

function agregar_stock(id_material)
{
      
    $("#dialog_agregar_stock").dialog({
        autoOpen: false, modal: true, width: 600, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: AGREGAR STOCK A MATERIAL :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    guardar_stock();
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        close: function (event, ui) {
            limpiar_formulario_stock();
        }
    }).dialog('open');
    
    MensajeDialogLoadAjax('dialog_agregar_stock', '.:: Cargando ...');

    $.ajax({url: 'inventario/'+id_material,
        type: 'GET',
        success: function(datos)
        {
            $("#hiddendlg_material_stock").val(datos[0].id_material);
            $("#dlg_material_stock").val(datos[0].nombre_material);
            MensajeDialogLoadAjaxFinish('dialog_agregar_stock');

        },
        error: function(data) {
            mostraralertas("Hubo un Error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
            MensajeDialogLoadAjaxFinish('dialog_agregar_stock');
        }
    });

}

function guardar_stock(){
    id_material_stock = $("#hiddendlg_material_stock").val();
    stock = $("#dlg_stock").val();
   
    if(id_material_stock == "")
    {
        mostraralertasconfoco("* El Campo Nombre Material es Obligatorio","#dlg_material_stock");
        return false;
    }
    
    if(stock == "")
    {
        mostraralertasconfoco("* El Campo Stock Material es Obligatorio","#dlg_stock");
        return false;
    }


    MensajeDialogLoadAjax('table_Inventario', '.:: Cargando ...');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'inventario/'+id_material_stock+'/edit',
        type: 'GET',
        data: {
            stock:stock
        },
        success: function(data) 
        {
            MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('table_Inventario');
            fn_actualizar_grilla('table_Inventario');
            limpiar_formulario_stock();
            $("#dialog_agregar_stock").dialog("close");
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('table_Inventario');
            console.log('error');
            console.log(data);
        }
    });
}

function buscar_materiales(){
    nombre = $("#vw_buscar_materiales").val();
    fn_actualizar_grilla('table_Inventario','getInventario?nombre='+nombre);
}