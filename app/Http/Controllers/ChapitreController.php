<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Manga;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ChapitreController extends Controller
{
    // Display a specific chapter
    public function show($idchap)
    {
        $chapitre = Chapitre::with('manga')->findOrFail($idchap); // Retrieve the chapter with its manga
        $path = public_path($chapitre->path);

        // Retrieve the images in the chapter's directory
        $images = [];
        if (File::exists($path)) {
            $files = File::files($path);
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'png', 'gif'])) {
                    $images[] = asset('/public/' . $chapitre->path . '/' . $file->getFilename());

                    \Log::info($files);
                    \Log::info($images);
                }
            }
        }

        // Find the previous and next chapters
        $prevChapitre = Chapitre::where('idmanga', $chapitre->idmanga)
                                ->where('idchap', '<', $idchap)
                                ->orderBy('idchap', 'desc')
                                ->first();
        $nextChapitre = Chapitre::where('idmanga', $chapitre->idmanga)
                                ->where('idchap', '>', $idchap)
                                ->orderBy('idchap', 'asc')
                                ->first();

        return view('chapitres.show', compact('chapitre', 'images', 'prevChapitre', 'nextChapitre'));
    }

    // Display a list of chapters
    public function index()
    {
        $chapitres = Chapitre::with('manga')->paginate(10); // Paginate the chapters with their mangas
        return view('chapitres.index', compact('chapitres'));
    }

    // Show the form to create a new chapter
    public function create()
    {
        $mangas = Manga::all(); // Retrieve all mangas
        return view('chapitres.create', compact('mangas'));
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

        return redirect()->route('chapitres.index')->with('success', 'Chapter added successfully.');
    }
}