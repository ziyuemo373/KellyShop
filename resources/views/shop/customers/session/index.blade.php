@extends('shop.layouts.master')
@section('page_title')
    {{ __('shop.customer.login-form.page-title') }}
@endsection
@section('content-wrapper')
    <h3>{{ __('shop.customer.login-text.no_account') }} - <a class="btn-link" href="{{ route('customer.register.index') }}">{{ __('shop.customer.login-text.title') }}</a></h3>
    <div class="panel panel-default mt-20">
        <div class="panel-header">{{ __('shop.customer.login-form.title') }}</div>
        <div class="panel-body">
            <form action="{{ route('customer.session.create') }}" method="post" class="form form-horizontal responsive" id="sessionform">
                {{ csrf_field() }}
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.login-form.email') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text required" name="email" id="email" autocomplete="off" type="text" datatype="e" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.login-form.email')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.login-form.password') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text required" autocomplete="off" name="password" id="password" type="password" datatype="*6-16" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.login-form.password')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-xs-offset-3">
                        {{--{{ route('customer.forgot-password.create') }}--}}
                        <a class="btn-link" href="">{{ __('shop.customer.login-form.forgot_pass') }}</a>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-xs-offset-3">
                        <input class="btn btn-primary" value="{{ __('shop.customer.login-form.button_title') }}" type="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#sessionform").Validform({
                tiptype: 2,
            });
        });
    </script>
@endpush