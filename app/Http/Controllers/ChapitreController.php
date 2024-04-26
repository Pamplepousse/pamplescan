<?php
namespace App\Http\Controllers;

use App\Models\Chapitre;
use Illuminate\Support\Facades\File;

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


}