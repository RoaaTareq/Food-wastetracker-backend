<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['hospital_id', 'name', 'phone', 'email', 'password'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function wasteFoods()
    {
        return $this->hasMany(WasteFood::class);
    }
}
