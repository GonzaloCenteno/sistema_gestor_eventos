
$(document).ready(function () {
    $("#li_config_usuarios").addClass('active');
    $("#menu_configuracion").addClass('open');
    $("#menu_configuracion").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    jQuery("#table_Usuarios").jqGrid({
        url: 'get_usuarios',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'Nombres', 'Correo', 'Fecha Creacion'],
        rowNum: 10, sortname: 'id', sortorder: 'desc', viewrecords: true, caption: 'LISTA DE USUARIOS REGISTRADOS', align: "center",
        colModel: [
            {name: 'id', index: 'id', hidden: true},
            {name: 'name', index: 'name', align: 'center', width: 100},
            {name: 'email', index: 'email', width: 50},
            {name: 'created_at', index: 'created_at', width: 20}
        ],
        pager: '#pager_table_Usuarios',
        rowList: [5, 10, 15, 20],
        gridComplete: function () {
                    var idarray = jQuery('#table_Usuarios').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_Usuarios').jqGrid('getDataIDs')[0];
                            $("#table_Usuarios").setSelection(firstid);    
                        }
        },
        onSelectRow: function (Id) {},
        ondblClickRow: function (Id) {
            dlg_Editar_Usuario();
        }
    });

    jQuery("#table_modulos").jqGrid({
            url: 'modulos',
            datatype: 'json', mtype: 'GET',
            height: '300px', autowidth: true,
            toolbarfilter: true,
            colNames: ['id', 'Descripcion'],
            rowNum: 50, sortname: 'id_mod', sortorder: 'desc', viewrecords: true, caption: 'Lista de Módulos', align: "center",
            colModel: [
                {name: 'id_mod', index: 'id_mod',align: 'center', width: 60},
                {name: 'descripcion', index: 'descripcion', align: 'left', width: 245}
                
            ],
            pager: '#pager_table_modulos',
            rowList: [50, 100],
            gridComplete: function () {
                    var idarray = jQuery('#table_modulos').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_modulos').jqGrid('getDataIDs')[0];
                            $("#table_modulos").setSelection(firstid);    
                        }
                },
            onSelectRow: function (Id){llamar_sub_modulo()},
            ondblClickRow: function (Id){}
    });

    jQuery("#table_sub_modulos").jqGrid({
            url: 'sub_modulos?identifi=0&usu=0',
            datatype: 'json', mtype: 'GET',
            height: '300px', autowidth: true,
            toolbarfilter: true,
            colNames: ['id', 'Descripcion','Grabar','Editar','Eliminar','Imprimir','Anular'],
            rowNum: 50, sortname: 'id_mod', sortorder: 'asc', viewrecords: true, caption: 'Lista de Sub Módulos', align: "center",
            colModel: [
                {name: 'id_mod', index: 'id_mod',align: 'center', width: 50},
                {name: 'descripcion', index: 'descripcion', align: 'left', width: 245},
                {name: 'new', index: 'new', align: 'center', width: 40},
                {name: 'upd', index: 'upd', align: 'center', width: 40},
                {name: 'del', index: 'del', align: 'center', width: 40},
                {name: 'print', index: 'print', align: 'center', width: 40},
                {name: 'anu', index: 'anu', align: 'center', width: 40}
            ],
            pager: '#pager_table_sub_modulos',
            rowList: [50, 100],
            gridComplete: function () {
                    var idarray = jQuery('#table_sub_modulos').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#table_sub_modulos').jqGrid('getDataIDs')[0];
                            $("#table_sub_modulos").setSelection(firstid);    
                        }
                },
            onSelectRow: function (Id){},
            ondblClickRow: function (Id){}
    });
    
    $(window).on('resize.jqGrid', function () {
        $("#table_Usuarios").jqGrid('setGridWidth', $("#content").width());
    });

    $("#vw_user_txt_buscar").keypress(function (e) {
            if (e.which == 13) {
                buscar_user();
            }
    });

});

function dlg_Editar_Usuario() {
    $("#dialog_Editar_Usuario").dialog({
        autoOpen: false, modal: true, width: 1400, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".: EDITAR USUARIO :.",
        buttons: [ {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger btn-round",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        close: function (event, ui) {
            limpiar_form_usuario();
        }
    }).dialog('open');

    id_user = $('#table_Usuarios').jqGrid('getGridParam', 'selrow');
    $.ajax({
        type: 'GET',
        url: 'get_datos_usuario?id=' + id_user,
        success: function (data) {
            llamar_sub_modulo();
            $("#vw_usuario_name").val(data.name);
            $("#vw_usuario_email").val(data.email);
            $("#vw_usuario_fecha_creacion").val(data.created_at);
        }, error: function (data) {
            mostraralertas('* Error base de datos... <br> * Contactese con el administrador..');
            dialog_close('dialog_Editar_Usuario');
        }
    });
}

function llamar_sub_modulo()
{
    
    modulo= $('#table_modulos').jqGrid('getGridParam', 'selrow');
    id_user = $('#table_Usuarios').jqGrid('getGridParam', 'selrow');
    if(id_user==null){
        return false;
    }
    jQuery("#table_sub_modulos").jqGrid('setGridParam', {url: 'sub_modulos?identifi='+modulo+'&usu='+id_user}).trigger('reloadGrid');
            
}


function limpiar_form_usuario() {
    $("#vw_usuario_name").val('');
    $("#vw_usuario_email").val('');
    $("#vw_usuario_fecha_creacion").val('');
    $("#dlg_nombre_completo").val('');
    $("#dlg_email").val('');
}

//CREAR MODULOS
function fn_new_mod()
{
    
    fn_crea_mod();
    $("#btn_edit_mod").hide();
    $("#btn_save_mod").show();

}

function fn_crea_mod()
{
    $("#hidden_id_mod").val(0);
    $("#dlg_des_mod,#dlg_title_mod,#dlg_idsis_mod").val("");
    $("#dlg_modulos").dialog({
        autoOpen: false, modal: true, width: 600, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".:Generar Modulos Sistema:.",
        buttons: [{
                html: "<i class='material-icons'>add</i>&nbsp; Guardar",
                "class": "btn btn-success",
                id:'btn_save_mod',
                click: function () {
                    fn_save_mod();
                }
            },
            {
                html: "<i class='material-icons'>add</i>&nbsp; Modificar",
                "class": "btn btn-primary",
                id:'btn_edit_mod',
                click: function () {
                    fn_save_mod();
                }
            },
            {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        }).dialog('open');
}

function fn_save_mod()
{
    if($("#dlg_des_mod").val()==0||$("#dlg_des_mod").val()=="")
    {
        mostraralertasconfoco("El Nombre de Módulo es Obligatorio","#dlg_des_mod");
        return false;
    }
    if($("#dlg_title_mod").val()==0||$("#dlg_title_mod").val()=="")
    {
        mostraralertasconfoco("El Título de Módulo es Obligatorio","#dlg_title_mod");
        return false;
    }
    if($("#dlg_idsis_mod").val()==0||$("#dlg_idsis_mod").val()=="")
    {
        mostraralertasconfoco("El ID del sistema es Obligatorio","#dlg_idsis_mod");
        return false;
    }
    if($("#hidden_id_mod").val()==0)
    {
        url='modulos/create'; titulo="Insertó";
    }
    else
    {
        url='modulos/'+$("#hidden_id_mod").val()+'/edit'; titulo="Modificó";
    }
    MensajeDialogLoadAjax('dlg_modulos', '.:: Guardando ...');
    $.ajax({
        url: url,
        type: 'GET',
        data: {des:$("#dlg_des_mod").val(),tit:$("#dlg_title_mod").val(),sis:$("#dlg_idsis_mod").val()},
        success: function(r) 
        {
            jQuery("#table_modulos").jqGrid('setGridParam', {url: 'modulos'}).trigger('reloadGrid');
            MensajeExito("Se "+titulo+" Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('dlg_modulos');
            $("#dlg_modulos").dialog("close");
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dlg_modulos');
            console.log('error');
            console.log(data);
        }
    });
}


function fn_edit_mod()
{
    fn_crea_mod();
    $("#btn_edit_mod").show();
    $("#btn_save_mod").hide();
    modulo= $('#table_modulos').jqGrid('getGridParam', 'selrow');
    if(modulo==null)
    {
        mostraralertasconfoco("No hay Modulo seleccionado","#table_modulos");
        return false;
    }
    MensajeDialogLoadAjax('dlg_modulos', '.:: Cargando ...');
    $.ajax({
        url: 'modulos/'+modulo,
        type: 'GET',
        success: function(r) 
        {
            $("#hidden_id_mod").val(modulo);
            $("#dlg_des_mod").val(r[0].descripcion);
            $("#dlg_title_mod").val(r[0].titulo);
            $("#dlg_idsis_mod").val(r[0].id_sistema);
            MensajeDialogLoadAjaxFinish('dlg_modulos');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dlg_modulos');
            console.log('error');
            console.log(data);
        }
    });

}

function fn_borrar_Modulo()
{
    modulo= $('#table_modulos').jqGrid('getGridParam', 'selrow');
    if(modulo==null)
    {
        mostraralertasconfoco("No hay Modulo seleccionado","#table_modulos");
        return false;
    }

    swal({
          title: 'Está Seguro que desea Eliminar Modulo?,',
          text: "Se Eliminará Submodulos y todos los permisos!",
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
              fn_delete_mod();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_delete_mod()
{
    Id= $('#table_modulos').jqGrid('getGridParam', 'selrow');
    MensajeDialogLoadAjax('dialog_Editar_Usuario', '.:: Eliminando ...');
    $.ajax({
        url: 'modulos/destroy',
        type: 'post',
        data: {_method: 'delete', _token:$("#btn_delmod").data('token'),id:Id},
        success: function(r) 
        {
            jQuery("#table_modulos").jqGrid('setGridParam', {url: 'modulos'}).trigger('reloadGrid');
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
            console.log('error');
            console.log(data);
        }
    });
}

//CREAR SUBMODULOS

function fn_new_submod()
{
    
    fn_crea_submod();
    $("#btn_edit_submod").hide();
    $("#btn_save_submod").show();

}

function fn_crea_submod()
{
    $("#hidden_id_submod").val(0);
    $("#dlg_des_submod,#dlg_title_submod,#dlg_idsis_submod,#dlg_ruta_submod,#dlg_orden_submod").val("");
    $("#dlg_submodulos").dialog({
        autoOpen: false, modal: true, width: 600, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: "Generar Sub - Modulos Sistema",
        buttons: [{
                html: "<i class='material-icons'>add</i>&nbsp; Guardar",
                "class": "btn btn-success",
                id:'btn_save_submod',
                click: function () {
                    fn_save_submod();
                }
            },
            {
                html: "<i class='material-icons'>add</i>&nbsp; Modificar",
                "class": "btn btn-primary",
                id:'btn_edit_submod',
                click: function () {
                    fn_save_submod();
                }
            },
            {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        }).dialog('open');
}

function fn_save_submod()
{
    if($("#dlg_des_submod").val()==0||$("#dlg_des_submod").val()=="")
    {
        mostraralertasconfoco("Ingresar Nombre de sub Módulo","#dlg_des_submod");
        return false;
    }
    if($("#dlg_title_submod").val()==0||$("#dlg_title_submod").val()=="")
    {
        mostraralertasconfoco("Ingresar Título de Módulo","#dlg_title_submod");
        return false;
    }
    if($("#dlg_idsis_submod").val()==0||$("#dlg_idsis_submod").val()=="")
    {
        mostraralertasconfoco("Ingresar id_sistema","#dlg_idsis_submod");
        return false;
    }
    if($("#dlg_ruta_submod").val()==0||$("#dlg_ruta_submod").val()=="")
    {
        mostraralertasconfoco("Ingresar Ruta","#dlg_ruta_submod");
        return false;
    }
    if($("#dlg_orden_submod").val()=='')
    {
       $("#dlg_orden_submod").val(0);
    }
    if($("#hidden_id_submod").val()==0)
    {
        url='sub_modulos/create'; titulo="Insertó";
    }
    else
    {
        url='sub_modulos/'+$("#hidden_id_submod").val()+'/edit'; titulo="Modificó";
    }
    modulo= $('#table_modulos').jqGrid('getGridParam', 'selrow');
    MensajeDialogLoadAjax('dlg_submodulos', '.:: Guardando ...');
    $.ajax({
        url: url,
        type: 'GET',
        data: {des:$("#dlg_des_submod").val(),tit:$("#dlg_title_submod").val(),sis:$("#dlg_idsis_submod").val(),ruta:$("#dlg_ruta_submod").val(),mod:modulo,orden:$("#dlg_orden_submod").val()},
        success: function(r) 
        {
            llamar_sub_modulo() 
            MensajeExito("Se "+titulo+" Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('dlg_submodulos');
            $("#dlg_submodulos").dialog("close");
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dlg_submodulos');
            console.log('error');
            console.log(data);
        }
    });
}

function fn_edit_submod()
{
    fn_crea_submod();
    $("#btn_edit_submod").show();
    $("#btn_save_submod").hide();
    submodulo= $('#table_sub_modulos').jqGrid('getGridParam', 'selrow');
    if(submodulo==null)
    {
        mostraralertasconfoco("No hay Sub Modulo seleccionado","#table_sub_modulos");
        return false;
    }
    MensajeDialogLoadAjax('dlg_submodulos', '.:: Cargando ...');
    $.ajax({
        url: 'sub_modulos/'+submodulo,
        type: 'GET',
        success: function(r) 
        {
            $("#hidden_id_submod").val(submodulo);
            $("#dlg_des_submod").val(r[0].des_sub_mod);
            $("#dlg_title_submod").val(r[0].titulo);
            $("#dlg_idsis_submod").val(r[0].id_sistema);
            $("#dlg_ruta_submod").val(r[0].ruta_sis);
            $("#dlg_orden_submod").val(r[0].orden);
            MensajeDialogLoadAjaxFinish('dlg_submodulos');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dlg_submodulos');
            console.log('error');
            console.log(data);
        }
    });

}

function fn_borrar_subModulo()
{
    submodulo= $('#table_sub_modulos').jqGrid('getGridParam', 'selrow');
    if(submodulo==null)
    {
        mostraralertasconfoco("No hay Sub Modulo seleccionado","#table_sub_modulos");
        return false;
    }

    swal({
          title: 'Está Seguro que desea Eliminar Sub Modulo?',
          text: "Se Eliminará todos los permisos!",
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
              fn_delete_submod();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function fn_delete_submod()
{
    Id=$('#table_sub_modulos').jqGrid('getGridParam', 'selrow');
    MensajeDialogLoadAjax('dialog_Editar_Usuario', '.:: Eliminando ...');
    $.ajax({
        url: 'sub_modulos/destroy',
        type: 'post',
        data: {_method: 'delete', _token:$("#btn_delmod").data('token'),id:Id},
        success: function(r) 
        {
            llamar_sub_modulo();
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
            console.log('error');
            console.log(data);
        }
    });
}


//ACTIVAR PERMISOS

function actbtn(id,tip)
{
    if( $('#ck'+tip+'_'+id).is(':checked') ) {
        nu=1;
    }
    else
    {
        nu=0;
    }
    id_user = $('#table_Usuarios').jqGrid('getGridParam', 'selrow');
    MensajeDialogLoadAjax('dialog_Editar_Usuario', '.:: Guardando ...');
    $.ajax({
        url: 'permisos/create',
        type: 'GET',
        data: {submod:id,tipo:tip,val:nu,usu:id_user},
        success: function(r) 
        {
            MensajeExito("Se Creo Correctamente","Su Permiso Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('dialog_Editar_Usuario');
            console.log('error');
            console.log(data);
        }
    });
    
}

//MANTENIMIENTO DE USUARIOS

function open_dialog_new_edit_Usuario() {
    $("#dialog_new_edit_Usuario").dialog({
        autoOpen: false, modal: true, width: 550, 
        show:{ effect: "explode", duration: 400},
        hide:{ effect: "explode", duration: 400}, resizable: false,
        title: ".: NUEVO USUARIO :.",
        buttons: [{
                html: "<i class='fa fa-save'></i>&nbsp; Guardar",
                "class": "btn btn-success",
                click: function () {
                    save_nuevo_usuario();
                }
            }, {
                html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
                "class": "btn btn-danger",
                click: function () {
                    $(this).dialog("close");
                }
            }],
        close: function (event, ui) {
            limpiar_form_usuario();
        },
        open: function () {
            limpiar_form_usuario();
        }
    }).dialog('open');
}

function save_nuevo_usuario() {

    $("#dlg_nombre_completo").val();
    $("#dlg_email").val();

    if ($("#dlg_nombre_completo").val() == '' || $("#dlg_nombre_completo").val().length <= 2) {
        MensajeDialogLoadAjaxFinish('table_Usuarios');
        mostraralertasconfoco('* El Campo Nombre es Obligatorio y mas de 2 Caracteres...', 'dlg_nombre_completo');
        return false;
    }

    if($("#dlg_email").val()==0||$("#dlg_email").val()=="")
    {
        mostraralertasconfoco("* El Campo Email es Obligatorio","#dlg_email");
        return false;
    }

    MensajeDialogLoadAjax('table_Usuarios', '.:: Cargando ...');
    $.ajax({
        url: 'usuarios/create',
        type: 'GET',
        data: {usuario:$("#dlg_nombre_completo").val(),email:$("#dlg_email").val()},
        success: function(r) 
        {
            MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            MensajeDialogLoadAjaxFinish('table_Usuarios');
            fn_actualizar_grilla('table_Usuarios');
            $("#dialog_new_edit_Usuario").dialog("close");
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            MensajeDialogLoadAjaxFinish('table_Usuarios');
            console.log('error');
            console.log(data);
        }
    });
 
}



function dlg_eliminar_usuario(){
    submodulo= $('#table_Usuarios').jqGrid('getGridParam', 'selrow');
    if(submodulo==null)
    {
        mostraralertasconfoco("No hay Usuario seleccionado","#table_Usuarios");
        return false;
    }

    swal({
          title: 'Está Seguro que desea Eliminar El Usuario?',
          text: "Se Eliminará todos los permisos!",
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
              eliminar_usuario();
            }, function(dismiss) {
              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
            });
        var audio_1 = document.getElementById("audio_messagebox");
        audio_1.play();
}

function eliminar_usuario() {
    id_usuario = $('#table_Usuarios').jqGrid('getGridParam', 'selrow');

    $.ajax({
        url: 'usuarios/destroy',
        type: 'POST',
        data: {_method: 'delete',_token:$("#btn_vw_usuarios_Eliminar").data('token'),id_usuario: id_usuario},
        success: function (data) {
            MensajeAlerta("Se Eliminó Correctamente","Su Registro Fue eliminado Correctamente...","top","right","success");
            fn_actualizar_grilla('table_Usuarios');
        }, error: function (data) {
            MensajeAlerta('* Error.', 'Contactese con el Administrador.');
        }
    });
}

function buscar_user(){
    user = $("#vw_user_txt_buscar").val();
    fn_actualizar_grilla('table_Usuarios','get_usuarios?user='+user);
}