@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">EMISION DE RECIBOS</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-6">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_buscar_productos" type="text" class="form-control text-uppercase" placeholder="Buscar por Nombre de Producto">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_recibo_productos();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-6">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="nueva_emision_recibo();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Nuevo
                        </button>
                    @endif
                    @if( $permisos[0]->btn_del ==1 )
                        <button onclick="anular_recibo_producto();" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-round" id="btn_vw_productos_eliminar">
                            <span class="btn-label"><i class="material-icons">delete</i></span> Anular
                        </button>
                    @else
                        <button onclick="sin_permiso();" data-token="{{ csrf_token() }}" type="button" class="btn btn-danger btn-round">
                        <span class="btn-label"><i class="material-icons">delete</i></span> Anular
                        </button>
                    @endif
                </div> 
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_emision_recibos"></table>
                        <div id="pager_table_emision_recibos" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/caja/emision_recibos.js') }}"></script>

<!-- MANTENIMIENTO DE PRODUCTO -->

<div id="dialog_nuevo_emision_recibo" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION DEL RECIBO</h4>
                        </div>
                        <div class="card-content">

                            <input type="hidden" id="dlg_id_producto">
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">person_add</i>
                                    </span>
                                    <input type="text" id="dlg_nombre_persona" maxlength="100" class="form-control text-uppercase" placeholder="NOMBRE PERSONA">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">reorder</i>
                                    </span>
                                    <input type="hidden" id="hiddendlg_concepto">
                                    <input type="text" id="dlg_concepto" maxlength="100" class="form-control text-uppercase" placeholder="ESCRIBIR EL NOMBRE DEL PRODUCTO">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">attach_money</i>
                                        </span>
                                        <input type="text" id="dlg_monto_total" maxlength="10" class="form-control" placeholder="MONTO TOTAL" onkeypress="return soloNumeroTab(event);" disabled="">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">attach_money</i>
                                        </span>
                                        <input type="text" id="dlg_monto" maxlength="10" class="form-control" placeholder="MONTO" onkeypress="return soloNumeroTab(event);" disabled="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">check_circle</i>
                                        </span>
                                        <input type="text" id="dlg_cantidad" maxlength="10" class="form-control" placeholder="CANTIDAD" onkeypress="return soloNumeroTab(event);">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <button onclick="calcualar_total();" type="button" class="btn btn-success btn-round">
                                            <span class="btn-label"><i class="material-icons">add</i></span> CALCULAR
                                        </button>
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
