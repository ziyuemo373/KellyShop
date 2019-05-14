@extends('shop.layouts.master')

@section('page_title')
    {{ __('shop.checkout.cart.title') }}
@stop

@push('css')
    <style>
        .cart-content {
            margin-top: 20px;
            width: 100%;
            display: inline-block;
        }
        .cart-content .left-side {
            width: 65%;
            float: left;
        }
        .cart-item-list .item {
            padding: 10px;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            flex-direction: row;
            border: 1px solid #c7c7c7;
            border-radius: 2px;
        }
        .cart-item-list .item .item-details {
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
            -webkit-box-pack: start;
            justify-content: flex-start;
            width: 100%;
        }
        .cart-item-list .item .item-details .item-title {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .cart-item-list .item .item-details .price {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 600;
        }
        .cart-item-list .item .item-details .misc {
            display: flex;
            width: 100%;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            flex-direction: row;
            -webkit-box-pack: start;
            justify-content: flex-start;
            -webkit-box-align: start;
            align-items: flex-start;
        }
        .cart-item-list .item .item-details .misc .control-group {
            font-size: 16px!important;
            width: 220px;
            margin: 0;
        }
        .cart-item-list .item .item-details .misc .control-group label {
            margin-right: 15px;
        }
        .cart-item-list .item .item-details .misc .control-group .control {
            height: 38px;
            width: 60px;
            border-radius: 3px;
            text-align: center;
            line-height: 38px;
        }
        .cart-item-list .item .item-details .misc .remove {
            margin-top: 8px;
            margin-right: 15px;
        }
        .cart-content .right-side {
            width: 30%;
            display: inline-block;
            padding-left: 40px;
        }
        .order-summary .payble-amount {
            margin-top: 17px;
            border-top: 1px solid #c7c7c7;
            padding-top: 12px;
        }
    </style>
@endpush

@section('content-wrapper')
    @if(!empty($cart))
        <div class="panel panel-default mt-20 cl">
            <div>
                <h1>{{ __('shop.checkout.cart.title') }}</h1>
            </div>
            <div class="cart-content">
                <div class="left-side">
                    <form action="{{ route('shop.checkout.cart.update') }}" method="POST">
                        <div class="cart-item-list" style="margin-top: 0px;">
                            @csrf()
                            @foreach($cart->items as $cartItem)
                                <div class="item mt-5">
                                    <div class="item-image" style="margin-right: 15px;">
                                        <a href="{{ route('shop.products.index', $cartItem->product->id) }}">
                                            {{--pending: 还没支持product图片，暂时用临时图片代替--}}
                                            <img src="{{ asset('images/product-icon.png') }}">
                                        </a>
                                    </div>
                                    <div class="item-details">
                                        <div class="item-title">
                                            <a href="{{ route('shop.products.index', $cartItem->product->id) }}">{{ $cartItem->product->text }}</a>
                                        </div>
                                        <div class="price">${{ $cartItem->product->price }}</div>
                                        <div class="misc">
                                            <div class="control-group">
                                                <div class="wrap">
                                                    <label for="qty[{{ $cartItem->id }}]">{{ __('shop.products.quantity') }}</label>
                                                    <input class="control" type="text" name="qty[{{ $cartItem->id }}]" value="{{ $cartItem->quantity }}" >
                                                </div>
                                            </div>
                                            <a class="remove btn btn-primary" href="{{ route('shop.checkout.cart.remove', $cartItem->id) }}" onclick="removeLink('Do you really want to do this?')">{{ __('shop.checkout.cart.remove') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="misc-controls mt-20">
                            <div class="f-l">
                                <a class="text-l btn btn-link radius" href="{{ route('shop.home.index') }}" >{{ __('shop.checkout.cart.continue-shopping') }}</a>
                            </div>
                            <div class="text-r">
                                <button type="submit" class="btn btn-lg btn-primary text-r">
                                    {{ __('shop.checkout.cart.update-cart') }}
                                </button>
                                <a class="btn btn-primary text-r" href="{{ route('shop.checkout.onepage.index') }}" >
                                    {{ __('shop.checkout.cart.proceed-to-checkout') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="right-side">
                    <div class="order-summary"><h3>{{ __('shop.checkout.total.order-summary') }}</h3>
                        <div class="item-detail mt-20">
                            <label>{{ count($cart->items) }} {{ __('shop.checkout.total.sub-total') }} {{ __('shop.checkout.total.price') }}</label>
                            {{--pending: 需要支持货币，当前先简单处理--}}
                            <label class="f-r">${{ $cart->base_sub_total }}</label>
                        </div>
                        <div class="item-detail mt-20">
                            <label>{{ __('shop.checkout.total.tax') }}</label>
                            <label class="f-r">$0.00</label>
                        </div>
                        <div class="payble-amount">
                            <label>{{ __('shop.checkout.total.grand-total') }}</label>
                            <label class="f-r">${{ $cart->base_grand_total }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop