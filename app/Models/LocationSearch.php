<?php
// app/Models/LocationSearch.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSearch extends Model
{
    use HasFactory;

    protected $table = 'location_searches';

    protected $fillable = ['user_id', 'origin', 'destination', 'frequency'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}