@extends('layouts.principal')

@section('title', 'AQP EVENTOS - 2018')

@section('body-class', 'landing-page')

@section('content')
<div class="header header-filter" style="background-image: url(img/ucsm.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="title">Bienvenido EVENTOS UCSM 2018</h1>
                <h4>Realiza tu preinscripción. Enterate de nuestros eventos.</h4>
                <br />
                <a href="{{ route('register') }}" class="btn btn-success btn-raised btn-lg">
                    <i class="fa fa-play"></i> REGISTRATE
                </a>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
    <div class="container">
        
            
            @guest
                <div class="section text-center section-landing">
                   

                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info">
                                    <div class="">
                                        <IMG SRC="img/logo_cato.png">
                                    </div>
                                    <h4 class="info-title">UCSM</h4>
                                    <p>La UCSM es la primera universidad particular de provincias con 55 años de vida académica formando profesionales con valores éticos..</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info">
                                    <div class="icon icon-success">
                                        <IMG SRC="img/ppis.jpg">
                                    </div>
                                    <h4 class="info-title">Programa Profesional de Ing de Sistemas</h4>
                                    <p>Programa Profesional de Ingenieria de Sistemas de la Universidad Catolica de Santa Maria-Arequipa.</p>
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
                             </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>


       
    </div>

</div>


<!-- MODALES -->



@include('includes.footer')
@endsection
