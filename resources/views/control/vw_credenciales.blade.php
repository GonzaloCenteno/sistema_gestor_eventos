@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">ENTREGA DE CREDENCIALES</h4>
                </div>
                <div class="card-content">
                <div class="col-xs-12">
                        <div class="input-group">
                            <div class="icon-addon addon-md">
                                <input id="vw_buscar_credenciales" type="text" class="form-control text-uppercase text-center" placeholder="BUSCAR POR NOMBRE DE PERSONA">
                            </div>
                            <span class="input-group-btn">
                                <button onclick="buscar_credenciales();" type="button" class="btn btn-default btn-round"><i class="material-icons">search</i> Buscar</button>
                            </span>
                        </div>
                </div>
                    
                </div>
                <article class="col-xs-12">
                        <table id="table_Credenciales"></table>
                        <div id="pager_table_Credenciales" style="color:black;"></div>
                        <br>
                </article>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('archivos_js/control/credenciales.js') }}"></script>

@endsection
