<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapitre;
use App\Models\Manga;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; 

class ChapitreController extends Controller
{
public function show($idchap)
{
    $chapitre = Chapitre::with('manga')->findOrFail($idchap);
    $path = public_path($chapitre->path);

    // Récupérer les images
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

    // Trouver les chapitres précédent et suivant
    $prevChapitre = Chapitre::where('idmanga', $chapitre->idmanga)->where('idchap', '<', $idchap)->orderBy('idchap', 'desc')->first();
    $nextChapitre = Chapitre::where('idmanga', $chapitre->idmanga)->where('idchap', '>', $idchap)->orderBy('idchap', 'asc')->first();

    return view('chapitres.show', compact('chapitre', 'images', 'prevChapitre', 'nextChapitre'));
}


public function index()
    {
        $chapitres = Chapitre::with('manga')->paginate(10);
        return view('chapitres.index', compact('chapitres'));
    }

    public function create()
    {
        $mangas = Manga::all();
        return view('chapitres.create', compact('mangas'));
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

    return redirect()->route('chapitres.index')->with('success', 'Chapitre ajouté avec succès.');
}

}