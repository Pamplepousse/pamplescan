<?php 
namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // Display a listing of the About information
    public function index()
    {
        $aboutInfo = About::all();  // Retrieve all About entries, adjust as necessary
        return view('about.index', compact('aboutInfo'));
    }
}