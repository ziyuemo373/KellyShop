@extends('admin.layouts.anonymous-master')

@section('page_title')
    {{ __('admin.users.sessions.title') }}
@endsection

@section('content-wrapper')
    <h1>{{ __('admin.users.sessions.title') }}</h1>
    <div class="panel panel-default mt-20">
        <div class="panel-header"></div>
        <div class="panel-body">
            <form action="{{ route('admin.session.store') }}" method="post" class="form form-horizontal responsive" id="sessionform">
                {{ csrf_field() }}
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.users.sessions.email') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text required" name="email" id="email" autocomplete="off" type="text" datatype="e" nullmsg="{{ __('validation.required', ['attribute' =>  __('admin.users.sessions.email')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3">{{ __('admin.users.sessions.password') }}：</label>
                    <div class="formControls col-xs-8">
                        <input class="input-text required" autocomplete="off" name="password" id="password" type="password" datatype="*6-16" nullmsg="{{ __('validation.required', ['attribute' =>  __('admin.users.sessions.password')]) }}">
                    </div>
                    <div class="col-xs-8 col-sm-6 col-xs-offset-4 col-sm-offset-3"> <span class="Validform_checktip"></span></div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-xs-offset-3">
                        {{--pending: 有待完善--}}
                        {{--{{ route('admin.forget-password.create') }}--}}
                        <a class="btn-link" href="">{{ __('admin.users.sessions.forget-password-link-title') }}</a>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-xs-offset-3">
                        <input class="btn btn-primary" value="{{ __('admin.users.sessions.submit-btn-title') }}" type="submit">
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