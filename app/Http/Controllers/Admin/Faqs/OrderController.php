<?php

namespace HelpDesk\Http\Controllers\Admin\Faqs;

use HelpDesk\Entities\Faqs\FAQ;
use HelpDesk\Entities\Faqs\FaqCategoria;
use HelpDesk\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Entrust;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class OrderController extends Controller
{
    #https://github.com/bpocallaghan/faq/blob/master/resources/views/admin/order.blade.php
    #https://github.com/bpocallaghan/faq/blob/master/app/Controllers/Admin/OrderController.php
    #https://github.com/bpocallaghan/titan/tree/master/resources/assets/js

    public function index()
    {
        abort_unless(Entrust::can('faq_categorias_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $items = FaqCategoria::with('faqs')->orderBy('nombre')->get();

        return view('admin.faqs.faq.order',[
            'items' => $items
        ]);
    }

    public function actualizar_orden(Request $request)
    {
        $model = FAQ::find($request->pk);
        $model[$request->name] = $request->value;
        $model->save();

        return response()->json([
            'faq' => $model
        ]);
    }
}
