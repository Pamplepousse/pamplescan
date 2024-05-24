<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use App\Models\Manga;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Assurez-vous d'ajouter cette ligne


class ChapitreAdminController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::all();
        return view('admin.chapitres.index', compact('chapitres'));
    }

    public function create()
    {
        $mangas = Manga::all();
        return view('admin.chapitres.create', compact('mangas'));
    }


public function store(Request $request)
{
    $request->validate([
        'idmanga' => 'required|exists:mangas,idmanga',
        'numchap' => 'required|string|max:255',
        'titlechap' => 'nullable|string|max:255',
        'content' => 'required|array',
        'content.*' => 'image|max:2048',
    ]);

    $manga = Manga::findOrFail($request->idmanga);

    $chapitre = new Chapitre([
        'numchap' => $request->numchap,
        'titlechap' => $request->titlechap,
        'path' => 'picture/' . Str::slug($manga->titres, '_') . '/' . $request->numchap . '_',
    ]);

    $manga->chapitres()->save($chapitre);

    $directory = public_path($chapitre->path);
    File::makeDirectory($directory, $mode = 0777, true, true); // Créez le répertoire de manière récursive si nécessaire

    foreach ($request->file('content') as $index => $image) {
        $filename = $index + 1; // Vous pouvez modifier ceci selon vos besoins
        $extension = $image->getClientOriginalExtension();
        $image->move($directory, $filename . '.' . $extension);
    }

    return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre ajouté avec succès.');
}



    public function edit(Chapitre $chapitre)
    {
        $mangas = Manga::all();
        return view('admin.chapitres.edit', compact('chapitre', 'mangas'));
    }

    public function update(Request $request, Chapitre $chapitre)
    {
        $request->validate([
            'idmanga' => 'required|exists:mangas,idmanga',
            'numchap' => 'required|integer',
            'titlechap' => 'nullable|string|max:255',
            'content' => 'required|string',
            'dates' => 'required|date',
            'path' => 'nullable|string|max:255',
        ]);

        $chapitre->update($request->all());

        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre mis à jour avec succès.');
    }

    public function destroy(Chapitre $chapitre)
    {
        $chapitre->delete();
        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre supprimé avec succès.');
    }
}
