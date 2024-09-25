<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteFood extends Model
{
    protected $fillable = ['employee_id', 'hospital_id', 'category_id', 'item', 'quantity', 'reason', 'note', 'time', 'meal'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
