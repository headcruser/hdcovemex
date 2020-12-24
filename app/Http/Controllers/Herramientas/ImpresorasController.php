<?php

namespace HelpDesk\Http\Controllers\Herramientas;

use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Services\PrinterCanon;
use Illuminate\Http\Request;

class ImpresorasController extends Controller
{
    public function index(){
        return view('herramientas.impresoras.index');
    }

    public function calcular(Request $request, PrinterCanon $printer){
        $request->validate([
            'info' => 'required'
        ]);

        $printer->read($request->input('info'));

        return redirect()->route('herramientas.impresoras.index')->with([
            'tb_printer' =>  $printer->render()
        ]);
    }
}
