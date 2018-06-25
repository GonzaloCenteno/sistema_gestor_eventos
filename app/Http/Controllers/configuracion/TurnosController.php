<?php

namespace App\Http\Controllers\configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\configuracion\Turnos;


class TurnosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_turno' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('configuracion/vw_turnos',compact('menu','permisos'));
    }
    
    function autocompletar_auditorios(Request $request) 
    {
        $Consulta = DB::table('auditorio')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id_auditorio;
            $Lista->label = trim($Datos->nombre_auditorio);
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }

    public function getTurnos(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_turno where desc_turno like '%".strtoupper($request['turnos'])."%'");
        $sql = DB::table('vw_turno')->where('desc_turno','like', '%'.strtoupper($request['turnos']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_turno;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_turno),
                trim($Datos->desc_turno),
                trim($Datos->hora_inicio),
                trim($Datos->hora_fin),
                trim($Datos->nombre_auditorio),
                trim($Datos->nombre_evento)
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $Turnos = new Turnos;
        $Turnos->desc_turno = strtoupper($request['desc_turno']);
        $Turnos->hora_inicio = $request['hora_inicio'];
        $Turnos->hora_fin = $request['hora_fin'];
        $Turnos->id_auditorio = $request['id_auditorio'];
        $Turnos->id_evento = $request['id_evento'];
        $Turnos->save();

    }

    public function show($id_turno)
    {
       $Turnos = DB::table('vw_turno')->where('id_turno',$id_turno)->get();
       return $Turnos;
    }

    public function edit($id_turno,Request $request)
    {
        $Turnos = new Turnos;
        $val=  $Turnos::where("id_turno","=",$id_turno)->first();
        if(count($val)>=1)
        {
            $val->desc_turno = trim(strtoupper($request['desc_turno']));
            $val->hora_inicio = $request['hora_inicio'];
            $val->hora_fin = $request['hora_fin'];
            $val->id_auditorio = $request['id_auditorio'];
            $val->id_evento = $request['id_evento'];
            $val->save();
        }
        return $id_turno;
    }

    public function destroy(Request $request)
    {
        $Turnos = new Turnos;
        $val=  $Turnos::where("id_turno","=",$request['id_turno'] )->first();
        if(count($val)>=1)
        {
            $val->delete();
        }
        return "destroy ".$request['id_turno'];
    }

}
