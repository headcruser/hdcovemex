<?php

namespace HelpDesk\Http\Controllers;

use HelpDesk\Entities\Faqs\FAQ;
use HelpDesk\Entities\Faqs\FaqCategoria;

class FAQController extends Controller
{
    public function index()
    {
        $items = FaqCategoria::with(['faqs' => function($q){
            return $q->where('visible',true);
        }])
            ->orderBy('nombre')
            ->get();

        return view('faq.index',compact('items'));
    }


    public function incrementClick(FAQ $faq, $type = 'total_lecturas')
    {
        if (in_array($type, ['total_lecturas', 'ayuda_si', 'ayuda_no'])) {
            $faq->increment($type);
        }

        return response()->json([]);
    }
}
