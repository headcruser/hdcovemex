<?php

namespace HelpDesk\Exports;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EficienciaExport implements FromView,ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;

        $empleados = User::withRole('empleado')
        ->with(['tickets' => function($query) use ($request){
            $query->where(function($query) use ($request){
                $query->from($request->input('from'));
                $query->to($request->input('to'));
            });
        }])
        ->get();

        return view('reportes.eficiencia.partials._table', [
            'usuarios' => $empleados
        ]);
    }
}
