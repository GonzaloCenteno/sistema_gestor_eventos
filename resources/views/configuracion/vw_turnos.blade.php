@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">MANTENIMIENTO DE TURNOS</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-6">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_buscar_turnos" type="text" class="form-control text-uppercase" placeholder="BUSCAR POR NOMBRE DE TURNO">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_turnos();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-6">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="nuevo_turno();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @endif
                    @if( $permisos[0]->btn_edit ==1 )
                        <button onclick="modificar_turno();" type="button" class="btn btn-warning btn-round">
                            <span class="btn-label"><i class="material-icons">create</i></span> Modificar
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-warning btn-round">
                            <span class="btn-label"><i class="material-icons">create</i></span> Modificar
                        </button>
                    @endif
                    @if( $permisos[0]->btn_del ==1 )
                        <button onclick="eliminar_turno();" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-round" id="btn_vw_turno_eliminar">
                            <span class="btn-label"><i class="material-icons">delete</i></span> Eliminar
                        </button>
                    @else
                        <button onclick="sin_permiso();" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-round">
                        <span class="btn-label"><i class="material-icons">delete</i></span> Eliminar
                        </button>
                    @endif
                </div> 
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_Turnos"></table>
                        <div id="pager_table_Turnos" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/configuracion/turnos.js') }}"></script>

<!-- MANTENIMIENTO DE USUARIOS -->

<div id="dialog_nuevo_turno" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION DEL TURNO</h4>
                        </div>
                        <div class="card-content">

                            <input type="hidden" id="dlg_id_turno">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">toc</i>
                                        </span>
                                        <input type="text" id="dlg_descripcion_turno" maxlength="30" class="form-control text-uppercase" placeholder="DESCRIPCION TURNO">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">timer</i>
                                        </span>
                                        <input type="time" id="dlg_hora_inicio" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">timer</i>
                                        </span>
                                        <input type="time" id="dlg_hora_fin" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">vertical_split</i>
                                    </span>
                                    <input type="hidden" id="hiddendlg_auditorio">
                                    <input type="text" id="dlg_auditorio" class="form-control text-uppercase" placeholder="ESCRIBIR NOMBRE AUDITORIO">
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">turned_in</i>
                                    </span>
                                    <input type="hidden" id="hiddendlg_evento">
                                    <input type="text" id="dlg_evento" class="form-control text-uppercase" placeholder="ESCRIBIR NOMBRE EVENTO">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
