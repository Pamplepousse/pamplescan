<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = ['user_id', 'comment_id', 'liked']; // Ensure the fields are listed correctly for mass assignment

    // Define the relationship to the Comment model
    public function comment() {
        return $this->belongsTo(Comment::class);
    }

    // Define the relationship to the User model
    public function user() {
        return $this->belongsTo(User::class);
    }
}