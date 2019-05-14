@extends('shop.layouts.master')

@section('page_title')
    {{ __('shop.home.page-title') }}
@stop

@push('css')
    <style>
        .product-form{
            display: flex;
            width: 100%;
        }
        .product-image-group {
            position:relative;
            margin-right: 30px;
            margin-left: 15px;
            width: 300px;
            height: 450px;
            max-width: 604px;
            top: 10px;
        }
        .product-image{
            max-height: 350px;
            max-width: 280px;
            margin-bottom: 10px;
            background: #f2f2f2;
        }
        .product-details {
            width: 45%;
        }
        .product-price {
            margin-bottom: 15px;
            width: 100%;
            font-weight: 600;
        }
        .description{
            margin-bottom: 15px;
        }
        .quantity {
            padding-top: 15px;
            border-top: 1px solid hsla(0,0%,64%,.2);
        }
        .control-group {
            display: block;
            margin-bottom: 25px;
            font-size: 15px;
            color: #333;
            width: 750px;
            max-width: 100%;
            position: relative;
        }
        .control-group label {
            display: block;
            color: #3a3a3a;
        }
        .control-group .control {
            background: #fff;
            border: 2px solid #c7c7c7;
            border-radius: 3px;
            height: 36px;
            display: inline-block;
            vertical-align: middle;
            transition: .2s cubic-bezier(.4,0,.2,1);
            padding: 0 10px;
            font-size: 15px;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    </style>
@endpush

@section('content-wrapper')
    @if(!empty($product))
        <div class="panel panel-default mt-20 cl">
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf()
                <div class="product-image-group f-l">
                    <div class="product-image">
                        {{--pending: 还没支持product图片，暂时用临时图片代替--}}
                        <img src="{{ asset('images/product-icon.png') }}">
                    </div>
                    <button class="btn btn-primary">{{ __('shop.products.add-to-cart') }}</button>
                </div>
                <div class="product-details f-l">
                    <div class="product-heading"><h1>{{ $product->text }}</h1></div>
                    <div class="product-price"><span>${{ $product->price }}</span></div>
                    {{--pending: product description有待补充--}}
                    <div class="description"><p>{{ $product->text }} description</p></div>
                    <div class="quantity control-group">
                        <label>{{ __('shop.products.quantity') }}</label>
                        <input class="control" name="quantity" value="1" style="width: 60px;">
                    </div>
                </div>
            </form>
        </div>
    @endif
@stop