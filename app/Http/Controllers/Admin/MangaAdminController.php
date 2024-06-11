<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MangaAdminController extends Controller
{
    // Display a listing of all mangas
    public function index() {
        $mangas = Manga::all();
        return view('admin.mangas.index', compact('mangas'));
    }

    // Show the form for creating a new manga
    public function create() {
        $categories = Category::all();
        return view('admin.mangas.create', compact('categories'));
    }

    // Store a newly created manga in the database
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
            $destinationPath = public_path('picture/cover'); // Define the target public folder path
            $request->file('cover')->move($destinationPath, $filename);
            $manga->cover = 'public/picture/cover/' . $filename; // Save the relative path
        }

        $manga->save();
        $manga->categories()->sync($request->categories);

        return redirect()->route('admin.mangas.index')->with('success', 'Manga added successfully.');
    }

    // Show the form for editing an existing manga
    public function edit(Manga $manga)
    {
        $categories = Category::all();
        return view('admin.mangas.edit', compact('manga', 'categories'));
    }

    // Update the specified manga in the database
    public function update(Request $request, Manga $manga)
    {
        $request->validate([
            'titres' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'dates' => 'required|date',
            'cover' => 'required|string', // Optionally validate if this is a valid URL
            'statut' => 'required|in:licensed,unlicensed',
            'descri' => 'required|string',
            'categories' => 'required|array', // Add validation for categories
        ]);

        $manga->update($request->only('titres', 'auteur', 'dates', 'cover', 'statut', 'descri'));

        // Sync the categories
        $manga->categories()->sync($request->categories);

        return redirect()->route('admin.mangas.index')->with('success', 'Manga updated successfully.');
    }

    // Remove the specified manga from the database
    public function destroy(Manga $manga)
    {
        $manga->delete();
        return redirect()->route('admin.mangas.index')->with('success', 'Manga deleted successfully.');
    }
}