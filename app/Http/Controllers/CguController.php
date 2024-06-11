<?php
namespace App\Http\Controllers;

use App\Models\Cgu;
use Illuminate\Http\Request;

class CguController extends Controller
{
    // Display a listing of the CGU (terms and conditions)
    public function index()
    {
        $cguInfo = Cgu::all();  // Retrieve all CGU entries, adjust as necessary
        return view('cgu.index', compact('cguInfo'));
    }
}
```