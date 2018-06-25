<?php

namespace App\Http\Controllers\configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\configuracion\Actividad;


class ActividadController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_actividad' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('configuracion/vw_actividad',compact('menu','permisos'));
    }
    
    function autocompletar_turnos(Request $request) 
    {
        $Consulta = DB::table('turno')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id_turno;
            $Lista->label = trim($Datos->desc_turno);
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }
    
    function autocompletar_ponentes(Request $request) 
    {
        $Consulta = DB::table('users')->where('tipo_persona','PONENTE')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id;
            $Lista->label = trim($Datos->name);
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }

    public function getActividad(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from vw_actividades where nombre_actividad like '%".strtoupper($request['actividades'])."%'");
        $sql = DB::table('vw_actividades')->where('nombre_actividad','like', '%'.strtoupper($request['actividades']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->id_actividad;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_actividad),
                trim($Datos->nombre_actividad),
                trim($Datos->desc_turno),
                trim($Datos->name)
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $Actividad = new Actividad;
        $Actividad->nombre_actividad = trim(strtoupper($request['nombre_actividad']));
        $Actividad->id_turno = $request['id_turno'];
        $Actividad->id_ponente = $request['id_ponente'];
        $Actividad->save();

    }

    public function show($id_actividad)
    {
       $Actividad = DB::table('vw_actividades')->where('id_actividad',$id_actividad)->get();
       return $Actividad;
    }

    public function edit($id_actividad,Request $request)
    {
        $Actividad = new Actividad;
        $val=  $Actividad::where("id_actividad","=",$id_actividad)->first();
        if($val)
        {
            $val->nombre_actividad = trim(strtoupper($request['nombre_actividad']));
            $val->id_turno = $request['id_turno'];
            $val->id_ponente = $request['id_ponente'];
            $val->save();
        }
        return $id_actividad;
    }

    public function destroy(Request $request)
    {
        $Actividad = new Actividad;
        $val=  $Actividad::where("id_actividad","=",$request['id_actividad'] )->first();
        if($val)
        {
            $val->delete();
        }
        return "destroy ".$request['id_actividad'];
    }

}
