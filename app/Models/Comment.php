<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'manga_id', 'content']; // Ensure the fields are listed correctly for mass assignment

    // Define the relationship to the User model
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to the Manga model with the correct foreign key and primary key
    public function manga() {
        return $this->belongsTo(Manga::class, 'manga_id', 'idmanga');
    }

    // Define the relationship to the CommentLike model
    public function likes() {
        return $this->hasMany(CommentLike::class);
    }

    // Define the relationship to user likes
    public function userLikes() {
        return $this->hasMany(CommentLike::class)->where('liked', true);
    }

    // Define the relationship to user dislikes
    public function userDislikes() {
        return $this->hasMany(CommentLike::class)->where('liked', false);
    }
}