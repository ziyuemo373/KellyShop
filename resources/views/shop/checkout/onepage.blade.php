@extends('shop.layouts.master')

@section('page_title')
    {{ __('shop.checkout.onepage.title') }}
@stop
@push('css')
    <style>
        .checkout-process {
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            flex-direction: row;
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #242424;
        }
        .checkout-process .col-main {
            width: 70%;
            margin-right: 5%;
        }
        .checkout-process .col-right {
            width: 25%;
            padding-left: 40px;
        }
    </style>
@endpush
@section('content-wrapper')
    <div class="panel panel-default mt-20 cl">
        <div class="checkout-process">
            <div class="col-main">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ route('shop.checkout.save-order') }}" class="form form-horizontal responsive" method="post">
                            @csrf()
                            <div class="row clearfix">
                                <label class="form-label col-xs-3">{{ __('shop.checkout.onepage.shipping-method') }}</label>
                                <div class="formControls col-xs-8">
                                    <div class="row clearfix" style="margin-top:0">
                                        <div class="col-xs-6">
                                                <span class="select-box">
                                                    <select class="select" size="1" name="shipping_method">
                                                        <option value="free_free">{{ __('admin.admin.system.free-shipping') }}</option>
                                                        <option value="flatrate_flatrate">{{ __('admin.admin.system.flate-rate-shipping') }}</option>
                                                    </select>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-3">{{ __('shop.checkout.onepage.payment-methods') }}</label>
                                <div class="formControls skin-minimal col-xs-5">
                                    <div class="col-xs-8 mt-5">
                                        <div class="radio-box">
                                            <input type="radio" id="free-test" name="payment[method]" value="free_test">
                                            <label for="sex-1" class="">{{ __('admin.admin.system.free-test') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 mt-5">
                                        <div class="radio-box">
                                            <input type="radio" id="alipay" name="payment[method]" value="alipay">
                                            <label for="sex-1" class="">{{ __('admin.admin.system.alipay') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row cl">
                                <div class="col-xs-8 col-xs-offset-3">
                                    <input class="btn btn-primary" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-right">
                <div>
                    <div class="order-summary">
                        <h3>{{ __('shop.checkout.onepage.order-summary') }}</h3>
                        <div class="item-detail">
                            <label>{{ count($cart->items) }} {{ __('shop.checkout.total.sub-total') }} {{ __('shop.checkout.total.price') }}
                            </label>
                            <label class="right">${{ $cart->base_sub_total }}</label>
                        </div>
                        <div class="item-detail">
                            <label>{{ __('shop.checkout.total.tax') }}</label>
                            <label class="right">$0.00</label>
                        </div>
                        <div class="payble-amount">
                            <label>{{ __('shop.checkout.total.grand-total') }}</label>
                            <label class="right">${{ $cart->base_grand_total }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
        });
    </script>
@endpush