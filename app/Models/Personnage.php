<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnage extends Model
{
    // Define the fields that are allowed to be mass-assigned
    protected $fillable = [
        'nom', 'prenom', 'sexe', 'espece', 'pseudo', 'en_vie', 
        'poste_travail', 'description_physique', 'description_generale', 
        'image', 'idmanga', 'surnom'
    ];

    // Specify the primary key if it is not 'id'
    protected $primaryKey = 'idpersonnage';

    // Define the relationship to the Manga model
    public function manga()
    {
        return $this->belongsTo(Manga::class, 'idmanga', 'idmanga');
    }
}