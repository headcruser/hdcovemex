<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Attribute;
use Yajra\DataTables\Facades\DataTables;

use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

use HelpDesk\Http\Requests\Config\Attribute\CreateAttributeRequest;
use HelpDesk\Http\Requests\Config\Attribute\UpdateAttributeRequest;

class AttributesController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('attribute_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.attributes.index');
    }

    public function datatables(){
        $query = Attribute::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.attributes.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('attribute_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.attributes.create', [
            'model'         => new Attribute(),
            'categorias'    => Attribute::categories()
        ]);
    }

    public function store(CreateAttributeRequest $request)
    {
        DB::beginTransaction();
        try {
            Attribute::create($request->all());

            DB::commit();

            return redirect()->route('admin.atributos.index')
                ->with(['message' => 'Attibuto Creado Correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function edit(Attribute $model)
    {
        abort_unless(Entrust::can('attribute_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.attributes.edit', [
            'model'         => $model,
            'categorias'    => Attribute::categories()
        ]);
    }

    public function update(UpdateAttributeRequest $request, Attribute $model)
    {
        DB::beginTransaction();
        try {

            $model->update($request->all());

            DB::commit();

            return redirect()->route('admin.atributos.index')
                ->with(['message' => 'Attibuto actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with([
                    'error' => "Error Servidor: {$e->getMessage()}",
                ])->withInput();
        }
    }

    public function show(Attribute $model)
    {
        abort_unless(Entrust::can('attribute_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.attributes.show', ['model' => $model]);
    }

    public function destroy(Attribute $model)
    {
        abort_unless(Entrust::can('attribute_delete'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $model->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Attribute::whereIn('id', $request->input('ids'))->delete();

        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }
}
