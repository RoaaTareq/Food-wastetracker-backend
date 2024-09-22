<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    // Specify the table if it's different from the default naming convention (Optional)
    protected $table = 'hospitals';

    // Specify which columns can be mass assigned
    protected $fillable = [
        'name',
        'address',
        'phone',
        'owner_id',
    ];

    /**
     * A hospital belongs to a user (the owner).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
