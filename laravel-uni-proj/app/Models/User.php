namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }
}