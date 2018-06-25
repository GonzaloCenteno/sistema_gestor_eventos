<?php

namespace App\Http\Controllers\caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\recibo\Recibo;


class EmisionRecibosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_emision_recibos' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('caja/vw_emision_recibos',compact('menu','permisos'));
    }
    
    function autocompletar_productos(Request $request) 
    {
        $Consulta = DB::table('productos')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id_producto;
            $Lista->label = trim($Datos->desc_producto);
            $Lista->precio = trim($Datos->precio);
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }

    public function getRecibosProductos(Request $request)
    {
        header('Content-type: application/json');
        $productos = $request['productos'];
        
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from vw_recibo_productos where concepto like '%".strtoupper($productos)."%'");
        $sql = DB::table('vw_recibo_productos')->where('concepto','like', '%'.strtoupper($productos).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id_recibo;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_recibo),
                trim($Datos->nro_recibo),
                trim($Datos->nombre_persona),
                trim($Datos->concepto),
                trim($Datos->monto_total),
                trim($Datos->fecha_registro),
                trim($Datos->estado),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $Recibo = new  Recibo;
        $Recibo->nombre_persona = strtoupper($request['persona']);
        $Recibo->concepto = $request['concepto'];
        $Recibo->monto_total = $request['monto_total'];
        $Recibo->estado = 0;
        $Recibo->fecha_registro = date('d-m-Y');
        $Recibo->id_usuario = 0;
        $Recibo->save();

    }

    public function show($id_producto)
    {
      
    }

    public function edit($id_recibo,Request $request)
    {
        $Recibo = new  Recibo;
        $val=  $Recibo::where("id_recibo","=",$id_recibo)->first();
        if(count($val)>=1)
        {
            $val->estado = 2;
            $val->save();
        }
        return $id_recibo;
    }

    public function destroy(Request $request)
    {
        
    }

}
