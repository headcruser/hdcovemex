<?php

namespace HelpDesk\Http\Controllers\Reportes;

use Config;
use HelpDesk\Entities\Ticket;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PorDepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reporte_por_departamento');
    }

    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->has('solicitud')
            ->whereHas('empleado', function ($q) {
                $q->whereNotIn('departamento_id', [5]);
            })
            ->when($request->filled(['fecha-inicial', 'fecha-final']), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->whereDate('fecha', '>=', $request->input('fecha-inicial'));
                    $q->whereDate('fecha', '<=', $request->input('fecha-final'));
                });
            },function($q){
                $q->where(function ($q) {
                    $q->whereDate('fecha', '>=', now()->startOfMonth()->toDateString());
                    $q->whereDate('fecha', '<=', now()->endOfMonth()->toDateString());
                });
            })
            ->when($request->input('estado'),function($q,$estado){
                $q->where('estado',$estado);
            })
            ->with(['operador', 'empleado'])
            ->get();

        $por_departamento = $tickets->groupBy(function($ticket){
                return $ticket->empleado->departamento->nombre;
            })->map(function($items,$key){
                return [
                    'departamento'  => $key,
                    'total'         => $items->count(),
                ];
            })->values();


        $estados = ['' => 'Todos'] + Config::get('helpdesk.tickets.estado.names',[]);

        return view('reportes.por-departamento.index',compact('por_departamento','estados'));
    }
}
