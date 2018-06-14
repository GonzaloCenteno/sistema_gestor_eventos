function limpiar_datos(){
		$("#mdl_nombres").val("");
		$("#mdl_apellidos").val("");
		$("#mdl_email").val("");
		$("#mdl_password").val("");
}

function abrir_modal(){
		limpiar_datos();
		Empleados = $('#ModalPreinscripciones').modal('show');
		Empleados.find('.modal-title').text('EMPLEADOS');
		Empleados.find('#titulo').text('AGREGAR EMPLEADO').show(); 
		Empleados.find('#crear_empleado').text('AGREGAR').show();
		Empleados.find('#modificar_empleado').hide();
		$('#password').show();
}

jQuery(document).on("click", "#crear_empleado", function(){

	var table = $('#tblEmpleados').DataTable();
	nombres = $("#mdl_nombres").val();
	apellidos = $("#mdl_apellidos").val();
	email = $("#mdl_email").val();
	cargo = $("#mdl_cargo").val();
	password = $("#mdl_password").val();

	if (nombres == "") {
		mostraralertasvalidacion("* El Campo Nombre es Obligatorio","#mdl_nombres");
		return false;
	}
	if (apellidos == "") {
		mostraralertasvalidacion("* El Campo Apellidos es Obligatorio","#mdl_apellidos");
		return false;
	}
	if (email == "") {
		mostraralertasvalidacion("* El Campo Email es Obligatorio","#mdl_email");
		return false;
	}
	if (cargo == "") {
		mostraralertasvalidacion("* El Campo Cargo es Obligatorio","#mdl_cargo");
		return false;
	}
	if (password == "") {
		mostraralertasvalidacion("* El Campo Password es Obligatorio","#mdl_password");
		return false;
	}

	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'empleados/create',
        type: 'GET',
        data: {
        	nombres:nombres,
        	apellidos:apellidos,
        	email:email,
        	cargo:cargo,
        	password:password
        },
        success: function(data) 
        {
        	if(data.msg === 'repetido'){
           		mostraralertasconfoco("* El Campo Email ya Fue Registrado en el Sistema");
				return false;
           }else{
	           	MensajeExito("Se Guardo Correctamente","Su Registro Fue Insertado Correctamente...","top","right","success");
	            $('#cerrar_modal').click();
	            table.ajax.reload();
	        }  
        },
        error: function(data) {
            mostraralertas("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
        }
    });
})