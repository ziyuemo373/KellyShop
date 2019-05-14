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
        <link rel="stylesheet" href="{{ asset('static/h-ui.admin/skin/default/skin.css') }}" id="skin">
        <link rel="stylesheet" href="{{ asset('lib/Hui-iconfont/1.0.8/iconfont.css') }}">
        <link rel="stylesheet" href="{{ asset('static/h-ui.admin/css/style.css') }}">
        @stack('css')
        @yield('head')
    </head>

    <body>

        @include('admin.layouts.header')

        @include('admin.layouts.aside')

        <section class="Hui-article-box">
            @include('admin.layouts.breadcrumb')
            <div class="Hui-article">
                <article class="cl pd-20">
                    @yield('content-wrapper')
                </article>
            </div>
        </section>

        <script type="text/javascript" src="{{ asset('lib/jquery/1.9.1/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ asset('lib/layer/2.4/layer.js') }}"></script>
        <script type="text/javascript" src="{{ asset('static/h-ui/js/H-ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
        <script type="text/javascript" src="{{ asset('lib/validform/Validform_v5.3.2.js') }}"></script>
        @stack('scripts')

    </body>
</html>