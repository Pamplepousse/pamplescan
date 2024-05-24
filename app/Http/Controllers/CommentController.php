<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
 public function store(Request $request) {
        $request->validate([
            'manga_id' => 'required|integer|exists:mangas,idmanga',
            'content' => 'required|string'
        ]);

        $comment = new Comment();
        $comment->manga_id = $request->manga_id;
        $comment->user_id = Auth::id();  // Assurez-vous que l'utilisateur est connecté
        $comment->content = $request->content;
        $comment->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }
}
