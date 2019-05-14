<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <link rel="stylesheet" href="{{ asset('static/h-ui/css/H-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/Hui-iconfont/1.0.8/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('static/h-ui.admin/skin/default/skin.css') }}">
    @stack('css')
    @yield('head')
</head>

<body>
    <div class="containBox">
        @include('shop.layouts.header')
        <div class="wap-container">
            <div class="container ui-sortable">
                @yield('content-wrapper')
            </div>
        </div>
        @include('shop.layouts.footer')
    </div>
    
    <script type="text/javascript">

    </script>
    <script type="text/javascript" src="{{ asset('lib/jquery/1.9.1/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/layer/2.4/layer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('static/h-ui/js/H-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/validform/Validform_v5.3.2.js') }}"></script>
    @stack('scripts')

    <div class="modal-overlay"></div>
</body>
</html>