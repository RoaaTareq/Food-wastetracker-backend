<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'password'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function wasteFoods()
    {
        return $this->hasMany(WasteFood::class);
    }
}
