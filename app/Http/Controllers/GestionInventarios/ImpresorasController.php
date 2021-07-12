<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Services\PrinterCanon;
use Illuminate\Http\Request;

class ImpresorasController extends Controller
{
    public function index()
    {
        return view('gestion-inventarios.impresoras.index');
    }

    public function calcular(Request $request, PrinterCanon $printer)
    {
        $request->validate([
            'info' => 'required'
        ]);

        $printer->read($request->input('info'));

        return redirect()->route('gestion-inventarios.impresoras.index')->with([
            'tb_printer' =>  $printer->render()
        ]);
    }
}
