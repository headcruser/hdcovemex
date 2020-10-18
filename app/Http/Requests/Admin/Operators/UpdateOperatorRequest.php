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
        abort_unless(Entrust::can('operator_edit'), HTTPMessages::HTTP_FORBIDDEN, __('Forbidden'));
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
            'nombre'            => 'required|min:4',
            'usuario'           => ['required', Rule::unique('usuarios')->ignore($this->model)],
            'email'             => 'required|email',
            'roles'             => 'required',
            'departamento_id'   => 'required|exists:departamentos,id',
            'roles'             => 'required|array|min:1',
            'roles.*'           => 'required|exists:roles,id',
            'notificar_solicitud' => 'nullable',
            'notificar_asignacion' =>  'nullable'
        ];
    }
}
