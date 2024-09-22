<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Explicitly specify the table name
    protected $table = 'food_categories';

    // Allow mass assignment for these fields
    protected $fillable = ['name', 'description'];
}
