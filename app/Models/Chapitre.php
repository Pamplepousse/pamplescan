<?php
// App/Models/Chapitre.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Chapitre extends Model
{
        protected $fillable = ['idchap', 'idmanga', 'numchap', 'titlechap', 'content', 'dates', 'path'];
    // Ou si vous utilisez guarded, assurez-vous qu'il ne bloque pas 'path'
    protected $guarded = [];
            protected $primaryKey = 'idchap';
             public $timestamps = false;

    // Assurez-vous que l'ID est correctement configuré et accessible
    public function getImagesAttribute()
    {
        $path = storage_path('app/public/' . $this->path);

        if (!file_exists($path)) {
            return [];
        }

        $files = scandir($path);
        // Filtrer pour enlever les éléments . et ..
        $images = array_diff($files, array('.', '..'));

        // Créer les chemins complets pour les images
        $imagePaths = array_map(function ($image) use ($path) {
            return asset('storage/' . $this->path . '/' . $image);
        }, $images);

        return $imagePaths;
    }
    public function manga()
    {
        return $this->belongsTo(Manga::class, 'idmanga', 'idmanga');
    }
}
