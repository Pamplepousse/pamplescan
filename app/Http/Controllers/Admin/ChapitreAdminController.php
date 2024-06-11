<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use Illuminate\Http\Request;
use App\Models\Manga;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChapitreAdminController extends Controller
{
    // Display a listing of chapters
    public function index()
    {
        $chapitres = Chapitre::all();
        return view('admin.chapitres.index', compact('chapitres'));
    }

    // Show the form for creating a new chapter
    public function create()
    {
        $mangas = Manga::all();
        return view('admin.chapitres.create', compact('mangas'));
    }

    // Store a newly created chapter in the database
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
        File::makeDirectory($directory, $mode = 0777, true, true); // Create the directory recursively if needed

        foreach ($request->file('content') as $index => $image) {
            $filename = $index + 1; // You can modify this as needed
            $extension = $image->getClientOriginalExtension();
            $image->move($directory, $filename . '.' . $extension);
        }

        return redirect()->route('admin.chapitres.index')->with('success', 'Chapter added successfully.');
    }

    // Show the form for editing a chapter
    public function edit(Chapitre $chapitre)
    {
        $mangas = Manga::all();
        return view('admin.chapitres.edit', compact('chapitre', 'mangas'));
    }

    // Update the specified chapter in the database
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

        return redirect()->route('admin.chapitres.index')->with('success', 'Chapter updated successfully.');
    }

    // Remove the specified chapter from the database
    public function destroy(Chapitre $chapitre)
    {
        $chapitre->delete();
        return redirect()->route('admin.chapitres.index')->with('success', 'Chapter deleted successfully.');
    }
}