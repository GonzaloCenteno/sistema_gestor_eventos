<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PAGO RECIBO</title>        
    </head>
    <style>        
        @page {
            margin:0;
            padding: 0;
           
        }
    </style>
    <body style="font-family: sans-serif;">
        <img src="img/logo_cato.png" style="width: 10%;position: absolute; z-index: 10; margin-left: 15px; margin-top: 24px">
        <img src="img/credencial.jpg" style="width: 100%;position: absolute; margin-top: 24px">              
        <div style="position: absolute;margin-top: 52px;margin-left: 110px; font-size: 16px;">
            UNIVERSIDAD CATOLICA DE SANTA MARIA
        </div>
        <div style="position: absolute;margin-top: 110px;margin-left: 200px; font-size: 16px;">
            {{$credencial->name}}
        </div>
        <div style="position: absolute;margin-top: 150px;margin-left: 200px; font-size: 16px;">
            {{$credencial->email}}
        </div>
        <div style="position: absolute;margin-top: 200px;margin-left: 150px; font-size: 16px;">
           {{ $credencial->tipo_persona }}
        </div>
        <div style="position: absolute;margin-top: 230px;margin-left: 150px; font-size: 16px;">
           {{ $credencial->nacionalidad }}
        </div>
        <div style="position: absolute;margin-top: 260px;margin-left: 150px; font-size: 16px;">
           {{ $credencial->tip_doc_ident }} - {{ $credencial->num_ident }}
        </div>
        
         <div style="position: absolute;margin-top: 195px;margin-left: 80px; font-size: 16px;">
           <img style="width: 100px; height: 100px; margin-left: 250px;" src="data:image/png;base64, {{ base64_encode(\QrCode::format('png')->generate($credencial->qr))}} ">
        </div>
         
    </body>
     
</html>

