<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function  index()
    {
        return view('suppliers.index');
    }
    /*
   *Product form
   */
    public function newSupplier() {
        return view('suppliers.add');
    }
}
