<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'manga_id' => 'required|integer|exists:mangas,idmanga',
            'content' => 'required|string'
        ]);

        // Create a new comment instance
        $comment = new Comment();
        $comment->manga_id = $request->manga_id;
        $comment->user_id = Auth::id();  // Ensure the user is authenticated
        $comment->content = $request->content;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }
}