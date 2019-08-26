<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function  index()
    {
        return view('products.index');
    }
    /*
   *Product form
   */
    public function addProduct() {
        return view('products.add');
    }
}
