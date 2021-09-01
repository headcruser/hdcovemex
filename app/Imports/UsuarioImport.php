<?php

namespace HelpDesk\Imports;

use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Entities\Admin\Role;
use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
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

class UsuarioImport implements
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
        $rol_empleado = Role::where('name','Empleado')->pluck('id')->toArray();

        foreach ($collection as $row) {

            $departamento = Departamento::query()->where('nombre',trim($row['departamento']))->first();

            $user = User::updateOrCreate(
                ['usuario'         =>  trim($row['usuario_id']) ],
                [
                    'nombre'                => $row['usuario'] ?? '',
                    'email'                 => $row['correo'] ?? null,
                    'departamento_id'       => optional($departamento)->id ?? null,
                    'telefono'              => null,
                    'password'              => Hash::make(trim($row['usuario_id'])),
                ]
            );

            $user->roles()->sync($rol_empleado);
        }
    }

    public function rules(): array
    {
        return [
            'usuario_id'                => 'required',
            'correo'                    => 'nullable',
            'usuario'                   => 'required',
            'departamento'              => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
