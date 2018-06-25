<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Caja-Recibo</title>        
    </head>
    <style>        
        @page {
            margin:0;
            padding: 0;
           
        }
    </style>
    <body style="font-family: sans-serif;">

        <img src="img/recibo_caja.jpeg" style="width: 100%;position: absolute;">              
        <div style="position: absolute;margin-top: 52px;margin-left: 590px; font-size: 19px;">
            Nº: 2018 - {{$recibo_cabecera->nro_recibo}}
        </div>
        <div style="position: absolute;margin-top: 190px;margin-left: 80px; font-size: 14px;">
           Nombres y Apellidos&nbsp;&nbsp;&nbsp;: &nbsp; {{$recibo_cabecera->name}}
        </div>
        <div style="position: absolute;margin-top: 205px;margin-left: 80px; font-size: 14px;">
           Correo Electronico&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; {{$recibo_cabecera->email}}
        </div>
        <div style="position: absolute;margin-top: 220px;margin-left: 80px; font-size: 14px;">
           Tipo Persona&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; {{$recibo_cabecera->tipo_persona}}
        </div>
        <div style="position: absolute;margin-top: 235px;margin-left: 80px; font-size: 14px;">
           Tipo Documento&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; {{$recibo_cabecera->tip_doc_ident}} - {{$recibo_cabecera->num_ident}}
        </div>
        
        <div style="position: absolute;margin-top: 195px;margin-left: 385px; font-size: 14px;">
          Recibo N.&nbsp;&nbsp;&nbsp;: &nbsp; {{$recibo_cabecera->nro_recibo}}
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ {{date('M d',strtotime($recibo_cabecera->fecha_pago))}} ]
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora:{{$recibo_cabecera->hora_pago}} 
        </div>
        <div style="position: absolute;margin-top: 210px;margin-left: 385px; font-size: 14px;">
          Emitido&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;  {{$recibo_cabecera->fecha_pago}}
        </div>
        <div style="position: absolute;margin-top: 225px;margin-left: 385px; font-size: 14px;">
          Concepto&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;  {{$recibo_cabecera->concepto}}
        </div>
        
        <input type="hidden" value=" {{$num= 1}}">
        
        <div style="width: 700px;position: absolute;margin-top: 300px;margin-left: 70px; font-size: 14px;">
            <table class="table table-sm" style="font-size:14px">
                <thead style="border-bottom:  1px solid black;">
                    <tr>
                        <th style="width: 10px">N.</th>
                        <th style="width: 200px" align="center">Concepto</th>
                        <th style="width: 300px" align="center">Descripción</th>
                        <th style="width: 60px" align="right">Total</th>
                    </tr>
                </thead>
               
                <tbody style="border-bottom:  1px solid black;">
                    @foreach($recibo_detalle as $detalle)
                    <tr>
                        <td style="text-align: center;">{{ $num++ }}</td>
                        <td align="center">{{$recibo_cabecera->concepto}}</td>
                        <td align="center">{{$detalle->nombre_evento}}</td>                
                        <td align="right">S/. {{$detalle->monto}}</td>        
                    </tr>
                    @endforeach 
                    
                </tbody>
                <tfoot>
                   <td colspan="4" style="text-align: right;">S/. {{number_format($recibo_detalle->sum('monto'),2,".",",")}}</td>
                </tfoot>         
            </table>
           
            <div style=" margin-top: 5px; font-size: 14px;">
                Son: &nbsp;{{$soles}}
            </div>
        </div>
         
    </body>
     
</html>

