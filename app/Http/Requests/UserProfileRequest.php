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
            'foto.image'            => 'El Campo foto debe ser una imagen',
            'password.required'     => 'El campo contrasñea es requerido',
        ];
    }
}
