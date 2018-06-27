<?php

namespace App\Http\Controllers\inventario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\inventario\Inventario;
use App\Models\inventario\Material;

class InventarioController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_inventario' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('inventario/vw_inventario',compact('menu','permisos'));
    }

    public function getInventario(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_inventario where nombre_material like '%".strtoupper($request['nombre'])."%'");
        $sql = DB::table('vw_inventario')->where('nombre_material','like', '%'.strtoupper($request['nombre']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
                trim($Datos->sctock),
            );
        }
        return response()->json($Lista);
    }
    
    public function getInventario_entradas(Request $request)
    {
        header('Content-type: application/json');
        
        $id_material = $request['id_material'];
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from vw_entradas where id_material = '$id_material' ");
        $sql = DB::table('vw_entradas')->where('id_material',$id_material)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
                trim($Datos->cantidad),
                trim($Datos->fecha_registro),
                trim($Datos->nombre_material),
            );
        }
        return response()->json($Lista);
    }
    
    public function getInventario_salidas(Request $request)
    {
        header('Content-type: application/json');
        $id_material = $request['id_material'];
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from vw_salidas where id_material = '$id_material' ");
        $sql = DB::table('vw_salidas')->where('id_material',$id_material)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
                trim($Datos->cantidad),
                trim($Datos->fecha_registro),
                trim($Datos->nombre_material),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $datos = DB::table('inventario')->where('id_material',$request['id_material'])->first();
        if ($datos) {
            return response()->json([
                'msg' => 'repetido',
            ]);
        }
        else{
            $Inventario = new  Inventario;
            $Inventario->id_material = $request['id_material'];
            $Inventario->save();
        }

    }

    public function show($id_material)
    {
       $inventario = DB::table('vw_inventario')->where('id_material',$id_material)->get();
       return $inventario;
    }

    public function edit($id_material,Request $request)
    {
        $Material = new Material;
        $val=  $Material::where("id_material","=",$id_material)->first();
        if($val)
        {
            $val->sctock = $val->sctock + $request['stock'];
            $val->save();
        }
        return $id_material;
    }

    public function destroy(Request $request)
    {
        $Productos = new  Productos;
        $val=  $Productos::where("id_producto","=",$request['id_producto'] )->first();
        if(count($val)>=1)
        {
            $val->delete();
        }
        return "destroy ".$request['id_producto'];
    }

}
