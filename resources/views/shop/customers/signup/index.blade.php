@extends('shop.layouts.master')
@section('page_title')
    {{ __('shop.customer.signup-form.page-title') }}
@endsection
@section('content-wrapper')
    <h3>{{ __('shop.customer.signup-text.account_exists') }} - <a class="btn-link" href="{{ route('customer.session.index') }}">{{ __('shop.customer.signup-text.title') }}</a></h3>
    <div class="panel panel-default mt-20">
        <div class="panel-header">{{ __('shop.customer.signup-form.title') }}</div>
        <div class="panel-body">
            <form action="{{ route('customer.register.create') }}" method="post" class="form form-horizontal responsive" id="signupform">
                {{ csrf_field() }}
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.signup-form.firstname') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text" name="first_name" id="first_name" autocomplete="off" type="text" datatype="*" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.signup-form.firstname')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.signup-form.lastname') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text" name="last_name" id="last_name" autocomplete="off" type="text" datatype="*" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.signup-form.lastname')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.signup-form.email') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text required" name="email" id="email" autocomplete="off" type="text" datatype="e" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.signup-form.email')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.signup-form.password') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text" autocomplete="off" name="password" id="password" type="password" datatype="*6-16" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.signup-form.password')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('shop.customer.signup-form.confirm_pass') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text" autocomplete="off" name="password_confirmation" id="password_confirmation" type="password" recheck="password" datatype="*6-16" nullmsg="{{ __('validation.required', ['attribute' =>  __('shop.customer.signup-form.confirm_pass')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>

                <div class="row cl">
                    <div class="col-xs-8 col-xs-offset-3">
                        <input class="btn btn-primary" value="{{ __('shop.customer.signup-form.button_title') }}" type="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#signupform").Validform({
                tiptype: 2,
            });
        });
    </script>
@endpush