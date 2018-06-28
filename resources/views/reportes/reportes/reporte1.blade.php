<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte</title>
        <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
        <style>
            @page { margin-bottom: 10px !important; margin-left: 50px;margin-right: 50px;};
        </style>
  </head>
  <body>
    <main>
        <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 5px;">
            <tr>
            <td style="width: 10%; border: 0px;" >
                <img src="img/logo_cato.png" height="70px"/>
            </td>
            <td style="width: 80%; padding-top: 10px; border:0px;">
                <div id="details" class="clearfix">
                  <div id="invoice" >
                     <h1>Universidad Católica de Santa María</h1>
                      <div class="sub2">Escuela Profesional de Ingeniería de Sistemas</div>
                  </div>
                    <div style="width: 90%; border-top:1px solid #999; margin-top: 10px; margin-left: 25px;"></div>
                </div>
            </td>
            <td style="width: 10%;border: 0px;"></td>
            </tr>
            
        </table>
        
        <center><div Class="asunto" style="margin-top: 0px;"><b>Reporte Cantidad de Inscritos
                </b></div></center>
        <br>             
         
        <input type="hidden" value=" {{$num=1}}">
        <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px; margin-top: 10px" >
        <thead>
          <tr>
              <th style="width: 5%">N°</th>
              <th style="width: 10%">DNI</th>
              <th style="width: 75%">Nombre</th>
              
          </tr>
        </thead>
        <tbody>
          
          @foreach ($sql as $rep)
          <tr>
              <td style="text-align: center;font-size: 0.7em; padding: 0px;">{{$num++}}</td>
              <td style="text-align: center;font-size: 0.7em; padding: 0px;">{{$rep->num_ident}}</td>
              <td style="text-align: left;font-size: 0.7em; padding: 0px;">{{strtoupper($rep->name)}}</td>
          </tr>
          @endforeach
          
           
        </tbody>
      </table>
  </body>
</html>
