<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'manga_id', 'content']; // Assurez-vous que les champs sont correctement listés pour l'assignation en masse

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function manga() {
        // Spécifiez la clé étrangère correcte et la clé primaire de Manga
        return $this->belongsTo(Manga::class, 'manga_id', 'idmanga');
    }
     public function likes() {
        return $this->hasMany(CommentLike::class);
    }

    public function userLikes() {
        return $this->hasMany(CommentLike::class)->where('liked', true);
    }

    public function userDislikes() {
        return $this->hasMany(CommentLike::class)->where('liked', false);
    }
}
