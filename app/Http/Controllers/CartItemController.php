<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\cartItem;
use Auth;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate(
            [
                'book_id' => ['required'],
                'quantity' => ['required', 'integer', 'min:1']
            ]
        );

        $book = Book::findOrFail($validatedRequest['book_id']);
        if ($book->quantity < $validatedRequest['quantity']) {
            return response('該書本數量不足');
        }

        $cart = Cart::where([
            'user_id' => Auth::user()->id,
            'checkouted' => false
        ])->firstOrFail();

        $isDuplicateBook = $cart->cartItems()->where('book_id', $validatedRequest['book_id'])->first();
        if ($isDuplicateBook === null) {
            $cartItems = $cart->cartItems()->create([
                'book_id' => $validatedRequest['book_id'],
                'quantity' => $validatedRequest['quantity'],
            ]);
        } else {
            $cart->cartItems()->where('book_id', $validatedRequest['book_id'])->update([
                'quantity' => $validatedRequest['quantity'],
            ]);
        }

        return response(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
