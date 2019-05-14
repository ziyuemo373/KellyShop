<?php

use App\Http\Cart;
if (! function_exists('cart')) {
    function cart()
    {
        return app()->make(Cart::class);
    }
}