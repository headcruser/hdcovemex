<?php

namespace HelpDesk\Http\Controllers\GestionInventarios\Reportes;

use HelpDesk\Entities\Inventario\CuentaPersonal;
use HelpDesk\Http\Controllers\Controller;
use Entrust;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class ExtensionesTelefonicasController extends Controller
{
    public function index()
    {
        $verifyAccess =  Entrust::hasRole(['admin','soporte','jefatura']);

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $extensiones = CuentaPersonal::toBase()
            ->select('personal.nombre','cuentas_personal.usuario as extension','cuentas_personal.id_personal')
            ->join('personal','cuentas_personal.id_personal','=','personal.id')
            ->where('cuentas_personal.titulo','like','Ext%')
            ->orderBy('personal.nombre')
            ->get();

        return view('gestion-inventarios.reportes.extensiones_telefonicas.index',compact('extensiones'));
    }
}
