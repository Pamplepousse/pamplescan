<?php // app/Http/Controllers/CguController.php
namespace App\Http\Controllers;

use App\Models\Cgu;
use Illuminate\Http\Request;

class CguController extends Controller
{
    public function index()
    {
        $cguInfo = Cgu::all();  // Récupère toutes les entrées, vous pouvez ajuster cela si nécessaire
        return view('cgu.index', compact('cguInfo'));
    }
}
