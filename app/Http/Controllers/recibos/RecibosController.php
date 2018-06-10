<?php

namespace App\Http\Controllers\recibos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecibosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_recibos' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('recibos/vw_recibos ',compact('menu','permisos'));
    }

    public function getRecibos(Request $request)
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
        $totalg = DB::select("select count(*) as total from tesoreria.vw_recibos where concepto like '%".$request['concepto']."%'");
        $sql = DB::table('tesoreria.vw_recibos')->where('concepto','like', '%'.$request['concepto'].'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->numero_recibo;
            if($Datos->estado == 0) {
              $nuevo = '<button class="btn btn-labeled btn-default" type="button">GENERADO</button>';
            }
            if($Datos->estado == 1){
               $nuevo = '<button class="btn btn-labeled btn-primary" type="button">PAGADO</button>'; 
            }
            if($Datos->estado == 2){
               $nuevo = '<button class="btn btn-labeled btn-danger" type="button">ANULADO</button>'; 
            }            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->numero_recibo),
                trim($Datos->name),
                trim($Datos->concepto),
                trim($Datos->monto_total),
                trim($Datos->tipo_recibo),
                trim($Datos->tipo_paquete),
                $nuevo,
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $id_persona = $request['id_persona'];
        $concepto = $request['concepto'];
        $monto = $request['monto'];
        $tipo_recibo = $request['tipo_recibo'];
        $tipo_paquete = $request['tipo_paquete'];

        $crear_recibo = DB::select("select tesoreria.crear_recibos(".$id_persona.",'".$concepto."',".$monto.",'".$tipo_recibo."','".$tipo_paquete."')");

    }

    public function show($id_material)
    {
       
    }

    public function edit($id_material,Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        
    }

}
