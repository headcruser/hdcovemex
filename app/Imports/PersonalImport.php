<?php

namespace HelpDesk\Imports;

use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Inventario\Personal;
use HelpDesk\Entities\Inventario\Sucursal;
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

class PersonalImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    WithBatchInserts,
    WithStrictNullComparison,
    SkipsEmptyRows
{
    use SkipsErrors, Importable;

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $facturas = [];
        # NOTE: PENDIENTE DE TERMINAR LA IMPORTACION MASIVA
        foreach ($collection as $row) {

            $personal = Personal::query()->where('id_impresion','=', trim($row['id_impresion']))->get()->first();
            $sucursal = Sucursal::query()->where('descripcion',trim($row['sucursal']))->first();
            $departamento = Departamento::query()->where('nombre',trim($row['departamento']))->first();

            if($personal){
                $personal->update([
                    'nombre'                => $row['nombre'] ?? '',
                    'id_impresion'          => $row['id_impresion'] ?? null,
                    'id_sucursal'           => optional($sucursal)->id ?? null,
                    'id_departamento'       => optional($departamento)->id ?? null,
                ]);
            }else{
                $facturas[] = [
                    'nombre'                => $row['nombre'] ?? '',
                    'id_impresion'          => $row['id_impresion'] ?? null,
                    'id_sucursal'           => $sucursal->id?? null,
                    'id_departamento'       => optional($departamento)->id ?? null,
                ];
            }


        }

        Personal::insert($facturas);
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
