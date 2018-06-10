@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">CALENDARIO DE EVENTOS</h4>
                </div>
                <div class="card-content">
                    <center><div class="col-xs-6">
                        <button id="imprimir" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">print</i></span>Imprimir
                        </button>
                    </div></center>
                    <div id="calendario"></div>   
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/eventos/eventos.js') }}"></script>

<div class="modal fade" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title" id="titulo"></h4>
                                </div>
                                <div class="card-content">
                                    
                                    <div type="hidden" id="id_evento"></div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">add</i>
                                                </span>
                                                <input type="text" id="mdl_nombre_evento" class="form-control" placeholder="INGRESAR NOMBRE EVENTO">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">settings</i>
                                                </span>
                                                <input type="color" id="mdl_color" class="form-control" value="#ff0000">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">today</i>
                                                </span>
                                                <input id="mdl_fecha_inicio" type="date" class="form-control text-center" data-dateformat='yy-mm-dd' data-mask="9999/99/99" placeholder="--/--/----" disabled="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">timer</i>
                                                </span>
                                                <input id="mdl_hora_inicio" type="time" class="form-control text-center">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">today</i>
                                                </span>
                                                <input id="mdl_fecha_fin" type="date" class="form-control text-center" data-dateformat='yy-mm-dd' data-mask="9999/99/99" placeholder="--/--/----" >
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">timer</i>
                                                </span>
                                                <input id="mdl_hora_fin" type="time" class="form-control text-center">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-md btn-round" id="modificar_evento"><i class="material-icons">create</i> </button>
            <button type="button" class="btn btn-success btn-md btn-round" id="crear_evento"><i class="material-icons">create</i> </button>
            <button type="button" class="btn btn-danger btn-md btn-round" id="cerrar_modal" data-dismiss="modal">CERRAR</button>
        </div>
    </div>
</div>
</div>
@endsection
