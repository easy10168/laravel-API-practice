<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $hidden = ['updated_at'];
    protected $appends = ['subcategory_name'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getSubcategoryNameAttribute()
    {
        return $this->subcategory()->first()->name;
    }

    // public function getCategoryIdAttribute()
    // {
    //     return $this->subcategory()->first()->category()->first()->id;
    // }

    // public function getCategoryNameAttribute()
    // {
    //     return $this->subcategory()->first()->category()->first()->name;
    // }
}
