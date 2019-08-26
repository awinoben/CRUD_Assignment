<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier_Product extends Model
{
    protected $fillable = [
        'supply_id', 'product_id',
    ];
}
