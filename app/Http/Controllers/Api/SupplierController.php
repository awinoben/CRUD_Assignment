<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Supplier as SupplierResource;
use App\Supplier;
use App\Supplier_Product;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SupplierResource(Supplier::paginate(3));
    }    /**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'product_id' => ['required'],
        ]);

        $supplier = Supplier::create([
            'name' => $request['name']
        ]);

        $supplier->save();

        $supplyId = $supplier->id;

        Supplier_Product::create([
            'supply_id' => $supplyId,
            'product_id' => $request['product_id']
        ]);

        return new SupplierResource($supplier);
    }    /**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show($id)
    {
        return new SupplierResource(Supplier::FindOrFail($id));
    }    /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {
        //I am doing validation here
        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->save();

        return new SupplierResource($supplier);
    }    /**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return new SupplierResource($supplier);
    }
}
