<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;

use Illuminate\Http\Request;
use HelpDesk\Entities\Config\EmailError;
use Yajra\DataTables\Facades\DataTables;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class LogEmailController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('log_email_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return view('admin.log_email.index');
    }

    public function datatables()
    {
        $query = EmailError::query()->with(['operador','subject']);

        return DataTables::eloquent($query)
            ->addColumn('buttons', 'admin.log_email.datatables._buttons')
            ->rawColumns(['buttons', 'roles'])
            ->make(true);
    }

    public function show(EmailError $logEmail)
    {
        abort_unless(Entrust::can('log_email_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $logEmail->load(['operador','subject']);

        return view('admin.log_email.show', [
            'model' => $logEmail
        ]);
    }

    public function destroy(Request $request, EmailError $logEmail)
    {
        $logEmail->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El rol se eliminó con éxito",
            ]);
        }

        return back()->with([
            'message' => "El rol se eliminó con éxito"
        ]);

        return redirect()->back()->with(['message' => 'Registro eliminado correctamente']);
    }

    public function massDestroy(Request $request) {

        EmailError::query()->delete();

        if ($request->ajax()) {
            return response()->json([
                'success'   => true,
                'message'   => "El log fue vaciado correctamente",
            ]);
        }

        return redirect()->back()
            ->with(['message' => 'El log fue vaciado correctamente']);
    }
}
