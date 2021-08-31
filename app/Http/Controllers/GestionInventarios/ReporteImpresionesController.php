<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Entities\Impresion;
use HelpDesk\Entities\ImpresionDetalle;
use HelpDesk\Entities\Inventario\Personal;
use HelpDesk\Enums\Meses;
use HelpDesk\Http\Controllers\Controller;

class ReporteImpresionesController extends Controller
{
    public function index()
    {
        $today = today();

        $ids_impresiones = Impresion::query()->where('anio',$today->year)->pluck('id');
        $impresionesDetalles = ImpresionDetalle::where('id_impresiones',$ids_impresiones)->with(['impresion'])->get();

        $impresiones_por_id_impresion = $impresionesDetalles->groupBy('id_impresion');
        $lista_personal = Personal::query()
            ->whereIn('id_impresion',$impresiones_por_id_impresion->keys()->toArray())
            ->with(['departamento'])
            ->get();

        $personal_por_departamento = $lista_personal->groupBy(function($personal){
            return $personal->departamento->nombre;
        });


        $meses = Meses::asSelectArray();

        $reporte = [];

        foreach ($meses as $id => $mes) {
            $lista_usuarios = $impresiones_por_id_impresion->map(function($item,$id_impresion) use($impresionesDetalles,$lista_personal,$id){
                $detalles_filtrados = $impresionesDetalles->where('id_impresion',$id_impresion)->filter(function($detalleImpresion) use($id,$lista_personal){
                    return $detalleImpresion->impresion->mes == $id;
                });

                $personal = optional($lista_personal->firstWhere('id_impresion',$id_impresion));

                return [
                    'id_impresion'      => $id_impresion,
                    'id_departamento'   => $personal->id_departamento,
                    'departamento'      => optional($personal->departamento)->nombre,
                    'negro'             => $detalles_filtrados->sum('negro'),
                    'color'             => $detalles_filtrados->sum('color'),
                    'total'             => $detalles_filtrados->sum('total'),
                ];
            })->toArray();

            $reporte[$mes] = $lista_usuarios;
        }

        $agrupado_por_impresora = $impresionesDetalles->groupBy(function($impresion){
            return $impresion->impresora->descripcion;
        })->map(function($impresiones,$impresora){
            return [
                'impresora' => $impresora,
                'negro'     => $impresiones->sum('negro'),
                'color'     => $impresiones->sum('color'),
                'total'     => $impresiones->sum('total'),
            ];
        });

        $impresiones_por_departamento = ImpresionDetalle::query()
            ->where('id_impresiones',$ids_impresiones)
            ->with(['personal.departamento'])
            ->get()
            ->groupBy(function($impresiones){
                return optional(optional($impresiones->personal))->departamento->nombre ?? 'S/Departamento';
            })->map(function($impresiones,$departamento){
                return [
                    'negro' => $impresiones->sum('negro'),
                    'color' => $impresiones->sum('color'),
                    'total' => $impresiones->sum('total'),
                ];
            });

        return view('gestion-inventarios.reporte-impresiones.index',[
            'meses'                         => $meses,
            'reporte'                       => $reporte,
            'personal_por_departamento'     => $personal_por_departamento,
            'agrupado_por_impresora'        => $agrupado_por_impresora,
            'impresiones_por_departamento'  => $impresiones_por_departamento
        ]);
    }

    // public function calcular(Request $request, PrinterCanon $printer)
    // {
    //     $request->validate([
    //         'info' => 'required'
    //     ]);

    //     $printer->read($request->input('info'));

    //     return redirect()->route('gestion-inventarios.reporte-impresiones.index')->with([
    //         'tb_printer' =>  $printer->render()
    //     ]);
    // }
}
