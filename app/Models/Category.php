<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function subCategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function books()
    {
        return $this->hasManyThrough(Book::class, Subcategory::class);
    }
}
