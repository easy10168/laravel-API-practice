<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $appends = ['total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(cartItem::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'cart_items');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0;
        foreach ($this->cartItems as $cartItem) {
            $totalPrice += $cartItem->book->price * $cartItem->quantity;
        }
        return $totalPrice;
    }

    public function checkout($recipientData)
    {
        DB::beginTransaction();
        try {
            foreach ($this->cartItems as $cartItem) {
                $book = $cartItem->book;
                if ($book->quantity < $cartItem->quantity) {
                    return response($book->name . '數量不足', 400);
                }
            }

            $order = $this->order()->create([
                'user_id' => $this->user->id,
                'status' => 'pending',
                'email' => $recipientData['email'],
                'phone' => $recipientData['phone'],
                'address' => $recipientData['address'],
                'comment' => $recipientData['comment'],
            ]);

            foreach ($this->cartItems as $cartItem) {
                $cartItem->book()->update([
                    'quantity' => $cartItem->book->quantity - $cartItem->quantity,
                ]);
                $order->orderItems()->create([
                    'name' => $cartItem->name,
                    'book_id' => $cartItem->book_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            $this->update([
                'checkouted' => true,
            ]);

            DB::commit();
            return response($order, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response('訂購出錯，請聯絡客服', 400);
        }
    }
}
