<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Chapitre extends Model
{
    protected $fillable = ['idchap', 'idmanga', 'numchap', 'titlechap', 'content', 'dates', 'path']; // Allow mass assignment for these attributes
    protected $guarded = []; // Ensure 'path' is not blocked if using guarded
    protected $primaryKey = 'idchap'; // Set the primary key to 'idchap'
    public $timestamps = false; // Disable timestamps
    protected $dates = ['created_at']; // Specify the date attributes

    // Ensure the ID is correctly configured and accessible
    public function getImagesAttribute()
    {
        $path = storage_path('app/public/' . $this->path);

        if (!file_exists($path)) {
            return [];
        }

        $files = scandir($path);
        // Filter out '.' and '..' elements
        $images = array_diff($files, array('.', '..'));

        // Create full paths for the images
        $imagePaths = array_map(function ($image) {
            return asset('storage/' . $this->path . '/' . $image);
        }, $images);

        return $imagePaths;
    }

    // Define the relationship to the Manga model
    public function manga()
    {
        return $this->belongsTo(Manga::class, 'idmanga');
    }
}