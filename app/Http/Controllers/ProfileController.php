<?php

namespace HelpDesk\Http\Controllers;

use HelpDesk\Entities\Media;
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
        $file = $request->file('archivo');
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $user->update($request->only(['password']));

            if (!empty($file)) {

                $media = Media::createMediaArray($file);


                if($user->media()->exists()){
                    $user->media()->update($media);
                }else{
                    $user->media()->create($media);
                }

            } else {
                # REMOVE CURRENT IMAGE ONLY IF USER REMOVE IMAGE
                if ($request->input('deleted_image') === 'true') {
                    $user->media()->delete();
                }
            }

            DB::commit();

            return redirect()
                ->route('perfil')
                ->with([
                    'message' => 'Perfil actualizado correctamente'
                ]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()
                ->back()
                ->withError("Error Servidor: {$ex->getMessage()} ")
                ->withInput();
        }
    }
}
