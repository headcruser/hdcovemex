<?php

namespace HelpDesk\Http\Controllers\GestionInventarios\Reportes;

use Entrust;
use Illuminate\Http\Request;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\Sucursal;
use HelpDesk\Entities\Inventario\CuentaPersonal;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class ExtensionesTelefonicasController extends Controller
{
    public function index(Request $request)
    {
        $verifyAccess =  Entrust::hasRole(['admin','soporte','jefatura']);

        abort_unless($verifyAccess, HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        $sucursales = Sucursal::toBase()->pluck('descripcion','id');

        $extensiones = CuentaPersonal::toBase()
            ->select('personal.nombre','departamentos.nombre as departamento','sucursales.descripcion as sucursal','cuentas_personal.usuario as extension','cuentas_personal.id_personal')
            ->join('personal','cuentas_personal.id_personal','=','personal.id')
            ->leftJoin('departamentos', 'personal.id_departamento', '=', 'departamentos.id')
            ->leftJoin('sucursales', 'personal.id_sucursal', '=', 'sucursales.id')
            ->where('cuentas_personal.titulo','like','Ext%')
            ->when($request->input('sucursal'),function($q,$sucursal){
                $q->where('sucursales.id',$sucursal);
            })
            ->orderBy('personal.nombre')
            ->get();

        return view('gestion-inventarios.reportes.extensiones_telefonicas.index',compact('extensiones','sucursales'));
    }
}
