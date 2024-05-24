<?php // app/Models/Cgu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cgu extends Model
{
    protected $table = 'cgu';
    protected $fillable = ['title', 'content'];  // Assurez-vous d'ajouter 'title' ici.
}
