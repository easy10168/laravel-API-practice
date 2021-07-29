<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function cart()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
