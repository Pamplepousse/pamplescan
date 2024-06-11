<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    // Specify the table name if different from the model name in plural form
    protected $table = 'mangas';

    // Specify the primary key if it is not 'id'
    protected $primaryKey = 'idmanga';
    public $incrementing = true;

    // Disable timestamps if not used
    public $timestamps = false;

    // Define the fields that are allowed to be mass-assigned
    protected $fillable = [
        'userpubli', 'titres', 'auteur', 'dates', 'cover', 'statut', 'categorie', 'descri'
    ];

    // Automatic type casting for specific fields (optional)
    protected $casts = [
        'dates' => 'datetime',
    ];

    // Define the relationship to the Personnage model
    public function personnages()
    {
        return $this->hasMany(Personnage::class, 'idmanga', 'idmanga');
    }

    // Define the many-to-many relationship to the Category model
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_manga', 'manga_id', 'category_id');
    }

    // Define the relationship to the Comment model
    public function comments() {
        return $this->hasMany(Comment::class, 'manga_id', 'idmanga');
    }

    // Retrieve the names of the categories for the manga
    public function categoriesNames()
    {
        $categoryIds = explode(',', $this->categorie);  // Assuming 'categorie' is a list of IDs separated by commas
        return Category::whereIn('id', $categoryIds)->get()->pluck('name');
    }

    // Define the relationship to the Chapitre model
    public function chapitres()
    {
        return $this->hasMany(Chapitre::class, 'idmanga');
    }
}