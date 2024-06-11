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
    // Display the chapters of a specific manga
    public function showChapitres($id)
    {
        $manga = Manga::with('chapitres')->findOrFail($id); // Retrieve manga with its chapters
        return view('mangas.chapitres', ['manga' => $manga]);
    }

    // Display the latest mangas and chapters on the homepage
    public function index()
    {
        $mangas = Manga::latest('created_at')->take(6)->get(); // Get the latest 6 mangas
        $latestChapters = Chapitre::with('manga')->latest('created_at')->take(9)->get(); // Get the latest 9 chapters

        return view('welcome', compact('mangas', 'latestChapters'));
    }

    // Show the form to create a new manga
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('mangas.create', compact('categories'));
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
        $manga->userpubli = Auth::id(); // Set the user who published the manga

        if ($request->hasFile('cover')) {
            $filename = Str::slug($request->titres, '_') . '.jpg';
            $destinationPath = public_path('picture/cover'); // Define the target public folder path
            $request->file('cover')->move($destinationPath, $filename);
            $manga->cover = 'public/picture/cover/' . $filename; // Save the relative path
        }

        $manga->save();
        $manga->categories()->sync($request->categories); // Sync the manga with the selected categories

        return redirect()->route('home')->with('success', 'Manga added successfully.');
    }

    // Show the form to edit an existing manga
    public function edit($id)
    {
        $manga = Manga::findOrFail($id); // Retrieve the manga
        $categories = Category::all(); // Get all categories
        return view('mangas.edit', compact('manga', 'categories'));
    }

    // Update the specified manga in the database
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

        $manga = Manga::findOrFail($id); // Retrieve the manga
        $manga->fill($request->only('titres', 'auteur', 'dates', 'descri', 'statut'));

        if ($request->hasFile('cover')) {
            $filename = Str::slug($request->titres, '_') . '.jpg';
            $destinationPath = public_path('picture/cover'); // Define the target public folder path
            $request->file('cover')->move($destinationPath, $filename);
            $manga->cover = 'public/picture/cover/' . $filename; // Save the relative path
        }

        $manga->save();
        $manga->categories()->sync($request->categories); // Sync the manga with the selected categories

        return redirect()->route('home')->with('success', 'Manga updated successfully.');
    }

    // Display the details of a specific manga
    public function show($idmanga)
    {
        $manga = Manga::with('chapitres')->findOrFail($idmanga); // Retrieve the manga with its chapters
        return view('mangas.show', ['manga' => $manga]);
    }
}