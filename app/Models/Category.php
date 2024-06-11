<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name']; // Allow mass assignment for the 'name' attribute

    public function mangas()
    {
        // Define a many-to-many relationship with the Manga model
        // If the foreign key in the pivot table is not 'category_id'
        return $this->belongsToMany(Manga::class, 'category_manga', 'category_id', 'idmanga');
    }
}
