<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manga;
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
                $user = Auth::user(); // Récupère l'utilisateur connecté
        return view('account', ['user' => $user]);
        $mangas = Manga::latest('dates')->take(9)->get(); // Récupère les 9 derniers mangas
        return view('home', compact('mangas'));
    }
}
