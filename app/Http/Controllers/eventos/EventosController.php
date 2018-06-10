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
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('eventos/vw_eventos',compact('menu','permisos'));
    }

    public function getEventos(){
        $eventos = DB::select('SELECT id_evento as id, nombre as title, fecha_inicio as start, fecha_fin as end, color FROM eventos.vw_eventos');
        return response()->json($eventos);
    }

    public function createEvento(Request $request){
        $Eventos = new  Eventos;
        $Eventos->nombre = $request['evento'];
        $Eventos->fecha_inicio = date("Y-m-d", strtotime($request['fecha_inicio']))." ".date("H:m:s", strtotime($request['hora_inicio']));
        $Eventos->fecha_fin = date("Y-m-d", strtotime($request['fecha_fin']))." ".date("H:m:s", strtotime($request['hora_fin']));
        $Eventos->color = $request['color'];
        $Eventos->save();

        //return $request['nombre_evento'];
        $eventos = DB::select("SELECT id_evento as id, nombre as title, fecha_inicio as start, fecha_fin as end, color FROM eventos.vw_eventos where id_evento = $Eventos->id_evento");
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
        $eventos= DB::table('eventos.vw_recuperar_eventos')->where('id_evento',$id)->get();
        return $eventos;
    }

    public function edit($id,Request $request)
    { 
        $Eventos = new Eventos;
        $val=  $Eventos::where("id_evento","=",$id )->first();
        if(count($val)>=1)
        {
            $val->nombre = $request['evento'];
            $val->fecha_inicio = date("Y-m-d", strtotime($request['fecha_inicio']))." ".date("H:m:s", strtotime($request['hora_inicio']));
            $val->fecha_fin = date("Y-m-d", strtotime($request['fecha_fin']))." ".date("H:m:s", strtotime($request['hora_fin']));
            $val->color = $request['color'];
            $val->save();
        }
        
        $eventos = DB::select("SELECT id_evento as id, nombre as title, fecha_inicio as start, fecha_fin as end, color FROM eventos.vw_eventos where id_evento = $id");
        return response()->json($eventos);
    }
}
