function limpiar_datos(){
    $("#nombre").val('');
    $("#apaterno").val('');
    $("#amaterno").val('');
    $("#email").val('');
    $("#numero_identidad").val('');
    $("#password").val('');
}

function registrar_persona(){
    
    nombre = $("#nombre").val();
    apaterno = $("#apaterno").val();
    amaterno = $("#amaterno").val();
    email = $("#email").val();
    numero_identidad = $("#numero_identidad").val();
    password = $("#password").val();
    
    tipo_persona = $("#tipo_persona").val();
    nacionalidad = $("#nacionalidad").val();
    tipo_documento = $("#tipo_documento").val();
    
    
    if(nombre == "")
    {
        mostraralertasconfoco("* El Campo Nombre es Obligatorio","#nombre");
        return false;
    }

    if(apaterno == "")
    {
        mostraralertasconfoco("* El Campo Apellido Paterno es Obligatorio","#apaterno");
        return false;
    }

    if(amaterno == "")
    {
        mostraralertasconfoco("* El Campo Apellido Materno es Obligatorio","#amaterno");
        return false;
    }
    
    if(email == "")
    {
        mostraralertasconfoco("* El Campo Email es Obligatorio","#email");
        return false;
    }

    if(numero_identidad == "")
    {
        mostraralertasconfoco("* El Campo Numero Identidad es Obligatorio","#numero_identidad");
        return false;
    }

    if(password == "")
    {
        mostraralertasconfoco("* El Campo Password Materno es Obligatorio","#password");
        return false;
    }
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'principal/create',
            type: 'GET',
            data: {
                nombre:nombre,
                apaterno:apaterno,
                amaterno:amaterno,
                email:email,
                numero_identidad:numero_identidad,
                password:password,
                tipo_persona:tipo_persona,
                nacionalidad:nacionalidad,
                tipo_documento:tipo_documento
            },
            success: function(data) 
            {
                if (data.msg === 'si'){
                    mostraralertasconfoco("EL EMAIL: "+ email + " YA FUE REGISTRADO ANTERIORMENTE","#email");
                    return false;
                }else{
                    swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'TU PETICION FUE CREADA SATISFACTORIAMENTE',
                    showConfirmButton: false,
                    timer: 1500
                  })
                  var audio = document.getElementById("audio_smallbox");
                  audio.play();
                  limpiar_datos();
                  }
            },
            error: function(data) {
                mostraralertas("hubo un error, Comunicar al Administrador");
                MensajeDialogLoadAjaxFinish('contenedor');
                console.log('error');
                console.log(data);
            }
        });
    
}