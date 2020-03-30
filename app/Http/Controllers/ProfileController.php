<?php

namespace HelpDesk\Http\Controllers;

use Illuminate\Http\Request;
use HelpDesk\Entities\Admin\User;
use HelpDesk\Http\Requests\UserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return View
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Show the profile for the given user.
     *
     * @return View
     */
    public function store(UserProfileRequest $request)
    {
        $image = $request->file('archivo');
        $user = Auth::user();

        DB::beginTransaction();

        try {
            if (!empty($image)) {
                $request->request->add([
                    'tipo_foto'      => $image->getMimeType(),
                    'nombre_foto'    => $image->getClientOriginalName(),
                    'foto'           => base64_encode(file_get_contents(addslashes($image))),
                ]);
            }else{
                # REMOVE CURRENT IMAGE ONLY IF USER REMOVE IMAGE
                if($request->input('deleted_image') === 'true'){
                    $request->request->add([
                        'tipo_foto'      => null,
                        'nombre_foto'    => null,
                        'foto'           => null,
                    ]);
                }
            }

            $user->update($request->all());

            DB::commit();

            return redirect()
                ->back()
                ->with('message', 'Perfil actualizado correctamente');

        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()
                ->back()
                ->with(['error' => "Error Servidor: {$ex->getMessage()} "])->withInput();
        }
    }
}
