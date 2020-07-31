<?php

namespace HelpDesk\Http\Controllers\Reportes;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\User;
use Maatwebsite\Excel\Facades\Excel;

use HelpDesk\Exports\EficienciaExport;
use HelpDesk\Http\Controllers\Controller;

class EficienciaReportController extends Controller
{
     /**
     * Display Report efficiency to operators
     *
     * @return \Illuminate\Http\Response
     */
    public function eficiencia(Request $request) {

        $empleados = User::withRole('empleado')
            ->with(['tickets' => function($query) use ($request){
                $query->where(function($query) use ($request){
                    $query->from($request->input('from'));
                    $query->to($request->input('to'));
                });
            }])
            ->get();

        return view('reportes.eficiencia.index',[
            'usuarios' => $empleados
        ]);
    }

    /**
     * Generate report excel
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request) {
        return Excel::download(new EficienciaExport($request), 'eficiencia.xlsx');
    }
}
