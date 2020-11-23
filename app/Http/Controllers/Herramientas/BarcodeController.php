<?php

namespace HelpDesk\Http\Controllers\Herramientas;

use DNS1D;
use Illuminate\Http\Request;
use HelpDesk\Http\Controllers\Controller;

class BarcodeController extends Controller
{
    public function index(){
        return view('herramientas.barcode.index');
    }

    public function download(Request $request){
        #$image = str_replace('data:image/png;base64,', '', $image);
        $code = $request->input('barcode','ABC-123');
        $name = "barcode_{$code}.png";
        $base64CodeBar = DNS1D::getBarcodePNG($code, 'C39',2,88,[0,0,0],true);
        $contents = base64_decode($base64CodeBar);
        $path = storage_path("app/{$name}");

        file_put_contents($path, $contents);

        return response()
            ->download($path,$name,['Content-Type' => 'data:image/png'])
            ->deleteFileAfterSend(true);
    }
}
