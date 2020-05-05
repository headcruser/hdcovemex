<?php

namespace HelpDesk\Http\Controllers\Api;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\User;
use Illuminate\Support\Facades\Hash;
use HelpDesk\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class UserController extends Controller
{

    public function authUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $password = $request->input('password');

        $user = User::findOrFail($user_id);

        if (Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Usuario Verificado correctamente',
                'success' => true
            ],StatusCode::HTTP_OK);
        }

        return response()->json([
            'message' => 'La contraseña es incorrecta',
            'success' => false
        ],StatusCode::HTTP_BAD_REQUEST);
    }
}
