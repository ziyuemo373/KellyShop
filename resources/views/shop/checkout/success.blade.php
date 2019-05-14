@extends('shop.layouts.master')

@section('page_title')
    {{ __('shop.checkout.success.title') }}
@stop

@section('content-wrapper')

    <div class="order-success-content" style="min-height: 300px;">

        <h1>{{ __('shop.checkout.success.thanks') }}</h1>

        <p>{{ __('shop.checkout.success.order-id-info', ['order_id' => $order->id]) }}</p>

        <p>{{ __('shop.checkout.success.info') }}</p>

        <div class="misc-controls">
            <a style="display: inline-block" href="{{ route('shop.home.index') }}" class="btn btn-lg btn-primary">
                {{ __('shop.checkout.cart.continue-shopping') }}
            </a>
        </div>

    </div>

@endsection