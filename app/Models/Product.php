<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku','type', 'text', 'price', 'qty'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function haveSufficientQuantity($qty)
    {
        //pending: 需要改善，现在先简单处理
        $total = $this->qty;
        return $qty <= $total ? true : false;
    }
}
