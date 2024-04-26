<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

public function mangas()
{
    // Si la clé étrangère dans la table pivot n'est pas 'category_id'
    return $this->belongsToMany(Manga::class, 'category_manga', 'category_id', 'idmanga');
}

}
