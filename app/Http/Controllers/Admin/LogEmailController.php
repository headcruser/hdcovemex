<?php

namespace HelpDesk\Http\Controllers\Admin;

use Entrust;

use HelpDesk\Entities\Config\EmailError;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class LogEmailController extends Controller
{
    public function index()
    {
        abort_unless(Entrust::can('log_email_access'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));
        return view('admin.log_email.index', [
            'collection' => EmailError::with(['operador', 'subject'])->paginate()
        ]);
    }

    public function show(EmailError $logEmail)
    {
        abort_unless(Entrust::can('log_email_show'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $logEmail->load(['operador','subject']);

        return view('admin.log_email.show', [
            'model' => $logEmail
        ]);
    }

    public function destroy(EmailError $logEmail)
    {
        abort_unless(Entrust::can('log_email_delete'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $logEmail->delete();

        return redirect()->back()->with(['message' => 'Registro eliminado correctamente']);
    }

    public function massDestroy() {
        abort_unless(Entrust::can('log_email_all_delete'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $listLogEmail = EmailError::all();

        foreach($listLogEmail as $logEmail) {
            $logEmail->delete();
        }

        return redirect()->route('admin.log-email.index')->with(['message' => 'Los registros han sido eliminados correctamente']);
    }
}
