<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $with = ['items'];

    public function items() {
        return $this->hasMany(CartItem::class);
    }
}
