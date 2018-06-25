<?php

namespace App\Http\Controllers\caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\recibo\Recibo;

class CajaController extends Controller
{
    public function index()
    {
        $permisos = DB::select("SELECT * from permisos.vw_permisos where id_sistema='li_config_caja' and id_usu=".Auth::user()->id);
        $menu = DB::select('SELECT * from permisos.vw_permisos where id_usu='.Auth::user()->id);
        if(count($permisos)==0)
        {
            return view('errors/sin_permiso',compact('menu','permisos'));
        }
        return view('caja/vw_caja',compact('menu','permisos'));
    }

    public function getRecibosEmititos(Request $request)
    {
        header('Content-type: application/json');
        $estado = $request['estado'];
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from vw_recibos_emitidos where estado = '$estado' and fecha_registro between '$fecha_inicio' and '$fecha_fin' ");
        $sql = DB::table('vw_recibos_emitidos')->where('estado',$estado)->whereBetween('fecha_registro', [$fecha_inicio, $fecha_fin])->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();

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
                trim($Datos->hora_pago),
                trim($Datos->estado),
                trim($Datos->id_usuario),
            );
        }
        return response()->json($Lista);
    }
    
    function imprimir_recibo(Request $request) {
        $id_recibo = $request['id_recibo'];
        $id_usuario = $request['id_usuario'];
        
        if ($id_usuario == 0) 
        {
            $recibo_producto = DB::table('vw_recibo_productos')->where('id_recibo', $id_recibo)->first();
            $soles = $this->num2letras(number_format($recibo_producto->monto_abonado,2,".",""));

            if (count($recibo_producto) >= 1) {
                $view = \View::make('caja.reportes.pago_recibo_productos', compact('recibo_producto','soles'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a5','landscape');
                return $pdf->stream("RECIBO DE PAGO PRODUCTOS".".pdf");
            }else{
                return 'No hay datos';
            }
        }
        else
        {
            $recibo_cabecera = DB::table('vw_impresion_recibo_cabecera')->where('id_recibo', $id_recibo)->first();
            $recibo_detalle = DB::table('vw_impresion_recibo_detalle')->where('id_recibo', $id_recibo)->get();
            $soles = $this->num2letras(number_format($recibo_cabecera->monto_abonado,2,".",""));

            if (count($recibo_cabecera) && count($recibo_detalle) >= 1) {
                $view = \View::make('caja.reportes.pago_recibo', compact('recibo_cabecera','recibo_detalle','soles'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('a5','landscape');
                return $pdf->stream("RECIBO DE PAGO".".pdf");
            }else{
                return 'No hay datos';
            }
        }
    }
    
    function imprimir_reporte_caja(Request $request) {
        
        $sql=DB::table('vw_recibos_emitidos')->where('estado',1)->orderBy('id_recibo', 'asc')->get();
        $usuario = DB::select('SELECT * from users where id='.Auth::user()->id);
        $fecha = (date('d/m/Y H:i:s'));
        
        if(count($sql)>0)
        { 
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $view =  \View::make('caja.reportes.reporte_ingresos_caja', compact('sql','usuario','fecha'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream("REPORTE DE INGRESOS CAJA".".pdf");
        }
        else
        {
            return 'No hay datos';
        }
    }

    public function create(Request $request){

    }

    public function show($id_auditorio)
    {

    }

    public function edit($id_recibo,Request $request)
    {
        $Recibo = new Recibo;
        $val=  $Recibo::where("id_recibo","=",$id_recibo)->first();
        if(count($val)>=1)
        {
            $val->monto_abonado = $request['monto'];
            $val->estado = $request['estado'];
            $val->hora_pago = date('h:i:s A');
            $val->fecha_pago = date('d-m-Y');
            $val->save();
        }
        return $id_recibo;
    }

    public function destroy(Request $request)
    {
       
    }
    
    public function num2letras($num, $fem = false, $dec = true) {
        $matuni[2] = "dos";
        $matuni[3] = "tres";
        $matuni[4] = "cuatro";
        $matuni[5] = "cinco";
        $matuni[6] = "seis";
        $matuni[7] = "siete";
        $matuni[8] = "ocho";
        $matuni[9] = "nueve";
        $matuni[10] = "diez";
        $matuni[11] = "once";
        $matuni[12] = "doce";
        $matuni[13] = "trece";
        $matuni[14] = "catorce";
        $matuni[15] = "quince";
        $matuni[16] = "dieciseis";
        $matuni[17] = "diecisiete";
        $matuni[18] = "dieciocho";
        $matuni[19] = "diecinueve";
        $matuni[20] = "veinte";
        $matunisub[2] = "dos";
        $matunisub[3] = "tres";
        $matunisub[4] = "cuatro";
        $matunisub[5] = "quin";
        $matunisub[6] = "seis";
        $matunisub[7] = "sete";
        $matunisub[8] = "ocho";
        $matunisub[9] = "nove";

        $matdec[2] = "veint";
        $matdec[3] = "treinta";
        $matdec[4] = "cuarenta";
        $matdec[5] = "cincuenta";
        $matdec[6] = "sesenta";
        $matdec[7] = "setenta";
        $matdec[8] = "ochenta";
        $matdec[9] = "noventa";
        $matsub[3] = 'mill';
        $matsub[5] = 'bill';
        $matsub[7] = 'mill';
        $matsub[9] = 'trill';
        $matsub[11] = 'mill';
        $matsub[13] = 'bill';
        $matsub[15] = 'mill';
        $matmil[4] = 'millones';
        $matmil[6] = 'billones';
        $matmil[7] = 'de billones';
        $matmil[8] = 'millones de billones';
        $matmil[10] = 'trillones';
        $matmil[11] = 'de trillones';
        $matmil[12] = 'millones de trillones';
        $matmil[13] = 'de trillones';
        $matmil[14] = 'billones de trillones';
        $matmil[15] = 'de billones de trillones';
        $matmil[16] = 'millones de billones de trillones';

        //Zi hack
        $float = explode('.', $num);
        $num = $float[0];

        $num = trim((string) @$num);
        if ($num[0] == '-') {
            $neg = 'menos ';
            $num = substr($num, 1);
        } else
            $neg = '';
        while ($num[0] == '0')
            $num = substr($num, 1);
        if ($num[0] < '1' or $num[0] > 9)
            $num = '0' . $num;
        $zeros = true;
        $punt = false;
        $ent = '';
        $fra = '';
        for ($c = 0; $c < strlen($num); $c++) {
            $n = $num[$c];
            if (!(strpos(".,'''", $n) === false)) {
                if ($punt)
                    break;
                else {
                    $punt = true;
                    continue;
                }
            } elseif (!(strpos('0123456789', $n) === false)) {
                if ($punt) {
                    if ($n != '0')
                        $zeros = false;
                    $fra .= $n;
                } else
                    $ent .= $n;
            } else
                break;
        }
        $ent = '     ' . $ent;
        if ($dec and $fra and ! $zeros) {
            $fin = ' coma';
            for ($n = 0; $n < strlen($fra); $n++) {
                if (($s = $fra[$n]) == '0')
                    $fin .= ' cero';
                elseif ($s == '1')
                    $fin .= $fem ? ' una' : ' un';
                else
                    $fin .= ' ' . $matuni[$s];
            }
        } else
            $fin = '';
        if ((int) $ent === 0)
            return 'Cero ' . $fin;
        $tex = '';
        $sub = 0;
        $mils = 0;
        $neutro = false;
        while (($num = substr($ent, -3)) != '   ') {
            $ent = substr($ent, 0, -3);
            if (++$sub < 3 and $fem) {
                $matuni[1] = 'una';
                $subcent = 'as';
            } else {
                $matuni[1] = $neutro ? 'un' : 'uno';
                $subcent = 'os';
            }
            $t = '';
            $n2 = substr($num, 1);
            if ($n2 == '00') {
                
            } elseif ($n2 < 21)
                $t = ' ' . $matuni[(int) $n2];
            elseif ($n2 < 30) {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = 'i' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }else {
                $n3 = $num[2];
                if ($n3 != 0)
                    $t = ' y ' . $matuni[$n3];
                $n2 = $num[1];
                $t = ' ' . $matdec[$n2] . $t;
            }
            $n = $num[0];
            if ($n == 1) {
                $t = ' ciento' . $t;
            } elseif ($n == 5) {
                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
            } elseif ($n != 0) {
                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
            }
            if ($sub == 1) {
                
            } elseif (!isset($matsub[$sub])) {
                if ($num == 1) {
                    $t = ' mil';
                } elseif ($num > 1) {
                    $t .= ' mil';
                }
            } elseif ($num == 1) {
                $t .= ' ' . $matsub[$sub] . '?n';
            } elseif ($num > 1) {
                $t .= ' ' . $matsub[$sub] . 'ones';
            }
            if ($num == '000')
                $mils ++;
            elseif ($mils != 0) {
                if (isset($matmil[$sub]))
                    $t .= ' ' . $matmil[$sub];
                $mils = 0;
            }
            $neutro = true;
            $tex = $t . $tex;
        }
        $tex = $neg . substr($tex, 1) . $fin;
        //Zi hack --> return ucfirst($tex);
        $end_num = ucfirst($tex) . ' con ' . $float[1] . '/100 Nuevos Soles';
        return $end_num;
    }

}
