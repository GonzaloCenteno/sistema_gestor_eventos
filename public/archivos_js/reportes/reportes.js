function dlg_reportes(tipo)
{
    if(tipo==1){ abrir1();}
    if(tipo == 2){ abrir2();}
    if(tipo == 3) { abrir3(); }
    if(tipo == 4)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    
    if(tipo == 11)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 12){abrir12(); }
    if(tipo == 13)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 14)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 15) { abrir15();}
    if(tipo == 16) {  abrir16();}
    if(tipo == 17) { abrir17();}
    if(tipo == 18)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 19)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 20){ abrir20();}
    if(tipo == 21) {abrir21(); }
    if(tipo == 22)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 23)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 24)
    {
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 25)
    {
      window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo == 26)
    {
       abrir26();
    }
             
}
function abrir1()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 500, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(1); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir2()
{
    $("#dialog_2").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(2); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir3()
{
    $("#dialog_3").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(3); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir12()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(12); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir15()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(15); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir16()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(16); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir17()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(17); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir20()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(20); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir21()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(21); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}
function abrir26()
{
    $("#dialog_1").dialog({
        autoOpen: false, modal: true, width: 600, show: {effect: "fade", duration: 300}, resizable: false,
        title: ".:REPORTE:",
        buttons: [{
            html: "<i class='fa fa-save'></i>&nbsp; Ver Reporte"  ,
            "class": "btn btn-success bg-color-green",
            click: function () { abrir_reporte(26); }
        }, {
            html: "<i class='fa fa-sign-out'></i>&nbsp; Salir",
            "class": "btn btn-danger",
            click: function () { $(this).dialog("close"); }
        }]
    }).dialog('open');
}

function selecciona_anio(){
    
    aniox = $("#select_anio_tributo").val();
    $("#hiddentributo").val("");
    $("#tributo").val("");
    
    $.ajax({
            type: 'GET',
            url: 'autocomplete_tributos?anio=' + aniox,
            success: function (data) {
                var $datos = data;
                $("#tributo").autocomplete({
                    source: $datos,
                    focus: function (event, ui) {
                        $("#tributo").val(ui.item.label);
                        $("#hiddentributo").val(ui.item.value);
                        $("#tributo").attr('maxlength', ui.item.label.length);
                        return false;
                    },
                    select: function (event, ui) {
                        $("#tributo").val(ui.item.label);
                        $("#hidden").val(ui.item.value);

                        return false;
                    }
                });
            }
        });

}

function abrir_reporte(tipo)
{
    if(tipo==1)
    {       
       window.open('ver_reporte/1?evento='+$("#select_evento").val()+'&tipo='+$("#select_tipo").val()+'&ini='+$("#fec_ini_1").val()+'&fin='+$("#fec_fin_1").val());
       return false;
    }
    if(tipo==2)
    {       
       window.open('ver_reporte/2?evento='+$("#select_evento2").val());
       return false;
    }
    if(tipo==3)
    {       
       window.open('ver_reporte/3?evento='+$("#select_evento3").val());
       return false;
    }
    if(tipo==12)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==15)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==16)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==17)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==20)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==21)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }
    if(tipo==26)
    {       
       window.open('ver_rep_tesoreria/1?ini='+$("#fec_ini").val()+'&fin='+$("#fec_fin").val()+'&caja='+$("#select_agencia_p").val());
       return false;
    }

    
}


