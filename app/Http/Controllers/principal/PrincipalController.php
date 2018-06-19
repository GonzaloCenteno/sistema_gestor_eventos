<?php

namespace App\Http\Controllers\principal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Usuarios_u;

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
    
}
