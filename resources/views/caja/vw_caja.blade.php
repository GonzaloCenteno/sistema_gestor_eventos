@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">PAGOS RECIBO - CAJA</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">book</i>
                        </span>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">SELECCIONAR TIPO RECIBO</label>
                            <select class="form-control" id="mdl_cargo">
                                    <option value='0'>GENERADOS</option>
                                    <option value='1'>PAGADOS</option>
                                    <option value='2'>ANULADOS</option>
                            </select>
                          </div>
                    </div>
                </div>

                <div class="col-xs-2">
                    <div class="input-group">
                        <label class="control-label">FECHA DESDE</label>
                        <span class="input-group-addon">
                            <i class="material-icons">today</i>
                        </span>
                        <input id="fecha_desde" onchange="seleccionar_fecha();" type="date" class="form-control text-center" value="<?php echo date("Y-m-01"); ?>">
                    </div>
                </div>

                <div class="col-xs-2" style="padding-left: 80px">
                    <div class="input-group">
                        <label class="control-label">FECHA HASTA</label>
                        <span class="input-group-addon">
                            <i class="material-icons">today</i>
                        </span>
                        <input id="fecha_hasta" onchange="seleccionar_fecha();" type="date" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div> 

                <div class="col-xs-4" style="padding-left: 150px">
                    <div class="col-md-4 dropdown">
                        <a href="#" class="btn btn-simple dropdown-toggle" data-toggle="dropdown" style="background-color: rgb(153, 48, 176); border-radius: 20px;">
                            <i class="material-icons" style="color: white">print</i><label style="color: white">&nbsp;&nbsp;IMPRIMIR</label>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">IMPRIMIR REPORTE</a></li>
                            <li><a href="#">REIMPRIMIR RECIBO</a></li>
                        </ul>
                    </div>
                </div>
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_Caja"></table>
                        <div id="pager_table_Caja" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/caja/caja.js') }}"></script>

<!-- MANTENIMIENTO DE USUARIOS -->

<div id="dialog_nuevo_auditorio" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION AUDITORIO</h4>
                        </div>
                        <div class="card-content">
                            <input type="hidden" id="dlg_id_auditorio">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_capacidad" class="form-control" placeholder="CAPACIDAD DEL AUDITORIO">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">settings</i>
                                    </span>
                                    <input type="text" id="dlg_ubicacion" class="form-control" placeholder="UBICACION DEL AUDITORIO">
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
