<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
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
        
        // Fetch latest chapters excluding licensed mangas
        $latestChapters = Chapitre::with(['manga' => function ($query) {
            $query->where('statut', '!=', 'licensed');
        }])->orderBy('created_at', 'desc')->take(6)->get();

        // Fetch latest mangas
        $mangas = Manga::orderBy('created_at', 'desc')->take(6)->get();

        return view('home', compact('latestChapters', 'mangas'));
    }
}
