<?php

namespace HelpDesk\Http\Controllers\GestionInventarios;

use HelpDesk\Enums\Meses;
use Illuminate\Http\Request;
use HelpDesk\Entities\Impresion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use HelpDesk\Entities\ImpresionDetalle;
use HelpDesk\Http\Controllers\Controller;
use HelpDesk\Entities\Inventario\Personal;
use HelpDesk\Mail\MailReporteImpresionesAnual;
use HelpDesk\Exports\ReporteImpresionesAnualExport;

class ReporteImpresionesController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->input('anio') ?? today()->year;

        $ids_impresiones = Impresion::query()->where('anio',$anio)->pluck('id');
        $impresionesDetalles = ImpresionDetalle::whereIn('id_impresiones',$ids_impresiones)->with(['impresion'])->get();

        $impresiones_por_id_impresion = $impresionesDetalles->groupBy('id_impresion');
        $lista_personal = Personal::query()
            ->whereIn('id_impresion',$impresiones_por_id_impresion->keys()->toArray())
            ->with(['departamento'])
            ->get();

        $personal_por_departamento = $lista_personal->groupBy(function($personal){
            return $personal->departamento->nombre;
        });


        $meses = Meses::asSelectArray();

        $reporte = [];

        foreach ($meses as $id => $mes) {
            $lista_usuarios = $impresiones_por_id_impresion->map(function($item,$id_impresion) use($impresionesDetalles,$lista_personal,$id){
                $detalles_filtrados = $impresionesDetalles->where('id_impresion',$id_impresion)->filter(function($detalleImpresion) use($id,$lista_personal){
                    return $detalleImpresion->impresion->mes == $id;
                });

                $personal = optional($lista_personal->firstWhere('id_impresion',$id_impresion));

                return [
                    'id_impresion'      => $id_impresion,
                    'id_departamento'   => $personal->id_departamento,
                    'departamento'      => optional($personal->departamento)->nombre,
                    'negro'             => $detalles_filtrados->sum('negro'),
                    'color'             => $detalles_filtrados->sum('color'),
                    'total'             => $detalles_filtrados->sum('total'),
                ];
            })->toArray();

            $reporte[$mes] = $lista_usuarios;
        }

        $agrupado_por_impresora = $impresionesDetalles->groupBy(function($impresion){
            return $impresion->impresora->descripcion;
        })->map(function($impresiones,$impresora){
            return [
                'impresora' => $impresora,
                'negro'     => $impresiones->sum('negro'),
                'color'     => $impresiones->sum('color'),
                'total'     => $impresiones->sum('total'),
            ];
        });

        $impresiones_por_departamento = ImpresionDetalle::query()
            ->whereIn('id_impresiones',$ids_impresiones)
            ->with(['personal.departamento'])
            ->get()
            ->groupBy(function($impresiones){
                return optional(optional($impresiones->personal))->departamento->nombre ?? 'S/Departamento';
            })->map(function($impresiones,$departamento){
                return [
                    'negro' => $impresiones->sum('negro'),
                    'color' => $impresiones->sum('color'),
                    'total' => $impresiones->sum('total'),
                ];
            });

        $anios = Impresion::query()->select('anio')->distinct()->pluck('anio','anio');

        return view('gestion-inventarios.reporte-impresiones.index',[
            'anios'                         => $anios,
            'anio'                          => $anio,
            'meses'                         => $meses,
            'reporte'                       => $reporte,
            'personal_por_departamento'     => $personal_por_departamento,
            'agrupado_por_impresora'        => $agrupado_por_impresora,
            'impresiones_por_departamento'  => $impresiones_por_departamento
        ]);
    }

    public function enviar_reporte_anual(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'anio'  => 'required|numeric'
        ]);

        $anio = (int) $request->input('anio');

        Excel::store(new ReporteImpresionesAnualExport($anio), 'reportes'.DIRECTORY_SEPARATOR.'reporte_anual.xlsx', 'public');
        $filename = \Storage::disk('public')->path('reportes'.DIRECTORY_SEPARATOR.'reporte_anual.xlsx');

        $mail_to = $request->input('email') ?? '';
        $mails_cc = $request->input('email_copia') ?? [];

        $mail = Mail::to($mail_to);

        foreach ( $mails_cc as $email) {
            $mail->cc($email);
        }

        try {
            $mail->send(new MailReporteImpresionesAnual($filename,$anio));
            File::delete($filename);
        } catch(\Swift_TransportException $st){
            File::delete($filename);

            return redirect()
                ->back()
                ->with(['error'=> 'El correo electronico no es válido'])
                ->withInput();
        }
        catch(\Exception $e){
            File::delete($filename);

            return redirect()
                ->back()
                ->with(['error'=> 'Ocurrio un error al enviar el correo electronico'])
                ->withInput();
        }

        return redirect()->back()->with([
            'message' => 'Reporte enviado correctamente'
        ]);
    }
}
