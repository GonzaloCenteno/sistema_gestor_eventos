<?php

namespace App\Http\Controllers\control;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CredencialesController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_credenciales' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('control/vw_credenciales',compact('menu','permisos'));
    }

    public function getCredenciales(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_usuarios where name like '%".strtoupper($request['nombre'])."%' and estado = 3");
        $sql = DB::table('vw_usuarios')->where('name','like', '%'.strtoupper($request['nombre']).'%')->where('estado', 3)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
            $Lista->rows[$Index]['id'] = $Datos->id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id),
                trim($Datos->name),
                trim($Datos->email),
                trim($Datos->tipo_persona),
                trim($Datos->nacionalidad),
                '<button class="btn btn-success bg-color-blueDark txt-color-white" type="button" onclick="ver_credencial('.trim($Datos->id).')"><span class="btn-label"><i class="fa fa-file-text-o"></i></span> VER CREDENCIAL</button>',
            );
        }
        return response()->json($Lista);
    }
    
    public function ver_credenciales($id_usuario)
    {
        $credencial = DB::table('users')->where('id', $id_usuario)->first();
        $fecha = (date('d/m/Y H:i:s'));
        
        if($credencial)
        { 
            $view =  \View::make('control.reportes.credenciales', compact('credencial', 'fecha'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a6','landscape');
            return $pdf->stream("CREDENCIAL".".pdf");
        }
        else
        {
            return 'NO HAY REGISTROS PARA ESTA PERSONA';
        }
    }

    public function create(Request $request){

    }

    public function show($id_producto)
    {
       
    }

    public function edit($id_producto,Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        
    }

}
