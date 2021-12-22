<?php

namespace HelpDesk\Http\Requests\Admin\Operators;

use Entrust;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response as HTTPMessages;

class UpdateOperatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'nombre'                => 'required|min:4',
            'usuario'               => ['required', Rule::unique('usuarios','usuario')->ignore($this->operador->usuario_id)],
            'email'                 => 'required|email',
            'roles'                 => 'required|array|min:1',
            'notificar_solicitud'   => 'nullable',
            'notificar_asignacion'  => 'nullable'
        ];
    }
}
