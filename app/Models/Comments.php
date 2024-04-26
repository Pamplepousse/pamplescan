namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $fillable = ['manga_id', 'user_id', 'texte'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
