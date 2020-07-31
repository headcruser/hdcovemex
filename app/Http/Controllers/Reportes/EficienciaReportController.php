<?php

namespace HelpDesk\Http\Controllers\Reportes;

use Entrust;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Exports\EficienciaExport;
use HelpDesk\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class EficienciaReportController extends Controller
{
    /**
     * Display Report efficiency to operators
     *
     * @return \Illuminate\Http\Response
    */
    public function eficiencia(Request $request) {
        abort_unless(Entrust::can('report_efficiency'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

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
        abort_unless(Entrust::can('report_efficiency'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return Excel::download(new EficienciaExport($request), 'eficiencia.xlsx');
    }
}
