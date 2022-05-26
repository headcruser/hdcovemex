<?php

namespace HelpDesk\Http\Controllers\Admin\Faqs;

use DataTables;
use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Faqs\FaqCategoria;
use HelpDesk\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class CategoriasController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('faq_categorias_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.categorias.index');
    }

    public function datatables()
    {
        $query = FaqCategoria::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.faqs.categorias.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('faq_categorias_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.categorias.create', [
            'categoria' => new FaqCategoria(),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            FaqCategoria::create($request->except('_token'));

            DB::commit();

            return redirect()
                ->route('admin.faqs.categorias.index')
                ->with(['message' => 'Categoria creada correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function edit(FaqCategoria $categoria)
    {
        abort_unless(Entrust::can('faq_categorias_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.faqs.categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(Request $request, FaqCategoria $categoria)
    {
        DB::beginTransaction();
        try {

            $categoria->update($request->except('_token'));

            DB::commit();

            return redirect()
                ->route('admin.faqs.categorias.index')
                ->with(['message' => 'Categoria actualizada correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function destroy(FaqCategoria $categoria)
    {
        $categoria->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Categoria eliminada correctamente']);
    }
}
