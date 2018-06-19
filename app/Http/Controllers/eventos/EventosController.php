<?php

namespace App\Http\Controllers\eventos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\eventos\Eventos;

class EventosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_eventos' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        $paquetes = DB::table('paquete')->orderBY('id_paquete','asc')->get();
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('eventos/vw_eventos',compact('menu','permisos','paquetes'));
    }

    public function getEventos(){
        $eventos = DB::select('SELECT id_evento as id, nombre_evento as title, fecha_inicio as start, fecha_fin as end, color FROM vw_eventos');
        return response()->json($eventos);
    }

    public function createEvento(Request $request){
        
        $file = $request->file('mdl_img_evento');
        $Eventos = new  Eventos;
        $Eventos->nombre_evento = $request['mdl_nombre_evento'];
        $Eventos->tipo_evento = $request['mdl_tipo_evento'];
        $Eventos->precio = $request['mdl_precio'];
        if ($file) {
            $file_1 = \File::get($file);
            $Eventos->img_evento = base64_encode($file_1);
        }else{
            $Eventos->img_evento = "";
        }
        $Eventos->color = $request['mdl_color'];
        $Eventos->fecha_inicio = date("Y-m-d", strtotime($request['mdl_fecha_inicio']))." ".date("H:m:s", strtotime($request['mdl_hora_inicio']));
        $Eventos->fecha_fin = date("Y-m-d", strtotime($request['mdl_fecha_fin']))." ".date("H:m:s", strtotime($request['mdl_hora_fin']));
        $Eventos->id_paquete = $request['mdl_paquetes'];
        
        $Eventos->save();

        //return $request['nombre_evento'];
        $eventos = DB::select("SELECT id_evento as id, nombre_evento as title, fecha_inicio as start, fecha_fin as end, color FROM vw_eventos where id_evento = $Eventos->id_evento");
        return response()->json($eventos);
    }

    public function updateFecha(Request $request){
        $Eventos = new  Eventos;
        $val=  $Eventos::where("id_evento","=",$request['id_evento'])->first();
        if(count($val)>=1)
        {
            $val->fecha_inicio = $request['fecha_inicio'];
            $val->fecha_fin    = $request['fecha_fin'];
            $val->save();
        }
        return $request['id_evento'];
    }

    public function deleteEvento(Request $request){
        $Eventos = new  Eventos;
        $val=  $Eventos::where("id_evento","=",$request['id_evento'] )->first();
        if(count($val)>=1)
        {
            $val->delete();
        }
        return "destroy ".$request['id_evento'];
    }

    public function show($id)
    {
        $eventos= DB::table('vw_recuperar_eventos')->where('id_evento',$id)->get();
        return $eventos;
    }

    public function editar_evento($id,Request $request)
    { 
        $file = $request->file('mdl_img_evento');
        $Eventos = new Eventos;
        $val=  $Eventos::where("id_evento","=",$id )->first();
        $datos = DB::table('evento')->where('id_evento',$id)->get();
        if(count($val)>=1)
        {
            $val->nombre_evento = $request['mdl_nombre_evento'];
            $val->tipo_evento = $request['mdl_tipo_evento'];
            $val->precio = $request['mdl_precio'];
            if ($file) {
                $file_1 = \File::get($file);
                $val->img_evento = base64_encode($file_1);
            }else{
                $val->img_evento = $datos[0]->img_evento;
            }
            $val->fecha_inicio = date("Y-m-d", strtotime($request['mdl_fecha_inicio']))." ".date("H:m:s", strtotime($request['mdl_hora_inicio']));
            $val->fecha_fin = date("Y-m-d", strtotime($request['mdl_fecha_fin']))." ".date("H:m:s", strtotime($request['mdl_hora_fin']));
            $val->color = $request['mdl_color'];
            $val->id_paquete = $request['mdl_paquetes'];
            $val->save();
        }
        
        $eventos = DB::select("SELECT id_evento as id, nombre_evento as title, fecha_inicio as start, fecha_fin as end, color FROM vw_eventos where id_evento = $id");
        return response()->json($eventos);
    }
}
