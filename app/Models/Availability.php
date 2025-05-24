<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'date', 'start_time', 'end_time', 'interval'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
