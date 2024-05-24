<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    // Définit le nom de la table si différent du nom du modèle au pluriel
     protected $table = 'mangas';
   

    // Spécifie la clé primaire si elle n'est pas 'id'
    protected $primaryKey = 'idmanga';
    public $incrementing = true;
    // Désactive les timestamps si non utilisés
    public $timestamps = false;

    // Définit les champs que vous autorisez à être remplis en masse
     protected $fillable = [
        'userpubli', 'titres', 'auteur', 'dates', 'cover', 'statut', 'categorie', 'descri'
    ];

    // Casts automatiques de types pour les champs spécifiques (facultatif)
    protected $casts = [
        'dates' => 'datetime',
    ];
    // Dans App\Models\Manga.php
// App/Models/Manga.php
// App\Models\Manga.php
 public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_manga', 'manga_id', 'category_id');
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'manga_id', 'idmanga');
    }
    public function categoriesNames()
    {
        $categoryIds = explode(',', $this->categorie);  // Assumant que 'categorie' est une liste d'IDs séparés par des virgules
        return Category::whereIn('id', $categoryIds)->get()->pluck('name');
    }
public function chapitres()
    {
        return $this->hasMany(Chapitre::class, 'idmanga');
    }

}