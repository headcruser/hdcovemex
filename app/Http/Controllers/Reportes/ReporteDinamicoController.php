<?php

namespace HelpDesk\Http\Controllers\Reportes;

use HelpDesk\Entities\Ticket;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteDinamicoController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::query()
        ->has('solicitud')
        ->whereHas('empleado',function($q){
            $q->whereNotIn('departamento_id',[5]);
        })
        ->when($request->filled(['fecha-inicial','fecha-final']),function($q)use ($request){
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
        ->with(['operador','empleado'])
        ->get()
        ->map(function($ticket){
            return [
                'horas'         => $ticket->fecha->diffInHours($ticket->updated_at),
                'fecha'         => $ticket->fecha->format('d-m-Y'),
                'anio'          => $ticket->fecha->format('Y'),
                'mes'           => $ticket->fecha->format('m'),
                'id_usuario'    => $ticket->empleado->usuario,
                'usuario'       => $ticket->empleado->nombre,
                'operador'      => $ticket->operador->nombre,
                'contacto'      => $ticket->contacto,
            ];
        });

        return view('reportes.dinamico.index',compact('tickets'));
    }
}
