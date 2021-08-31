<?php

namespace HelpDesk\Imports;

use HelpDesk\Entities\Impresion;
use HelpDesk\Entities\ImpresionDetalle;
use HelpDesk\Entities\Impresora;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ImpresionImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    WithBatchInserts,
    WithStrictNullComparison,
    SkipsEmptyRows
{
    use SkipsErrors, Importable;

    protected $impresion;

    public function __construct(Impresion $impresion)
    {
        HeadingRowFormatter::default('none');

        $this->impresion = $impresion;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $impresiones = [];

        # NOTE: PENDIENTE DE TERMINAR LA IMPORTACION MASIVA
        foreach ($collection as $row) {

            $impresora = Impresora::query()->where('descripcion',trim($row['impresora']))->first();

            $impresiones[] = [
                'id_impresiones'        => $this->impresion->id,
                'id_impresion'          => $row['id_impresion'] ?? '',
                'id_impresora'          => optional($impresora)->id,
                'negro'                 => $row['negro'] ?? 0,
                'color'                 => $row['color'] ?? 0,
                'total'                 => ($row['color'] ?? 0) + ($row['negro'] ?? 0),
            ];
        }

        ImpresionDetalle::insert($impresiones);

        $this->impresion->load('detalles');

        $this->impresion->negro += $this->impresion->detalles->sum('negro');
        $this->impresion->color += $this->impresion->detalles->sum('color');
        $this->impresion->total += $this->impresion->detalles->sum('total');

        $this->impresion->save();
    }

    public function rules(): array
    {
        return [
            // 'nombre'                => 'required',
            // '*.nombre'              => 'required',
            // 'id_impresion'          => 'required',
            // '*.id_impresion'        => 'required',
            // 'id_sucursal'           => 'required',
            // '*.id_sucursal'         => 'required',
            // 'id_departamento'       => 'required',
            // '*.id_departamento'     => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
