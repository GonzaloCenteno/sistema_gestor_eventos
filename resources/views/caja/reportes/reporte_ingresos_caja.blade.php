<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REPORTE DE INGRESOS EN CAJA</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        .move-ahead { counter-increment: page 2; position: absolute; visibility: hidden; }
        .pagenum:after { content:' ' counter(page); }
       .footer {position: fixed }

    </style>
</head>
    <footer class="footer" style="font-size:0.8em; text-align: left; padding-top: 5px; padding-left: 10px;"><b>Impreso Por:&nbsp; </b>{{$usuario[0]->name}}</footer>

<body>
    <div class="datehead" style="font-size:0.7em;">{{ $fecha }}</div>
    <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0px;">
        <tr>
            <td style="width: 10%; border: 0px;" >
                <img src="img/logo_cato.png" height="60px"/>
            </td>
            <td style="width: 80%; padding-top: 0px; border:0px;">
                <div id="details" class="sub2">
                    <div id="invoice" style="font-size:1em" >
                        <h1>Universidad Catolica de Santa Maria - 2018</h1>
                    </div>
                    <div  style="width: 95%; border-top:1px solid #999; margin-top: 5px; margin-left: 25px"></div>
                </div>
            </td>
            <td style="width: 10%;border: 0px;"></td>
        </tr>

    </table>

    <center><div Class="asunto" style="margin-top: 1px;font-size:0.8em;"><b>REPORTE DE INGRESOS EN CAJA</b></div></center>
    <div class="subasunto" style=" margin-bottom:5px; text-align: left; padding-left: 30px;font-size:0.7em;"> 
        <br>
        UCSM - 2018
        
    </div>
    
    <input type="hidden" value=" {{$num= 1}}">

    <div class="lado3" style="height: 435px; margin-bottom: 20px;">
        <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px; margin-top: 0px;  font-size: 1.4em;">
            <thead>
            <tr >
                <th style="width: 5%;">N°</th>
                <th style="width: 10%">Nº RECIBO</th>
                <th style="width: 30%;">PERSONA</th>
                <th style="width: 33%;">CONCEPTO</th>
                <th style="width: 12%">FECHA PAGO</th>
                <th style="width: 10%">MONTO TOTAL</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($sql as $cont)
                <tr>
                    <td style="text-align: center;">{{ $num++ }}</td>
                    <td style="text-align: center;">{{$cont->nro_recibo}}</td>
                    <td style="text-align: center;">{{ $cont->nombre_persona }}</td>
                    <td style="text-align: center;">{{$cont->concepto}}</td>
                    <td style="text-align: center;">{{$cont->fecha_pago}}</td>
                    <td style="text-align: center;">S./ {{$cont->monto_total}}</td>
                </tr>
                
            @endforeach

            </tbody>
        </table>
        <div class="sub2" style="text-align: right; padding-right: 7px; font-size: 1.4em;"><b>TOTAL:&nbsp;&nbsp;&nbsp; </b>S/. {{ number_format($sql->sum('monto_total'),2,'.',',')  }}</div>
    </div>
</body>

</html>