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
                            <select class="form-control" id="tipo_recibo" onchange="cambiar_tipo();">
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
                        <input id="fecha_inicio" onchange="cambiar_tipo();" type="date" class="form-control text-center" value="<?php echo date("Y-m-01"); ?>">
                    </div>
                </div>

                <div class="col-xs-2" style="padding-left: 80px">
                    <div class="input-group">
                        <label class="control-label">FECHA HASTA</label>
                        <span class="input-group-addon">
                            <i class="material-icons">today</i>
                        </span>
                        <input id="fecha_fin" onchange="cambiar_tipo();" type="date" class="form-control text-center" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div> 

                <div class="col-xs-4" style="padding-left: 150px">
                    <div class="col-md-4 dropdown">
                        <a href="#" class="btn btn-simple dropdown-toggle" data-toggle="dropdown" style="background-color: rgb(153, 48, 176); border-radius: 20px;">
                            <i class="material-icons" style="color: white">print</i><label style="color: white">&nbsp;&nbsp;IMPRIMIR</label>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><button onclick="reporte_caja();" class="btn btn-danger">IMPRIMIR REPORTE</button></li>
                            <li><button onclick="reimprimir_recibo();" class="btn btn-prymary">REIMPRIMIR RECIBO</button></li>
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

<div id="vw_caja_mov_confirm_pago_reporte" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <iframe id="print_recibo_pagado" width="820" height="490" frameborder="0" allowfullscreen></iframe> 
            </div>
        </div>
    </div>
</div>

<div id="dialog_nuevo_pago_caja" style="display: none">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">INFORMACION RECIBO</h4>
                        </div>
                        <div class="card-content">
                            <input type="hidden" id="dlg_id_auditorio">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">assignment</i>
                                        </span>
                                        <input type="text" id="dlg_recibo" class="form-control" placeholder="RECIBO" disabled="">
                                    </div>
                                </div>
                                
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <input type="text" id="dlg_persona" class="form-control" placeholder="PERSONA" disabled="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">menu</i>
                                    </span>
                                    <input type="text" id="dlg_concepto" class="form-control" placeholder="CONCEPTO" disabled="">
                                </div>
                            </div>
                            
                            <div class="row">
                                
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">attach_money</i>
                                    </span>
                                    <input type="text" id="dlg_total" class="form-control" placeholder="TOTAL" disabled="">
                                </div>
                            </div>
                                
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">book</i>
                                    </span>
                                    <div class="form-group">
                                        <label for="tipo_pago">TIPO PAGO</label>
                                        <select class="form-control" id="tipo_pago">
                                            <option value='EFECTIVO' >EFECTIVO</option>
                                            <option value='TARJETA DE CREDITO' >TARJETA DE CREDITO</option>
                                        </select>
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
</div>
@endsection
