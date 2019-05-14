<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderItem extends Model
{
    protected $guarded = ['id', 'child', 'created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->morphTo();
    }
}
