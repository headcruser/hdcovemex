<?php

namespace HelpDesk\Exports;

use HelpDesk\Entities\Impresion;
use HelpDesk\Entities\ImpresionDetalle;
use HelpDesk\Entities\Inventario\Personal;
use HelpDesk\Enums\Meses;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReporteImpresionesAnualExport implements FromView,ShouldAutoSize
{
    protected $request;

    public function __construct()
    {
    }

    public function view(): View
    {
        $today = today();

        $ids_impresiones = Impresion::query()->where('anio',$today->year)->pluck('id');
        $impresionesDetalles = ImpresionDetalle::whereIn('id_impresiones',$ids_impresiones)->with(['impresion'])->get();

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

        return view('gestion-inventarios.reporte-impresiones.partials._table', [
            'meses'                         => $meses,
            'reporte'                       => $reporte,
            'personal_por_departamento'     => $personal_por_departamento,
        ]);
    }
}
