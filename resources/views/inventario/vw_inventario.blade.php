@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">MANTENIMIENTO DE INVENTARIO</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-6">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_buscar_productos" type="text" class="form-control text-uppercase" placeholder="Buscar por Nombre de Producto">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_productos();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-6">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="nuevo_producto();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Agregar a Inventario
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Agregar a Inventario
                        </button>
                    @endif
                   
                </div> 
                    
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <table id="table_Inventario"></table>
                        <div id="pager_table_Inventario" style="color:black;"></div>
                        <br>
                    </div>
                    
                    <div class="col-sm-6">
                        <table id="table_Entrada"></table>
                        <div id="pager_table_Entrada" style="color:black;"></div>
                        <br>
                        <table id="table_Salida"></table>
                        <div id="pager_table_Salida" style="color:black;"></div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/inventario/inventario.js') }}"></script>

<!-- MANTENIMIENTO DE PRODUCTO -->

<div id="dialog_nuevo_producto" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION PRODUCTO</h4>
                        </div>
                        <div class="card-content">

                            <input type="hidden" id="dlg_id_producto">
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_desc_producto" maxlength="100" class="form-control text-uppercase" placeholder="NOMBRE PRODUCTO">
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_precio" maxlength="10" class="form-control" placeholder="PRECIO PRODUCTO" onkeypress="return soloNumeroTab(event);">
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
