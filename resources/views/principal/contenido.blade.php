@extends('layouts.principal')

@section('title', 'AQP EVENTOS - 2018')

@section('body-class', 'landing-page')

@section('content')
<div class="header header-filter" style="background-image: url('https://images.unsplash.com/photo-1423655156442-ccc11daa4e99?crop=entropy&dpr=2&fit=crop&fm=jpg&h=750&ixjsv=2.1.0&ixlib=rb-0.3.5&q=50&w=1450');">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="title">Bienvenido a AQP EVENTOS - 2018</h1>
                <h4>Realiza pedidos en línea y te contactaremos para coordinar la entrega.</h4>
                <br />
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="btn btn-danger btn-raised btn-lg">
                    <i class="fa fa-play"></i> ¿Cómo funciona?
                </a>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
    <div class="container">
        
            
            @guest
                <div class="section text-center section-landing">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="title">Let's talk product</h2>
                            <h5 class="description">This is the paragraph where you can write more details about your product. Keep you user engaged by providing meaningful information. Remember that by this time, the user is curious, otherwise he wouldn't scroll to get here. Add a button if you want the user to see more.</h5>
                        </div>
                    </div>

                    <div class="features">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info">
                                    <div class="icon icon-primary">
                                        <i class="material-icons">chat</i>
                                    </div>
                                    <h4 class="info-title">First Feature</h4>
                                    <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info">
                                    <div class="icon icon-success">
                                        <i class="material-icons">verified_user</i>
                                    </div>
                                    <h4 class="info-title">Second Feature</h4>
                                    <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info">
                                    <div class="icon icon-danger">
                                        <i class="material-icons">fingerprint</i>
                                    </div>
                                    <h4 class="info-title">Third Feature</h4>
                                    <p>Divide details about your product or agency work into parts. Write a few lines about each one. A paragraph describing a feature will be enough.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <br><br>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3">
                        <div class="card card-signup">
                                <div class="header header-primary text-center" style="height: 80px;">
                                    <h4>INSCRIPCION DE EVENTOS</h4>
                                </div>
                                <p class="text-divider">BUSCA Y SELECCIONA TUS EVENTOS</p>
                                <div class="content">

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">search</i>
                                        </span>
                                        <input type="hidden" id="hiddenbuscar_evento" value="0">
                                        <input id="buscar_evento" type="text" placeholder="ESCRIBIR NOMBRE DE EVENTO" class="form-control text-uppercase">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <input type="text" placeholder="CANTIDAD" id="cantidad" class="form-control" onkeypress="return soloNumeroTab(event);">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">attach_money</i>
                                                </span>
                                                <input type="text" placeholder="VALOR" id="valor" class="form-control" onkeypress="return soloNumeroTab(event);" disabled="">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <button onclick="detalle_recibo_eventos();" class="btn btn-danger btn-lg">AGREGAR</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card card-signup">
                                        <div class="header header-primary text-center" style="height: 80px; width: 300px">
                                            <h4>LISTA DE EVENTOS</h4>
                                        </div>
                                        <div class="content">

                                            <div style="border: 1px solid #DDD; margin-bottom: 6px;" id="tabla_detalle">
                                                <table id="t_dina_det_recibo" class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" align="center">Nº</th>
                                                            <th width="75%">Nombre Evento</th>
                                                            <th width="15%" align="right">Precio</th>
                                                            <th width="5%" align="center">Eliminar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>

                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" align="center"></th>
                                                            <th width="75%" style="text-align: right">Total S/.</th>
                                                            <th width="15%" style="border-top: 2px solid #017E42;">
                                                                <label class='input'><input id="vw_em_rec_txt_detalle_total" type="text" value="000.000" class="input-xs text-align-right" disabled=""></label>
                                                            </th>
                                                            <th width="5%" align="center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="footer text-center">
                                    <button onclick="grabar_datos()" class="btn btn-primary btn-lg">INSCRIBIRSE</button>
                                </div>
                        </div>
                    </div>
                </div>
            @endguest
            

        <div class="section text-center">
            <h2 class="title">NUESTROS EVENTOS 2018</h2>

            <div class="team">
                <div class="row">
                    @foreach($paquetes as $paquete)
                    <div class="col-md-4">
                        <div class="team-player">
                            <center>
                            <h4 class="title"> Paquete: {{ $paquete->descripcion }} </h4><br>
                            <img src="data:image/png;base64,{{ $paquete->img_evento }}" alt="Thumbnail Image" class="img-rounded img-responsive img-raised">
                            </center>
                            <button class="btn btn-success btn-round">
                                <i class="material-icons">add_circle</i> Ver Mas
                            </button>
                            <b><h4 style="color: red;">S/.{{ $paquete->precio }}</h4></b>
                            <h4>Evento: {{ $paquete->nombre_evento }} - {{ $paquete->tipo_evento }}</h4>
                            <p class="description">{{ $paquete->fecha_inicio }} / {{ $paquete->hora_inicio }} - {{ $paquete->fecha_fin }} / {{ $paquete->hora_fin }}</p>
                            <a href="#pablo" class="btn btn-simple btn-just-icon"><i class="fa fa-twitter"></i></a>
                            <a href="#pablo" class="btn btn-simple btn-just-icon"><i class="fa fa-instagram"></i></a>
                            <a href="#pablo" class="btn btn-simple btn-just-icon btn-default"><i class="fa fa-facebook-square"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>


        <div class="section landing-section">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="text-center title">Work with us</h2>
                    <h4 class="text-center description">Divide details about your product or agency work into parts. Write a few lines about each one and contact us about any further collaboration. We will responde get back to you in a couple of hours.</h4>
                    <form class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Your Name</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Your Email</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label">Your Messge</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 text-center">
                                <button class="btn btn-primary btn-raised">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>


<!-- MODALES -->

<div class="modal fade" id="ModalPreinscripciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            <div class="content">
                    
                <div class="card-header" data-background-color="purple">
                    <h4 class="title" id="titulo"></h4>
                </div>
                <div class="card-content">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person add</i>
                            </span>
                            <input type="text" id="mdl_nombres" class="form-control" placeholder="INGRESAR NOMBRES">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person add</i>
                            </span>
                            <input type="text" id="mdl_apellidos" class="form-control" placeholder="INGRESAR APELLIDOS">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <input type="text" id="mdl_email" class="form-control" placeholder="INGRESAR EMAIL">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">book</i>
                            </span>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">SELECCIONAR CARGO</label>
                                <select class="form-control" id="mdl_cargo">
                                        <option value='admin'>Admin</option>
                                        <option value='Embasador'>Embasador</option>
                                        <option value='Secretaria'>Secretaria</option>
                                        <option value='Mensajero'>Mensajero</option>
                                        <option value='Operador'>Operador</option>
                                </select>
                              </div>
                        </div>
                    </div>

                    <div class="col-sm-12" id="password">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">settings</i>
                            </span>
                            <input type="password" id="mdl_password" class="form-control" placeholder="INGRESAR CONTRASEÑA">
                        </div>
                    </div>


                </div>
                                
                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-md btn-round" id="modificar_empleado"><i class="material-icons">create</i> </button>
                <button type="button" class="btn btn-success btn-md btn-round" id="crear_empleado"><i class="material-icons">create</i> </button>
                <button type="button" class="btn btn-danger btn-md btn-round" id="cerrar_modal" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
@endsection
