<?php

namespace HelpDesk\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'nombre'        => 'required',
            'usuario'       => 'required|min:2',
            'password'      => 'nullable|confirmed|min:4',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'foto.image'           => 'El Campo foto debe ser una imagen',
            'nombre.required'      => 'El campo nombre es requerido',
            'usuario.required'     => 'El campo Usuario es requerido',
        ];
    }
}
