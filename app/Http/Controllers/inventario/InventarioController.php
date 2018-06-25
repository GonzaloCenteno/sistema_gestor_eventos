<?php

namespace App\Http\Controllers\inventario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function getProductos(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_productos where desc_producto like '%".strtoupper($request['productos'])."%'");
        $sql = DB::table('vw_productos')->where('desc_producto','like', '%'.strtoupper($request['productos']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_producto;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_producto),
                trim($Datos->desc_producto),
                trim($Datos->precio),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $Productos = new  Productos;
        $Productos->desc_producto = strtoupper($request['desc_producto']);
        $Productos->precio = $request['precio'];
        $Productos->save();

    }

    public function show($id_producto)
    {
       $Productos = DB::table('vw_productos')->where('id_producto',$id_producto)->get();
       return $Productos;
    }

    public function edit($id_producto,Request $request)
    {
        $Productos = new  Productos;
        $val=  $Productos::where("id_producto","=",$id_producto)->first();
        if(count($val)>=1)
        {
            $val->desc_producto = strtoupper($request['desc_producto']);
            $val->precio = $request['precio'];
            $val->save();
        }
        return $id_producto;
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
