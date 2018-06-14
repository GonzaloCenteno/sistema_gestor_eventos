<?php

namespace App\Http\Controllers\turno;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TurnoController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_actividad' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('actividad/vw_actividad',compact('menu','permisos'));
    }

    public function getMateriales(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_materiales where nombre_material like '%".$request['materiales']."%'");
        $sql = DB::table('vw_materiales')->where('nombre_material','like', '%'.$request['materiales'].'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_material;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_material),
                trim($Datos->nombre_material),
                trim($Datos->tipo_material),
                trim($Datos->sctock),
                trim($Datos->id_pers),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $nombre_material = $request['nombre_material'];
        $tipo_material = $request['tipo_material'];
        $stock = $request['stock'];

        $crear_material = DB::select("select crear_materiales('".$nombre_material."', '".$tipo_material."', ".$stock.", ". Auth::user()->id .")");

    }

    public function show($id_material)
    {
       $Materiales = DB::table('vw_materiales')->where('id_material',$id_material)->get();
       return $Materiales;
    }

    public function edit($id_material,Request $request)
    {
        $nombre_material = $request['nombre_material'];
        $tipo_material = $request['tipo_material'];
        $stock = $request['stock'];

        $editar_material = DB::select("select modificar_materiales(".$id_material.", '".$nombre_material."', '".$tipo_material."', ".$stock.")");
    }

    public function destroy(Request $request)
    {
        $eliminar_material = DB::select("select eliminar_materiales('".$request['id_material']."')");
    }

}
