@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="purple">
                    <h4 class="title">REPORTES </h4>
                </div>
                 <div class="well">
                    
                    <table class="table table-striped table-forum">
                        
                        <tbody>

                        <!-- TR -->
                         <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(1);" >
                                       A. Reporte Cantidad de Inscritos 
                                    </a>
                                </h4>
                            </td>
                        </tr>
                         <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(2);" >
                                       B. Reporte Inscritos con sus códigos QR  
                                    </a>
                                </h4>
                            </td>
                        </tr>
                         <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(3);" >
                                       C. Reporte de Asistencia de las Personas
                                    </a>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(4);" >
                                       D. Reporte de materiales 
                                    </a>
                                </h4>
                            </td>
                        </tr>
                       
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(11);" >
                                       1. Listado de eventos contratados, 
                                    </a>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(12);" >
                                       2. Número de participantes en un evento
                                    </a>
                                </h4>
                            </td>
          
                         
                        </tr>
                         <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(13);" >
                                       3. Detalle de eventos
                                    </a>
                                </h4>
                            </td>
          
                         
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(14);" >
                                       4.Listado de los auditorios y las ponencias en ellos
                                    </a>
                                    <small>Descripción reporte: Lista de todas las Entidades Públicas</small>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(15);" >
                                       5.Listado de cantidad de asistentes por evento
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(16);" >
                                       6.Listado de ingresos y egresos por una fecha dada
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(17);" >
                                       7.Balance por un rango de fechas.
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(18);" >
                                       8.Listado los 5 gastos más altos y más bajo
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(19);" >
                                       9.Listado de los 5 ingresos más altos y los 5 ingresos más bajos,
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(20);" >
                                       10.Listado todos los participantes que si recogieron material y no
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(21);" >
                                       11.Listar los participantes que no recogieron break
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(22);" >
                                       12.Listar todos los participantes, identificando si se pre-inscribió o no
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(23);" >
                                       13.Mostrar el evento más vendido y el menos vendido.
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(24);" >
                                       14.Listado todos los participantes que hayan participado en más de un evento.
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(25);" >
                                       15.Listado todos los ponentes que hayan participado en más de un evento
                                    </a>
                                </h4>
                            </td>                          
                        </tr>
                        <tr>
                            <td class="text-center" style="width: 80px;"><i class="fa fa-file-o fa-2x text-muted"></i></td>
                            <td>
                                <h4><a href="#" onclick="dlg_reportes(26);" >
                                       16.Listado los turnos con mayor/menor cantidad de asistentes
                                    </a>
                                </h4>
                            </td>                          
                        </tr>                                                          
                        <!-- end TR -->
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('archivos_js/reportes/reportes.js') }}"></script>


<div id="dialog_1" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <!-- widget div-->
                <div class="row" style="padding: 10px 30px;">
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Evento &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_evento' class="form-control col-lg-10" >
                                <option value='0'>-- TODOS --</option>
                                @foreach ($evento as $ev)
                                    <option value='{{$ev->id_evento}}' >{{$ev->nombre_evento}}</option>
                                @endforeach
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Tipo Inscrito &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_tipo' class="form-control col-lg-10" >
                                    <option value='PONENTE' >PONENTE</option>
                                    <option value='ESTUDIANTE' >ESTUDIANTE</option>
                                    <option value='PROFESIONAL' >PROFESIONAL</option>
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px;">
                        <div class="input-group input-group-md" style="width: 98%">
                            <span class="input-group-addon" style="width: 165px">Fecha inicio &nbsp;<i class="fa fa-calendar"></i></span>
                            <div>
                            <input id="fec_ini_1" name="dlg_fec" type="date"   class="datepicker text-center" data-dateformat='dd/mm/yy' data-mask="99/99/9999" style="height: 32px; width: 100%" placeholder="--/--/----" value="{{date('01/m/Y')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" style=" margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 98%">
                            <span class="input-group-addon" style="width: 165px">Fecha fin &nbsp;<i class="fa fa-calendar"></i></span>
                            <div>
                            <input id="fec_fin_1" name="dlg_fec" type="date"   class="datepicker text-center" data-dateformat='dd/mm/yy' data-mask="99/99/9999" style="height: 32px; width: 100%" placeholder="--/--/----" value="{{date('d/m/Y')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget div -->
            </div>
        </div>
    </div>
</div>

<div id="dialog_2" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <!-- widget div-->
                <div class="row" style="padding: 10px 30px;">
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Evento &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_evento2' class="form-control col-lg-10" >
                                <option value='0'>-- TODOS --</option>
                                @foreach ($evento as $ev)
                                    <option value='{{$ev->id_evento}}' >{{$ev->nombre_evento}}</option>
                                @endforeach
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget div -->
            </div>
        </div>
    </div>
</div>
<div id="dialog_3" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <!-- widget div-->
                <div class="row" style="padding: 10px 30px;">
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Evento &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_evento3' class="form-control col-lg-10" >
                                <option value='0'>-- TODOS --</option>
                                @foreach ($evento as $ev)
                                    <option value='{{$ev->id_evento}}' >{{$ev->nombre_evento}}</option>
                                @endforeach
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget div -->
            </div>
        </div>
    </div>
</div>
<div id="dialog_12" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <!-- widget div-->
                <div class="row" style="padding: 10px 30px;">
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Evento &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_evento12' class="form-control col-lg-10" >
                                <option value='0'>-- seleccionar --</option>
                                @foreach ($evento as $ev)
                                    <option value='{{$ev->id_evento}}' >{{$ev->nombre_evento}}</option>
                                @endforeach
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget div -->
            </div>
        </div>
    </div>
</div>
<div id="dialog_13" style="display: none">
    <div class="widget-body">
        <div  class="smart-form">
            <div class="panel-group">
                <!-- widget div-->
                <div class="row" style="padding: 10px 30px;">
                   <div class="col-xs-12" style="padding: 0px; margin-top: 10px; ">
                        <div class="input-group input-group-md" style="width: 100%">
                            <span class="input-group-addon" style="width: 165px">Evento &nbsp;<i class="fa fa-users"></i></span>
                            <div>
                                <label class="select" >
                                    <select id='select_evento13' class="form-control col-lg-10" >
                                <option value='0'>-- seleccionar --</option>
                                @foreach ($evento as $ev)
                                    <option value='{{$ev->id_evento}}' >{{$ev->nombre_evento}}</option>
                                @endforeach
                            </select><i></i> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget div -->
            </div>
        </div>
    </div>
</div>
@endsection