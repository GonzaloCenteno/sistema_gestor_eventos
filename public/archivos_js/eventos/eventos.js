
$(document).ready(function () {
    $("#li_config_eventos").addClass('active');
    $("#menu_eventos").addClass('open');
    $("#menu_eventos").css({ 'background-color' : '#9930B0', 'border-radius' : '20px' });

    // $.get('getEventos',
    //     function(data){
    //         console.log(data);
    //     });

    $.ajax({
        url: 'getEventos',
        type: 'GET',
        success: function (data) {
            //console.log(data);
            $('#calendario').fullCalendar({
                theme: true,
                header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                        },
                defaultDate: new Date(),
                navLinks: true, 
                selectable: true,
                selectHelper: true,
                editable: true,
                eventLimit: true,
                events: data,
                eventDrop: function(event, delta, revertFunc){
                    //alert(event.title + " - " + event.start.format());
                    var id_evento = event.id;
                    var fecha_inicio = event.start.format();
                    var fecha_fin = event.end.format();

                    swal({
                      title: 'Está Seguro de Realizar este Cambio?',
                      text: "El Evento Cambiara de Fecha!",
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
                          actualizar_fechas(id_evento, fecha_inicio, fecha_fin);
                        }, function(dismiss) {
                          revertFunc();
                          MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
                        });
                    var audio_1 = document.getElementById("audio_messagebox");
                    audio_1.play();
                },
                eventResize: function(event, delta, revertFunc){
                    //alert(event.title + " - " + event.end.format());
                    var id_evento = event.id;
                    var fecha_inicio = event.start.format();
                    var fecha_fin = event.end.format();

                    swal({
                      title: 'Está Seguro de Realizar este Cambio?',
                      text: "El Evento Cambiara de Fecha!",
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
                          actualizar_fechas(id_evento, fecha_inicio, fecha_fin);
                        }, function(dismiss) {
                          revertFunc();
                          MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
                        });
                    var audio_1 = document.getElementById("audio_messagebox");
                    audio_1.play();   
                },
                eventRender: function(event, element){
                    var el = element.html();
                    element.html("<div class='editar' style='width:90%; float:left;'>" + el + "</div><div style='text-align:right;color:red;' class='eliminar'><i class='glyphicon glyphicon-trash'></i></div>");
                    element.find('.eliminar').click(function(){
                        //alert(event.id);
                        var id_evento = event.id;
                        var nombre = event.title;

                        swal({
                          title: 'Está Seguro de Eliminar El Evento: '+nombre,
                          text: "El Evento no se podra Recuperar",
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
                              eliminar_evento(id_evento,nombre);
                            }, function(dismiss) {
                              MensajeExito("Mensaje del Sistema","Operacion Cancelada","top","right","danger");
                            });
                        var audio_1 = document.getElementById("audio_messagebox");
                        audio_1.play();  
                    });

                    element.find('.editar').dblclick(function(){
                        var id_evento = event.id;
                        actualizar_evento(id_evento);
                    });
                },
                dayClick: function(date, jsEvent, view, resourceObj){
                    //alert('Date: ' + date.format());
                    Evento = $('#ModalEventos').modal('show');
                    limpiar_eventos();
                    Evento.find('.modal-title').text('MANTENIMIENTO DE EVENTOS');
                    Evento.find('#titulo').text('AGREGAR EVENTO').show(); 
                    Evento.find('#crear_evento').text('AGREGAR').show();
                    Evento.find('#modificar_evento').hide();

                    $('#mdl_fecha_inicio').val(date.format());
                    $('#mdl_fecha_fin').val(date.format());     
                    
                },
            });
        },
        error: function (data) {
            return false;
        }
    });

});


function actualizar_fechas(id_evento, fecha_inicio, fecha_fin){
    $.ajax({
        url: 'updateFecha',
        type: 'GET',
        data: {
            id_evento :id_evento,
            fecha_inicio:fecha_inicio,
            fecha_fin:fecha_fin
        },
        success: function (data) {
            MensajeExito("Se Actualizo El Evento","Operacion Ejecutada Correctamente...","top","right","success");
        },
        error: function (data) {
            return false;
        }
    });
 }

 function eliminar_evento(id_evento,nombre){
    $.ajax({
        url: 'deleteEvento',
        type: 'GET',
        data: {
            id_evento :id_evento
        },
        success: function (data) {
            $("#calendario").fullCalendar('removeEvents', id_evento);
            MensajeExito("El Evento "+ nombre + " fue Eliminado","Operacion Ejecutada Correctamente...","top","right","success");
        },
        error: function (data) {
            return false;
        }
    });
 }

function limpiar_eventos(){
    evento = $("#mdl_nombre_evento").val('');
    hora_inicio = $("#mdl_hora_inicio").val('');
    hora_fin = $("#mdl_hora_fin").val('');
}

jQuery(document).on("click", "#crear_evento", function(){

    evento = $("#mdl_nombre_evento").val();
    fecha_inicio = $("#mdl_fecha_inicio").val();
    fecha_fin = $("#mdl_fecha_fin").val();
    hora_inicio = $("#mdl_hora_inicio").val();
    hora_fin = $("#mdl_hora_fin").val();
    color = $("#mdl_color").val();

    if (evento == "") {
        mostraralertasvalidacion("* El Campo Nombre es Obligatorio","#mdl_nombre_evento");
        return false;
    }
    if (fecha_inicio == "") {
        mostraralertasvalidacion("* El Campo Fecha Inicio es Obligatorio","#mdl_fecha_inicio");
        return false;
    }
    if (fecha_fin == "") {
        mostraralertasvalidacion("* El Campo Fecha Fin es Obligatorio","#mdl_fecha_fin");
        return false;
    }
    if (hora_inicio == "") {
        mostraralertasvalidacion("* El Campo Hora Inicio es Obligatorio","#mdl_hora_inicio");
        return false;
    }
    if (hora_fin == "") {
        mostraralertasvalidacion("* El Campo Hora Fin es Obligatorio","#mdl_hora_fin");
        return false;
    }

    
    $.ajax({
        url: 'createEvento',
        type: 'GET',
        data: {
            evento:evento,
            fecha_inicio:fecha_inicio,
            fecha_fin:fecha_fin,
            hora_inicio:hora_inicio,
            hora_fin:hora_fin,
            color:color
        },
        success: function(data) 
        {
            //alert(data[0].title);
            var eventos_data;
            eventos_data = {
                id: data[0].id,
                title: data[0].title,
                start: data[0].start,
                end: data[0].end,
                color: data[0].color  
            }
            MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            $('#cerrar_modal').click();
            
            $('#calendario').fullCalendar('renderEvent', eventos_data, true);
            $('#calendario').fullCalendar('addEventSource', eventos_data);
            $('#calendario').fullCalendar('refetchEvents');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
        }
    });
        
})

function actualizar_evento(id_evento)
{
    Evento = $('#ModalEventos').modal('show');
    Evento.find('.modal-title').text('MANTENIMIENTO DE EVENTOS');
    Evento.find('#titulo').text('EDITAR EVENTO').show(); 
    Evento.find('#modificar_evento').text('MODIFICAR').show();
    Evento.find('#crear_evento').hide();

        $.ajax({
            url: 'evento/'+id_evento,
            type: 'GET',
            success: function(r) 
            {
                $("#id_evento").val(r[0].id_evento);
                $("#mdl_nombre_evento").val(r[0].nombre);
                $("#mdl_fecha_inicio").val(r[0].fecha_inicio);
                $("#mdl_fecha_fin").val(r[0].fecha_fin);
                $("#mdl_hora_inicio").val(r[0].hora_inicio);
                $("#mdl_hora_fin").val(r[0].hora_fin);
                $("#mdl_color").val(r[0].color);
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
            }
        })   
}


jQuery(document).on("click", "#modificar_evento", function(){

    id_evento = $("#id_evento").val();
    evento = $("#mdl_nombre_evento").val();
    fecha_inicio = $("#mdl_fecha_inicio").val();
    fecha_fin = $("#mdl_fecha_fin").val();
    hora_inicio = $("#mdl_hora_inicio").val();
    hora_fin = $("#mdl_hora_fin").val();
    color = $("#mdl_color").val();

    if (evento == "") {
        mostraralertasvalidacion("* El Campo Nombre es Obligatorio","#mdl_nombre_evento");
        return false;
    }
    if (fecha_inicio == "") {
        mostraralertasvalidacion("* El Campo Fecha Inicio es Obligatorio","#mdl_fecha_inicio");
        return false;
    }
    if (fecha_fin == "") {
        mostraralertasvalidacion("* El Campo Fecha Fin es Obligatorio","#mdl_fecha_fin");
        return false;
    }
    if (hora_inicio == "") {
        mostraralertasvalidacion("* El Campo Hora Inicio es Obligatorio","#mdl_hora_inicio");
        return false;
    }
    if (hora_fin == "") {
        mostraralertasvalidacion("* El Campo Hora Fin es Obligatorio","#mdl_hora_fin");
        return false;
    }

    
    $.ajax({
        url: 'evento/'+id_evento+'/edit',
        type: 'GET',
        data: {
            evento:evento,
            fecha_inicio:fecha_inicio,
            fecha_fin:fecha_fin,
            hora_inicio:hora_inicio,
            hora_fin:hora_fin,
            color:color
        },
        success: function(data) 
        {
            //alert(data[0].title);
            var eventos_update;
            eventos_update = {
                id: data[0].id,
                title: data[0].title,
                start: data[0].start,
                end: data[0].end,
                color: data[0].color  
            }
            $("#calendario").fullCalendar('removeEvents', id_evento);
            MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
            $('#cerrar_modal').click();
            
            $('#calendario').fullCalendar('renderEvent', eventos_update, true);
            $('#calendario').fullCalendar('refetchEvents');
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
        }
    });
})

jQuery(document).on("click", "#imprimir", function(){

    $(".FILA").addClass("nover");
    window.print();
    $(".FILA").removeClass("nover");
})