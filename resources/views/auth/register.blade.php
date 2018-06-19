@extends('layouts.app')

@section('body-class', 'signup-page')

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/city.jpg') }}'); background-size: cover; background-position: top center;">
    <div class="container" id="contenedor">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-6 col-sm-offset-3">
                <div class="card card-signup">

                        <div class="header header-primary text-center">
                            <h4>REGISTRO DE USUARIO</h4>
                        </div>
                        <p class="text-divider">COMPLETA TUS DATOS</p>
                        <div class="content">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <input type="text" placeholder="NOMBRES" id="nombre" class="form-control text-uppercase" value="{{ old('name') }}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <input type="text" placeholder="APELLIDO PATERNO" id="apaterno" class="form-control text-uppercase" value="{{ old('name') }}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">face</i>
                                        </span>
                                        <input type="text" placeholder="APELLIDO MATERNO" id="amaterno" class="form-control text-uppercase" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">book</i>
                                        </span>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">TIPO PERSONA</label>
                                            <select class="form-control" id="tipo_persona">
                                                <option value='ESTUDIANTE' >ESTUDIANTE</option>
                                                <option value='PROFESIONAL' >PROFESIONAL</option>
                                                <option value='PERSONA NATURAL' >PERSONA NATURAL</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">book</i>
                                        </span>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">NACIONALIDAD</label>
                                            <select class="form-control" id="nacionalidad">
                                                <option value='PERUANA' >PERUANA</option>
                                                <option value='EUROPEA' >EUROPEA</option>
                                                <option value='ESTADO UNIDENSE' >ESTADO UNIDENSE</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">book</i>
                                        </span>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect3">TIPO DOCUMENTO</label>
                                            <select class="form-control" id="tipo_documento">
                                                <option value='DNI' >DNI</option>
                                                <option value='RUC' >RUC</option>
                                                <option value='CARNET EXTRANJERIA' >CARNET EXTRANJERIA</option>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">email</i>
                                        </span>
                                        <input id="email" type="email" placeholder="CORREO ELECTRONICO" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">featured_play_list</i>
                                        </span>
                                        <input id="numero_identidad" type="text" placeholder="NUMERO IDENTIDAD" class="form-control" value="{{ old('email') }}" onkeypress="return soloNumeroTab(event);">
                                    </div>
                                </div>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <input placeholder="CONTRASEÑA" id="password" type="password" class="form-control"/>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer text-center">
                                    <a type="button" href="login" class="btn btn-danger btn-lg">LOGUEARSE</a>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="footer text-center">
                                    <button type="button" onclick="registrar_persona()" class="btn btn-primary btn-lg">Confirmar Registro</button>
                                </div>
                            </div>
                        </div>
                </div>
                
                <div style="display:none;">
                <audio id="audio_smallbox" controls>
                <source type="audio/mp3" src="{{ asset('sound/smallbox.mp3') }}">
                </audio>
                <audio id="audio_messagebox" controls>
                <source type="audio/mp3" src="{{ asset('sound/messagebox.mp3') }}">
                </audio>
                </div>
                </div>
        </div>
    </div>

</div>

@endsection
