<?php

namespace HelpDesk\Http\Controllers\Api;

use HelpDesk\Entities\Config\Attribute;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function subtipo(Request $request)
    {
        return response()->json([
            'list'      => Attribute::typeAttribute($request->input('tipo',''))->orderBy('value','desc')->get(),
            'message'   => 'Listado de actividades (Subtipo)',
            'success'   => true
        ]);
    }
}
