<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::with(['cartItems'])
            ->where([
                ['user_id', Auth::user()->id],
                ['checkouted', false]
            ])
            ->firstOrCreate([
                'user_id' => Auth::user()->id
            ]);

        return response(['data' => $cart]);
    }

    public function checkout()
    {
        $user = Auth::user();
        $cart = $user->carts()->with('checkouted', false)->first();
        if ($cart) {
            $result = $cart->checkout();
            return response($result);
        } else {
            return response('沒有購物車', 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
