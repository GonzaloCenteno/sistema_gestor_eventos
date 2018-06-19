<?php

namespace App\Http\Controllers\paquetes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaquetesController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_paquetes' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('paquetes/vw_paquetes',compact('menu','permisos'));
    }

    public function getPaquetes(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_paquetes where descripcion like '%".strtoupper($request['descripcion'])."%'");
        $sql = DB::table('vw_paquetes')->where('descripcion','like', '%'.strtoupper($request['descripcion']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_paquete;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_paquete),
                trim($Datos->descripcion),
                trim($Datos->precio_paquete),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $decripcion = trim($request['descripcion']);

        $crear_paquete = DB::select("select crear_paquetes('".strtoupper($decripcion)."')");

    }

    public function show($id_paquete)
    {
       $Paquetes = DB::table('vw_paquetes')->where('id_paquete',$id_paquete)->get();
       return $Paquetes;
    }

    public function edit($id_paquete,Request $request)
    {
        $decripcion = trim($request['descripcion']);

        $editar_paquete = DB::select("select modificar_paquetes(".$id_paquete.", '".strtoupper($decripcion)."')");
    }

    public function destroy(Request $request)
    {
        $eliminar_paquete = DB::select("select eliminar_paquetes(".$request['id_paquete'].")");
    }

}
