<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Detail extends Model
{
    protected $fillable = [
        'order_id', 'product_id',
    ];
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
