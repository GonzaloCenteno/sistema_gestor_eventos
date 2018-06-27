<?php

namespace App\Http\Controllers\control;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\control\Asistencia;


class AsistenciaController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_productos' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('control/vw_asistencia',compact('menu','permisos'));
    }
    
    public function buscar_nro_recibo(Request $request)
    {
        $nro_recibo = $request['nro_recibo'];
        $recibo = DB::table('vw_impresion_recibo_cabecera')->where('nro_recibo',strtoupper($nro_recibo))->first();
        
        if ($recibo) {
            
            $datos_recibo = DB::table('vw_asistencias_persona')->where('nro_recibo',$recibo->nro_recibo)->first();
            if ($datos_recibo) {
                return response()->json([
                    'msg' => 'existe',
                ]);
            }else{
                return response()->json([
                    'msg' => 'si',
                    'concepto' => $recibo->concepto,
                    'name' => $recibo->name,
                    'tipo_persona' => $recibo->tipo_persona,
                    'nacionalidad' => $recibo->nacionalidad,
                    'tip_doc_ident' => $recibo->tip_doc_ident,
                    'num_ident' => $recibo->num_ident,
                    'id' => $recibo->id,
                ]);
            }
        }else{
            return response()->json([
                'msg' => 'no',
                ]);
        }
    }
    
    public function buscar_eventos_by_usuarios(Request $request){
        header('Content-type: application/json');
        $indice = $request['indice'];
        
        if ($indice == 0) {
            $totalg = DB::select("select count(*) as total from vw_asistencias where id_usuario = 0");
        }else{
            $totalg = DB::select("select count(*) as total from vw_asistencias where id_usuario = '$indice'");
        }
        
        
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];

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
        $start = ($limit * $page) - $limit; 
        if ($start < 0) {
            $start = 0;
        }

     
        if ($indice == 0) {
            $sql = DB::table('vw_asistencias')->where('id_usuario',0)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        }else{
            $sql = DB::table('vw_asistencias')->where('id_usuario',$indice)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        }
        
        
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        
        $variable = 0;

        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->id_turno;
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_turno),
                trim($Datos->nombre_evento),
                '<div class="checkbox"><label><input name="estado_asistencia" id_turno = '.$Datos->id_turno.' id_usuario = '.$Datos->id_usuario.' type="checkbox"  "></label></div>',
                $variable,
            );
        }

        return response()->json($Lista);

    }

    public function getAsistencia_persona(Request $request)
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
        $totalg = DB::select("select count(*) as total from vw_asistencias_persona where name like '%".strtoupper($request['nombre'])."%'");
        $sql = DB::table('vw_asistencias_persona')->where('name','like', '%'.strtoupper($request['nombre']).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
                trim($Datos->tip_doc_ident),
                trim($Datos->num_ident),
            );
        }
        return response()->json($Lista);
    }

    public function create(Request $request){

        $Asistencia = new  Asistencia;
        $Asistencia->hora_entrada = date('h:i:s A');
        $Asistencia->id_persona = $request['id_usuario'];
        $Asistencia->id_turno = $request['id_turno'];
        $Asistencia->estado = $request['estado'];
        $Asistencia->save();

    }

    public function show($id_usuario)
    {
       $Asistencias = DB::table('vw_impresion_recibo_cabecera')->where('id',$id_usuario)->get();
       return $Asistencias;
    }

    public function edit($id_asistencia,Request $request)
    {
        $Asistencia = new  Asistencia;
        $val=  $Asistencia::where("id_asistencia","=",$id_asistencia)->where("id_turno","=",$request['id_turno'])->where("id_persona","=",$request['id_usuario'])->first();
        if($val)
        {
            $val->estado = $request['estado'];
            $val->save();
        }
        return $id_asistencia;
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
    
    public function recuperar_asistencias(Request $request){
        header('Content-type: application/json');
        $indice = $request['indice'];
        
        if ($indice == 0) {
            $totalg = DB::select("select count(*) as total from vw_recuperar_asistencias where id_persona = 0");
        }else{
            $totalg = DB::select("select count(*) as total from vw_recuperar_asistencias where id_persona = '$indice'");
        }
        
        
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];

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
        $start = ($limit * $page) - $limit; 
        if ($start < 0) {
            $start = 0;
        }

     
        if ($indice == 0) {
            $sql = DB::table('vw_recuperar_asistencias')->where('id_persona',0)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        }else{
            $sql = DB::table('vw_recuperar_asistencias')->where('id_persona',$indice)->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        }
        
        
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;

        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->id_turno;
            if ($Datos->estado == 1) {
              $nuevo = '<div class="checkbox"><label><input name="estado_asistencia_1" id_asistencia = '.$Datos->id_asistencia.' id_turno = '.$Datos->id_turno.' id_usuario = '.$Datos->id_persona.' type="checkbox"  checked="true" "></label></div>';
            }else{
              $nuevo = '<div class="checkbox"><label><input name="estado_asistencia_1" id_asistencia = '.$Datos->id_asistencia.' id_turno = '.$Datos->id_turno.' id_usuario = '.$Datos->id_persona.' type="checkbox"  "></label></div>';
            }
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_turno),
                trim($Datos->nombre_evento),
                $nuevo,
                trim($Datos->id_asistencia),
            );
        }

        return response()->json($Lista);

    }
    
    function autocompletar_materiales(Request $request) 
    {
        $Consulta = DB::table('materiales')->get();
        $todo = array();
        foreach ($Consulta as $Datos) {
            $Lista = new \stdClass();
            $Lista->value = $Datos->id_material;
            $Lista->label = trim(strtoupper($Datos->nombre_material));
            $Lista->stock = $Datos->sctock;
            array_push($todo, $Lista);
        }
        return response()->json($todo);
    }
    
    public function agregar_materiales_asistencia($id_asistencia, Request $request){
        $Asistencia = new  Asistencia;
        $val=  $Asistencia::where("id_asistencia","=",$id_asistencia)->where("id_persona","=",$request['id_usuario'])->where("id_turno","=",$request['id_turno'])->first();
        if($val)
        {
            $val->id_material = $request['id_material'];
            $val->cantidad_material = $request['cantidad'];
            $val->save();
        }
        return $id_asistencia;
    }

}
