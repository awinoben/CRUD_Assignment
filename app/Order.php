<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
    ];
    public function orderdetails()
    {
        return $this->belongsToMany(Order_Detail::class);
    }
}
