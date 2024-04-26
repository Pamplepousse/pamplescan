<?php

namespace App\Http\Controllers;

use App\Models\Manga; // Assurez-vous d'importer le modèle

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
    $mangas = Manga::latest('dates')->take(9)->get(); // Assurez-vous que 'dates' est le bon champ pour l'ordre
    return view('welcome', ['mangas' => $mangas]); // 'welcome' est le nom de la vue
}
// App/Http/Controllers/MangaController.php
public function store(Request $request)
{
    // ...création de manga
    $manga = Manga::create($request->all());

    $manga->categories()->attach($request->input('categories', [])); // Attacher les catégories sélectionnées
    // ...
}

// Dans MangaController
public function show($idmanga)
{
    $manga = Manga::with('chapitres')->findOrFail($idmanga);
    return view('mangas.show', ['manga' => $manga]);
}
}
