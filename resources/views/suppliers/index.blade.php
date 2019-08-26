@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><a class="btn btn-dark" href="{{ route('home') }}">Products</a>  | <a class="btn btn-primary" href="{{ route('orders') }}">Orders</a> | <a class="btn btn-success" href="{{ route('suppliers') }}">Suppliers</a></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container">
                            <div class="row">
                                <div class="productAdd col-lg-12 text-right" style="margin-bottom: 20px;">
                                    <a href="{{url('/new-supplier')}}" class="btn btn-outline-success">Add Supplier</a>
                                </div>
                            </div>
                            <suppliers-Index></suppliers-Index>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
