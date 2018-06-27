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
                                <input id="vw_buscar_materiales" type="text" class="form-control text-uppercase text-center" placeholder="BUSCAR POR NOMBRE DE MATERIAL">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_materiales();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>

                <div class="col-xs-6">  

                    @if( $permisos[0]->btn_new ==1 )
                        <button onclick="nuevo_inventario();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Agregar a Inventario
                        </button>
                    @else
                        <button onclick="sin_permiso();" type="button" class="btn btn-success btn-round">
                            <span class="btn-label"><i class="material-icons">add</i></span>Agregar a Inventario
                        </button>
                    @endif
                   
                </div> 
                    
                </div>
                
                
                <div class="card">
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
</div>

                

<script src="{{ asset('archivos_js/inventario/inventario.js') }}"></script>

<!-- MANTENIMIENTO DE PRODUCTO -->

<div id="dialog_nuevo_producto_inventario" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION MATERIAL</h4>
                        </div>
                        <div class="card-content">
                            
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">class</i>
                                    </span>
                                    <input type="hidden" id="hiddendlg_material_inventario">
                                    <input type="text" id="dlg_material_inventario" class="form-control text-uppercase" placeholder="ESCRIBIR NOMBRE MATERIAL">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog_agregar_stock" style="display: none">
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
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">class</i>
                                        </span>
                                        <input type="hidden" id="hiddendlg_material_stock">
                                        <input type="text" id="dlg_material_stock" class="form-control text-uppercase" placeholder="ESCRIBIR NOMBRE MATERIAL" disabled="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment</i>
                                        </span>
                                        <input type="text" id="dlg_stock" class="form-control text-uppercase" placeholder="STOCK" onkeypress="return soloNumeroTab(event);">
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
