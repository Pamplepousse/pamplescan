<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Assurez-vous d'ajouter cette ligne


class MangaAdminController extends Controller
{
    public function index() {
        $mangas = Manga::all();
        return view('admin.mangas.index', compact('mangas'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.mangas.create', compact('categories'));
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

    return redirect()->route('admin.mangas.index')->with('success', 'Manga ajouté avec succès.');
}



    public function edit(Manga $manga)
    {
        $categories = Category::all();
        return view('admin.mangas.edit', compact('manga', 'categories'));
    }

  public function update(Request $request, Manga $manga)
{
    $request->validate([
        'titres' => 'required|string|max:255',
        'auteur' => 'required|string|max:255',
        'dates' => 'required|date',
        'cover' => 'required|string', // Peut-être validez si c'est une URL valide
        'statut' => 'required|in:licensed,unlicensed',
        'descri' => 'required|string',
        'categories' => 'required|array', // Ajoutez une validation pour les catégories
    ]);

    $manga->update($request->only('titres', 'auteur', 'dates', 'cover', 'statut', 'descri'));

    // Synchroniser les catégories
    $manga->categories()->sync($request->categories);

    return redirect()->route('admin.mangas.index')->with('success', 'Manga mis à jour avec succès.');
}


    public function destroy(Manga $manga)
    {
        $manga->delete();
        return redirect()->route('admin.mangas.index')->with('success', 'Manga supprimé avec succès.');
    }
}



