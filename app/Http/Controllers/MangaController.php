<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Chapitre;
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MangaController extends Controller
{

// MangaController.php

public function showChapitres($id)
{
    $manga = Manga::with('chapitres')->findOrFail($id);
    return view('mangas.chapitres', ['manga' => $manga]);
}
public function index()
    {
        
        $mangas = Manga::latest('created_at')->take(6)->get();
        
        $latestChapters = Chapitre::with('manga')->latest('created_at')->take(9)->get();

        return view('welcome', compact('mangas', 'latestChapters'));
    }
public function create()
    {
        $categories = Category::all();
        return view('mangas.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titres' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'descri' => 'required|string',
            'dates' => 'required|date',
            'cover' => 'required|image|max:2048',
            'statut' => 'required|in:licensed,unlicensed',
            'categories' => 'required|array'
        ]);

        $manga = new Manga($request->only('titres', 'auteur', 'dates', 'descri', 'statut'));
        $manga->userpubli = Auth::id();

        if ($request->hasFile('cover')) {
            $filename = Str::slug($request->titres, '_') . '.jpg';
            $destinationPath = public_path('picture/cover'); // Définit le chemin du dossier public cible
            $request->file('cover')->move($destinationPath, $filename);
            $manga->cover = 'public/picture/cover/' . $filename; // Enregistre le chemin relatif
        }

        $manga->save();
        $manga->categories()->sync($request->categories);

        return redirect()->route('home')->with('success', 'Manga ajouté avec succès.');
    }
 public function edit($id)
    {
        $manga = Manga::findOrFail($id);
        $categories = Category::all();
        return view('mangas.edit', compact('manga', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titres' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'descri' => 'required|string',
            'dates' => 'required|date',
            'cover' => 'nullable|image|max:2048',
            'statut' => 'required|in:licensed,unlicensed',
            'categories' => 'required|array'
        ]);

        $manga = Manga::findOrFail($id);
        $manga->fill($request->only('titres', 'auteur', 'dates', 'descri', 'statut'));

        if ($request->hasFile('cover')) {
            $filename = Str::slug($request->titres, '_') . '.jpg';
            $destinationPath = public_path('picture/cover'); // Définit le chemin du dossier public cible
            $request->file('cover')->move($destinationPath, $filename);
            $manga->cover = 'public/picture/cover/' . $filename; // Enregistre le chemin relatif
        }

        $manga->save();
        $manga->categories()->sync($request->categories);

        return redirect()->route('home')->with('success', 'Manga modifié avec succès.');
    }

public function show($idmanga)
{
    $manga = Manga::with('chapitres')->findOrFail($idmanga);
    return view('mangas.show', ['manga' => $manga]);
}
}

