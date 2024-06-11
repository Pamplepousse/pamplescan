<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Manga;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // Display a listing of all categories
    public function index()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('categories.index', compact('categories'));
    }

    // Display mangas associated with a specific category
    public function showMangasByCategory($id)
    {
        // Fetch category name for display purposes (optional)
        $categoryName = DB::table('categories')->where('id', $id)->value('name');

        // Fetch mangas associated with the given category ID
        $mangas = DB::table('mangas')
            ->join('category_manga', 'mangas.idmanga', '=', 'category_manga.manga_id')
            ->where('category_manga.category_id', $id)
            ->select('mangas.*')
            ->get();

        return view('categories.show', compact('categoryName', 'mangas'));
    }
}