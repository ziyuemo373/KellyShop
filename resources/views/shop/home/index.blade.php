@extends('shop.layouts.master')

@section('page_title')
    {{ __('shop.home.page-title') }}
@stop

@push('css')
    <style>
        .product-card{
            position: relative;
            padding: 15px;
        }
        .product-image{
            max-height: 350px;
            max-width: 280px;
            margin-bottom: 10px;
            background: #f2f2f2;
        }
        .product-name{
            margin-bottom: 14px;
            width: 100%;
            color: #242424;
        }
        .product-price{
            margin-bottom: 14px;
            width: 100%;
            font-weight: 600;
        }
    </style>
@endpush

@section('content-wrapper')

    {{--搜索栏--}}
    <div class="text-c mt-30">
        <input type="text" name="" id="" style="width:250px" class="input-text">
        <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont Hui-iconfont-search2"></i> {{ __('shop.header.search-text') }}</button>
    </div>

    {{--导航栏--}}
    {{--pending: 需要改成用css设置background，当前先简单处理--}}
    <div class="mt-20" style="background: #00b7ee;">
        <div class="container cl">
            <nav class="nav navbar-nav nav-collapse" role="navigation" id="Hui-navbar">
                <ul class="cl">
                    @if(count($categories) > 0)
                        <li class="dropDown dropDown_hover">
                            <a href="javascript:;" class="dropDown_A">{{ __('shop.home.category') }} <i class="Hui-iconfont Hui-iconfont-arrow2-bottom"></i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                @foreach($categories as $category)
                                    <li class="">
                                        {{--pending: 支持支持国际化--}}
                                        <a href="">{{ $category->name }}
                                            @if(count($category->children) > 0)
                                                <i class="arrow Hui-iconfont Hui-iconfont-arrow2-right"></i>
                                            @endif
                                        </a>
                                        @if(count($category->children))
                                            <ul class="menu">
                                                @foreach($category->children as $subcategory)
                                                    <li class="">
                                                        <a href="">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('shop.home.index') }}">{{ __("shop.home.new-products") }}</a>
                    </li>
                </ul>
            </nav>
            <nav class="navbar-userbar hidden-xs"></nav>
        </div>
    </div>

    {{--内容页--}}
    <div class="panel panel-default mt-20">
        <div class="row cl">
            @foreach($products as $product)
                <div class="col-xs-12 col-sm-3">
                    <div class="product-card">
                        <div class="product-image">
                            {{--pending: 还没支持product图片，暂时用临时图片代替--}}
                            <img src="{{ asset('images/product-icon.png') }}">
                        </div>
                        <div class="product-information">
                            <div class="product-name">
                                {{--pending: 需要支持国际化--}}
                                <a href="{{ route('shop.products.index', $product->id) }}" title="{{ $product->text }}">
                                    <span>{{ $product->text }}</span>
                                </a>
                            </div>
                            <div class="product-price">
                                {{--pending: 还没支持区分货币--}}
                                <span>${{ $product->price }}</span>
                            </div>
                            <div class="cart-wish-wrap">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf()
                                    <input type="hidden" name="product" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-primary">{{ __('shop.products.add-to-cart') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@stop
