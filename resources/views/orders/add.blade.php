@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><a class="btn btn-dark" href="{{ route('home') }}">Products</a>  | <a class="btn btn-primary" href="{{ route('orders') }}">Orders</a> | <a class="btn btn-success" href="{{ route('suppliers') }}">Suppliers</a></div>
                    <div class="card-body">
                        <orders-create></orders-create>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection