<?php
namespace App\Http\Controllers;

use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    // Handle liking a comment
    public function like(Request $request, $commentId)
    {
        $like = CommentLike::updateOrCreate(
            ['user_id' => $request->user()->id, 'comment_id' => $commentId],
            ['liked' => true]
        );

        return back();
    }

    // Handle disliking a comment
    public function dislike(Request $request, $commentId)
    {
        $like = CommentLike::updateOrCreate(
            ['user_id' => $request->user()->id, 'comment_id' => $commentId],
            ['liked' => false]
        );

        return back();
    }

    // Toggle the like status for a comment
    public function toggleLike(Request $request, $commentId)
    {
        $existing_like = CommentLike::where('user_id', $request->user()->id)
                                    ->where('comment_id', $commentId)
                                    ->first();

        if ($existing_like) {
            $liked = $existing_like->liked;
            $existing_like->delete(); // Remove the existing like/dislike
            return response()->json(['liked' => !$liked, 'count' => $this->getLikesCount($commentId)]);
        } else {
            CommentLike::create([
                'user_id' => $request->user()->id,
                'comment_id' => $commentId,
                'liked' => $request->liked
            ]);
            return response()->json(['liked' => $request->liked, 'count' => $this->getLikesCount($commentId)]);
        }
    }

    // Get the count of likes and dislikes for a comment
    private function getLikesCount($commentId)
    {
        $likes = CommentLike::where('comment_id', $commentId)->where('liked', true)->count();
        $dislikes = CommentLike::where('comment_id', $commentId)->where('liked', false)->count();
        return ['likes' => $likes, 'dislikes' => $dislikes];
    }
}