<?php
namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function index(Request $request)
{
    $query = $request->input('query');
    $mangas = Manga::where('titres', 'LIKE', '%' . $query . '%')
                    ->orWhere('descri', 'LIKE', '%' . $query . '%')
                    ->get();

    return view('search.results', compact('mangas', 'query'));
}


}
