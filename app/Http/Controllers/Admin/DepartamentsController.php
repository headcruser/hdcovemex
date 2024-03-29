<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Entities\Admin\Departamento;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

use HelpDesk\Http\Requests\Admin\Departamentos\CreateDepartamentoRequest;
use HelpDesk\Http\Requests\Admin\Departamentos\UpdateDepartamentoRequest;

class DepartamentsController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('departament_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.departaments.index');
    }

    public function datatables()
    {
        $query = Departamento::query();

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.departaments.datatables._buttons')
            ->rawColumns(['buttons'])
            ->make(true);
    }

    public function create()
    {
        abort_unless(Entrust::can('departament_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.departaments.create', [
            'model' => new Departamento()
        ]);
    }

    public function store(CreateDepartamentoRequest $request)
    {
        DB::beginTransaction();
        try {
            Departamento::create($request->all());

            DB::commit();

            return redirect()
                ->route('admin.departamentos.index')
                ->with(['message' => 'Departamento Creado Correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor:{$e->getMessage()}",])
                ->withInput();
        }
    }

    public function edit(Departamento $model)
    {
        abort_unless(Entrust::can('departament_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.departaments.edit', [
            'model' => $model
        ]);
    }

    public function update(UpdateDepartamentoRequest $request, Departamento $model)
    {
        DB::beginTransaction();
        try {
            $model->update($request->all());

            DB::commit();

            return redirect()
                ->route('admin.departamentos.index')
                ->with(['message' => 'Departamento actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with(['error' => "Error Servidor: {$e->getMessage()}"])
                ->withInput();
        }
    }

    public function show(Departamento $model)
    {
        abort_unless(Entrust::can('departament_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.departaments.show', ['model' => $model]);
    }

    public function destroy(Request $request,Departamento $model)
    {
        $model->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El departamento se elimino con éxito",
            ]);
        }

        return redirect()->back()->with([
            'message'   => "El departamento se elimino con éxito",
        ]);

    }

    public function massDestroy(Request $request)
    {
        Departamento::whereIn('id', $request->input('ids'))->delete();

        return response(null, HTTPMessages::HTTP_NO_CONTENT);
    }

    public function select2(Request $request)
    {
        $term  = $request->input('term');
        $page = $request->input('page');
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $results = Departamento::query()
            ->where('nombre', 'like', '%' . $term . '%')
            ->orderBy('nombre')
            ->skip($offset)
            ->take($resultCount)->get();

        $count = Departamento::query()
            ->where('nombre', 'like', '%' . $term . '%')
            ->count();

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $morePages
            ]
        ]);
    }
}
