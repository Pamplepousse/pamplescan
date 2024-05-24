<?php 
namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $aboutInfo = About::all();  
        return view('about.index', compact('aboutInfo'));
    }
}
