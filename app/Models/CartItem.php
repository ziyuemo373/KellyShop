<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Cart;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }
}
