<?php

namespace App\Http\Controllers\principal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Usuarios_u;
use App\Models\inscripcion\Inscripcion;
use App\Models\recibo\Recibo;
use Illuminate\Support\Facades\Auth;

class PrincipalController extends Controller
{
    public function index()
    {
        $paquetes = DB::table('vw_recuperar_eventos')->orderBY('id_evento','asc')->get();
        return view('principal/contenido',compact('paquetes'));
    }
    
    public function create(Request $request)
    {
        $usuario = new Usuarios_u();
        $select=DB::table('users')->where('email',$request['email'])->get();
        
        if (count($select)>0) {
            return response()->json([
                'msg' => 'si',
            ]);
        }else{
            $usuario->name     = $request['nombre']." ".$request['apaterno']." ".$request['amaterno'];
            $usuario->email    = $request['email'];
            $usuario->password = bcrypt($request['password']);
            $usuario->tipo_persona = $request['tipo_persona'];
            $usuario->nacionalidad = $request['nacionalidad'];
            $usuario->hoja_vida = "-";
            $usuario->tip_doc_ident = $request['tipo_documento'];
            $usuario->num_ident = $request['numero_identidad'];
            $usuario->qr = "-";
            $usuario->save();
            return $usuario->id;
        }
    }
    
    function autocompletar_eventos(Request $request) 
    {
        $Consulta = DB::table('evento')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id_evento;
            $Lista->label = trim($Datos->nombre_evento);
            $Lista->precio = trim($Datos->precio);
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }
    
    function insertar_datos_recibo(Request $request){
        $Recibo = new Recibo();
        $Recibo->nombre_persona = Auth::user()->name;
        $Recibo->concepto = "PAGO POR CONCEPTO DE EVENTOS";
        $Recibo->monto_total = $request['monto'];
        $Recibo->fecha_registro = date('d-m-Y');
        $Recibo->save();
        return $Recibo->id_recibo;
    }
    
    function insertar_datos_inscripcion(Request $request){
        $Inscripcion = new Inscripcion();
        $Inscripcion->id_usuario = Auth::user()->id;
        $Inscripcion->id_evento = $request['id_evento'];
        $Inscripcion->monto = $request['monto'];
        $Inscripcion->id_recibo = $request['id_recibo'];
        $Inscripcion->save();
        return $Inscripcion->id_recibo;
    }
    
}
