<?php

namespace HelpDesk\Http\Controllers\Admin\Faqs;

use DataTables;
use Entrust;
use Illuminate\Http\Request;
use HelpDesk\Entities\Faqs\FAQ;
use HelpDesk\Entities\Faqs\FaqCategoria;
use Illuminate\Support\Facades\DB;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class FAQController extends Controller
{
    #https: //bpocallaghan.ie/admin/faqs/categories
    #https://bpocallaghan.ie/admin/faqs
    #https://github.com/bpocallaghan/faq/blob/master/resources/views/admin/index.blade.php
    public function index()
    {
        abort_unless(Entrust::can('faq_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.faq.index');
    }

    public function datatables()
    {
        $query = FAQ::query()->with(['categoria']);

        return DataTables::eloquent($query)
            ->addColumn('nombre_categoria',function($model){
                return $model->categoria->nombre;
            })
            ->addColumn('resupuesta', function ($model) {
                return $model->resumen_respuesta;
            })
            ->addColumn('totales', 'admin.faqs.faq.datatables._totales')
            ->editColumn('creado', function ($model) {
                return optional($model->created_at)->toDateString();
            })
            ->editColumn('visible', function ($model) {
                $class = ($model->visible) ? 'badge-success': 'badge-danger';
                $text = ($model->visible) ? 'Visible' : 'No Visible';

                return  "<span class='badge {$class}'>$text</span>";
            })
            ->addColumn('buttons', 'admin.faqs.faq.datatables._buttons')
            ->rawColumns(['buttons','totales','visible'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('faq_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.faq.create', [
            'model'         => new FAQ(),
            'categorias'    => FaqCategoria::pluck('nombre', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->merge([
            'orden'   => 0,
            'visible' => $request->has('visible'),
        ]);

        try {
            $faq = FAQ::create($request->except('_token'));

            DB::commit();

            return redirect()
                ->route('admin.faqs.faq.edit',$faq)
                ->with(['message' => 'FAQ creada correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function edit(FAQ $faq)
    {
        abort_unless(Entrust::can('faq_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.faq.edit', [
            'model'         => $faq,
            'categorias'    => FaqCategoria::pluck('nombre','id'),
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->merge([
            'visible' => $request->has('visible'),
        ]);

        DB::beginTransaction();

        try {

            $faq->update($request->except('_token'));

            DB::commit();

            return redirect()->back()
                    ->with(['message' => 'FAQ correctamente']);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()
            ->back()
            ->with(['message' => 'FAQ eliminada correctamente']);
    }
}
