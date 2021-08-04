<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [''];
    protected $hidden = ['updated_at'];
    protected $appends = ['subcategory_name', 'image_url'];

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

    public function images()
    {
        return $this->morphMany(Image::class, 'attachable');
    }

    public function getImageUrlAttribute()
    {
        $images = $this->images;
        if ($images->isNotEmpty()) {
            return Storage::url($images->last()->path);
        }
    }
}
