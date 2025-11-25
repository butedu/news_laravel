<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'newsletter';

    protected $fillable = ['email'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_newsletter')->withTimestamps();
    }
}
