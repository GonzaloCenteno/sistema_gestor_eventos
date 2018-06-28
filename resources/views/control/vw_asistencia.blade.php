@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">REGISTRO DE ASISTENCIA</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-9">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_buscar_asistencias" type="text" class="form-control text-uppercase text-center" placeholder="BUSCAR POR NOMBRE DE PERSONA">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_asistencias();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-3">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="nueva_asistencia();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Registrar Asistencia
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Registrar Asistencia
                        </button>
                    @endif
                    
                </div> 
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_Asistencia_persona"></table>
                        <div id="pager_table_Asistencia_persona" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/control/asistencia.js') }}"></script>

<!-- MANTENIMIENTO DE PRODUCTO -->

<div id="dialog_nueva_asistencia" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION PERSONA</h4>
                        </div>
                        <div class="card-content">

                            <input type="hidden" id="dlg_id_producto">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_nro_recibo" maxlength="100" class="form-control text-uppercase text-center" placeholder="NUMERO DE RECIBO">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_concepto" class="form-control text-center" placeholder="CONCEPTO RECIBO" disabled="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_name" class="form-control text-center" placeholder="NOMBRE PERSONA" disabled="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_tipo_persona" class="form-control text-center" placeholder="TIPO PERSONA" disabled="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_nacionalidad" class="form-control text-center" placeholder="NACIONALIDAD" disabled="">
                                    </div>
                                </div>
    
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_tipo_doc" class="form-control text-center" placeholder="TIPO DOCUMENTO" disabled="">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_numero_identificacion" class="form-control text-center" placeholder="NUMERO IDENTIFICACION" disabled="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12" style="padding-left: 5px">
                                <input type="hidden" id="id_usuario">
                                <table id="table_detalle_asistencia"></table>
                                <div id="pager_table_detalle_asistencia" style="color:black;"></div>                            
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog_asistencia_materiales" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION MATERIAL</h4>
                        </div>
                        <div class="card-content">

                            
                            
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="hidden" id="hidden_stock">
                                        <input type="hidden" id="hiddendlg_material">
                                        <input type="text" id="dlg_material" maxlength="100" class="form-control text-uppercase text-center" placeholder="ESCRIBIR NOMBRE MATERIAL">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">settings</i>
                                        </span>
                                        <input type="text" id="dlg_cantidad" class="form-control text-center" placeholder="CANTIDAD" onkeypress="return soloNumeroTab(event);">
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
@endsection
