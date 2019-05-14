<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>@yield('page_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <link rel="stylesheet" href="{{ asset('static/h-ui/css/H-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('static/h-ui.admin/css/H-ui.admin.css') }}">
        <link rel="stylesheet" href="{{ asset('lib/Hui-iconfont/1.0.8/iconfont.css') }}">
        @yield('css')
    </head>
    <body>
        <div class="containBox">
            <div class="wap-container">
                <div class="container ui-sortable">
                    @yield('content-wrapper')
                </div>
            </div>
            <div class="footer mt-20">
                <p>
                    {{ __('admin.footer.copy-right') }}
                </p>
            </div>
        </div>
        @stack('javascript')
    </body>
</html>