
$(document).ready(function () {
    $("#li_config_credenciales").addClass('active');
    $("#menu_control").addClass('open');
    $("#menu_control").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Credenciales").jqGrid({
        url: 'getCredenciales',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'PERSONA', 'EMAIL', 'TIPO PERSONA', 'NACIONALIDAD', 'CREDENCIAL'],
        rowNum: 10, sortname: 'id', sortorder: 'desc', viewrecords: true, caption: 'LISTA PERSONAS', align: "center",
        colModel: [
            {name: 'id', index: 'id', hidden: true},
            {name: 'name', index: 'name', align: 'center', width: 28},
            {name: 'email', index: 'email', align: 'center', width: 18},
            {name: 'tipo_persona', index: 'tipo_persona', align: 'center', width: 16},
            {name: 'nacionalidad', index: 'nacionalidad', align: 'center', width: 16},
            {name: 'credencial', index: 'credencial', align: 'center', width: 26}
        ],
        pager: '#pager_table_Credenciales',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Credenciales').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Credenciales').jqGrid('getDataIDs')[0];
                            $("#table_Credenciales").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {}
    });

    $("#vw_buscar_credenciales").keypress(function (e) {
            if (e.which == 13) {
                buscar_credenciales();
            }
    });

});

function buscar_credenciales(){
    nombre = $("#vw_buscar_credenciales").val();
    fn_actualizar_grilla('table_Credenciales','getCredenciales?nombre='+nombre);
}

function ver_credencial(id_usuario)
{
    window.open('ver_credenciales/'+id_usuario);
}