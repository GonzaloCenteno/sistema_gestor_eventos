<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios_u;
use App\Models\configuracion\Permiso_Modulo_Usuario;

class UsuariosController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_usuarios' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('configuracion/vw_usuarios',compact('menu','permisos'));
    }

    public function getUsuarios(Request $request)
    {
        $user = $request['user'];
        $totalg = DB::select("select count(id) as total from vw_usuarios where name like '%".strtoupper($user)."%'");
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

        $sql = DB::table('public.vw_usuarios')->where('name','like','%'.strtoupper($user).'%')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
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
                trim($Datos->created_at)
            );
        }

        return response()->json($Lista);
    }

    function get_datos_usuario(Request $request) {
        $usuario = DB::table('users')->where('id', $request['id'])->get();

        $Lista = new \stdClass();
        foreach ($usuario as $Datos) {
            $Lista->id = trim($Datos->id);
            $Lista->name = trim($Datos->name);
            $Lista->email = trim($Datos->email);
            $Lista->created_at = trim($Datos->created_at);
        }
        return response()->json($Lista);
    }

    public function create(Request $request)
    {
        $data = new Usuarios_u();
        $data->name     = strtoupper($request['usuario']);
        $data->email    = $request['email'];
        $data->password = bcrypt($request['numero_identidad']);
        $data->tipo_persona = $request['tipo_persona'];
        $data->nacionalidad = $request['nacionalidad'];
        $data->tip_doc_ident = $request['tipo_documento'];
        $data->num_ident = $request['numero_identidad'];
        $data->save();
        return $data->id;
    }

    public function destroy(Request $request)
    {
        $permiso=new Permiso_Modulo_Usuario;
        $val=  $permiso::where("id_usu","=", $request['id_usuario']);
        if(count($val)>=1)
        {
            $val->delete();
        }
        $this->destroy_usuario($request['id_usuario']);
    }
    public function destroy_usuario($id_usuario){
        $data = new Usuarios_u();
        $val=  $data::where("id","=",$id_usuario )->first();
        if(count($val)>=1)
        {
            $val->delete();
        }
        return "destroy";
    }
}
