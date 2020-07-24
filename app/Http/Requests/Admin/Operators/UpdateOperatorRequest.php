<?php

namespace HelpDesk\Http\Requests\Admin\Operators;

use Entrust;
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
            //
        ];
    }
}
