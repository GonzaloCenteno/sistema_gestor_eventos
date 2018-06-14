<?php

namespace App\Http\Controllers\auditorios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuditoriosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_auditorios' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('auditorios/vw_auditorios',compact('menu','permisos'));
    }

    public function getAuditorios(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_auditorios where capacidad like '%".$request['auditorios']."%'");
        $sql = DB::table('vw_auditorios')->where('capacidad','like', '%'.$request['auditorios'].'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_auditorio;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_auditorio),
                trim($Datos->nombre_auditorio),
                trim($Datos->capacidad),
                 trim($Datos->disponibilidad),
                trim($Datos->ubicacion),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $capacidad = $request['capacidad'];
        $ubicacion = $request['ubicacion'];
        $nombre = $request['nombre'];
        $disponibilidad = $request['disponibilidad'];

        $crear_auditorio = DB::select("select crear_auditorios('".$nombre."','".$disponibilidad."','".$capacidad."','".$ubicacion."', ". Auth::user()->id .")");

    }

    public function show($id_auditorio)
    {
       $Auditorios = DB::table('configuracion.vw_auditorios')->where('id_auditorio',$id_auditorio)->get();
       return $Auditorios;
    }

    public function edit($id_auditorio,Request $request)
    {
        $capacidad = $request['capacidad'];
        $ubicacion = $request['ubicacion'];

        $editar_auditorio = DB::select("select configuracion.modificar_auditorios('".$id_auditorio."','".$capacidad."','".$ubicacion."')");
    }

    public function destroy(Request $request)
    {
        $eliminar_auditorio = DB::select("select configuracion.eliminar_auditorios('".$request['id_auditorio']."')");
    }

}
