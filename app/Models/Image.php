<?php
// App/Models/Image.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['idchap', 'path'];

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class, 'idchap');
    }
}
