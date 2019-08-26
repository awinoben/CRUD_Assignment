@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="postAdd col-lg-12 text-right" style="margin-bottom: 20px;">
                <a href="{{url('add-product')}}" class="btn btn-primary">Add Product</a>
            </div>
        </div>
        <products-index></products-index>
    </div>
@endsection
