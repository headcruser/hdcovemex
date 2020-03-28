<?php

namespace HelpDesk\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
	 * Muestra las notificaciones disponibles.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function notificaciones()
	{
        $authUser = Auth::user();
        $authUser->unreadNotifications()->update(['read_at' => now()]);

		return view('notifications',[
            'notificacions' => $authUser->notifications
        ]);
    }

    public function deleteNotifications() {
        Auth::user()->notifications()->delete();

        return redirect()->back();
    }
}
