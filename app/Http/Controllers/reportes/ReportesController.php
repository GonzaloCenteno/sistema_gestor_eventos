<?php

namespace App\Http\Controllers\reportes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class ReportesController extends Controller
{

    public function index()
    {
       
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_reportes' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
          $TIP =  DB::table('users')->orderBy('tipo_persona', 'desc')->get();
          $evento =  DB::table('vw_eventos')->orderBy('nombre_evento', 'desc')->get();

        return view('reportes/vw_reportes', compact('menu','permisos','evento'));
    }

     public function ver_reporte($tip,Request $request)
    {
        if($tip=='1'){  return $this->rep_1($request);  }
        if($tip=='2'){  return $this->rep_2($request);  }
        if($tip=='3'){  return $this->rep_3($request);  }
        if($tip=='4'){  return $this->rep_4($request);  }
        if($tip=='4'){  return $this->rep_11($request);  }
        if($tip=='4'){  return $this->rep_12($request);  }
        if($tip=='4'){  return $this->rep_13($request);  }
        if($tip=='4'){  return $this->rep_14($request);  }
        if($tip=='4'){  return $this->rep_15($request);  }
        if($tip=='4'){  return $this->rep_16($request);  }
        if($tip=='4'){  return $this->rep_17($request);  }
        if($tip=='4'){  return $this->rep_19($request);  }
        if($tip=='4'){  return $this->rep_20($request);  }
        if($tip=='4'){  return $this->rep_21($request);  }
        if($tip=='4'){  return $this->rep_22($request);  }
        if($tip=='4'){  return $this->rep_23($request);  }
        if($tip=='4'){  return $this->rep_24($request);  }
        if($tip=='4'){  return $this->rep_25($request);  }
        if($tip=='4'){  return $this->rep_26($request);  }
    
    }
    
    public function rep_1(Request $request)
    {
        $evento = $request['evento'];
        $tipo = $request['tipo'];
        $fechainicio = $request['ini'];
        $fechafin = $request['fin'];        $sql = DB::select(" select name,num_ident  from vw_reporte1 WHERE tipo_persona = '$tipo' and id_evento = '$evento' and fecha_registro between '$fechainicio' and '$fechafin' " );
            if(count($sql)>0)
            {
                $aux='0';
                $view =  \View::make('reportes.reportes.reporte1', compact('sql','evento','tipo','fecha'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a4');
                return $pdf->stream("REPORTE".".pdf");
            }
            else
            {
                return 'NO HAY RESULTADOS';
            }
    }
    public function rep_2(Request $request)
    {
        $evento = $request['evento'];
        $sql = DB::select(" select *  from vw_reporte2 WHERE  id_evento = '$evento' " );
            if(count($sql)>0)
            {
                $aux='0';
                $view =  \View::make('reportes.reportes.reporte2', compact('sql','evento'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a4');
                return $pdf->stream("REPORTE".".pdf");
            }
            else
            {
                return 'NO HAY RESULTADOS';
            }
    }
    public function rep_3(Request $request)
    {
        $evento = $request['evento'];
        $sql = DB::select(" select *  from vw_reporte2 WHERE  id_evento = '$evento' " );
            if(count($sql)>0)
            {
                $aux='0';
                $view =  \View::make('reportes.reportes.reporte2', compact('sql','evento'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a4');
                return $pdf->stream("REPORTE".".pdf");
            }
            else
            {
                return 'NO HAY RESULTADOS';
            }
    }
    
    
    
    
    
     public function rep_por_tributo(Request $request)
    {
        $id_tributo = $request['id_tributo'];
        $fechainicio = $request['ini'];
        $fechafin = $request['fin'];
        $institucion = DB::select('SELECT * FROM maysa.institucion');
       // $sql=DB::table('presupuesto.vw_por_tributo')->where('id_tributo',$id_tributo) ->whereBetween('fecha', [$fechainicio, $fechafin])->orderBy('fecha','asc')->get();
        $sql = DB::select(" select  fecha,id_tributo,cod_tributo,descrip_tributo, sum(total) as total from presupuesto.vw_por_tributo where id_tributo='$id_tributo' and fecha between '$fechainicio' and '$fechafin' group by fecha,id_tributo,cod_tributo,descrip_tributo  order by fecha asc" );
        
        if(count($sql)>0)
        {
            $view =  \View::make('tesoreria.reportes.rep_por_tributo', compact('sql','fechainicio','fechafin','institucion'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream("PRUEBA".".pdf");
        }
        else
        {
            return 'NO HAY RESULTADOS';
        }
        
    }
}