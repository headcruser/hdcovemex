<?php

namespace HelpDesk\Http\Requests\Operador\Tickets;

use Entrust;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class TicketCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_unless(Entrust::can('ticket_create'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'incidente'     => 'required',
            'comentario'    => 'nullable',
            'archivo'       => 'nullable',
            'prioridad'     => '',
            'estado'        => '',
            'asignado_a'    => '',
            'contacto'      => '',
            'tipo'          => '', #ATENCION
            'sub_tipo'      => '', #ACTIVIDAD
            'privado'       => '', #VISIBILIDAD MENSAJES
        ];
    }
}
