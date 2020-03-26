<?php

namespace HelpDesk\Http\Controllers\Config;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use HelpDesk\Entities\Config\Attribute;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use HelpDesk\Http\Requests\Config\Attribute\CreateAttributeRequest;
use HelpDesk\Http\Requests\Config\Attribute\UpdateAttributeRequest;

class AttributesController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('attribute_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('config.attributes.index', ['collection' => Attribute::orderBy('attribute')->paginate()]);
    }

    public function create()
    {
        abort_unless(Entrust::can('attribute_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('config.attributes.create', [
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

            return redirect()->route('config.atributos.index')
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
        abort_unless(Entrust::can('attribute_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('config.attributes.edit', [
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

            return redirect()->route('config.atributos.index')
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
        abort_unless(Entrust::can('attribute_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('config.attributes.show', ['model' => $model]);
    }

    public function destroy(Attribute $model)
    {
        abort_unless(Entrust::can('attribute_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Attribute::whereIn('id', $request->input('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
