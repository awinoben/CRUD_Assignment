<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function  index()
    {
        return view('orders.index');
    }
    /*
   *Product form
   */
    public function newOrder() {
        return view('orders.add');
    }
}
