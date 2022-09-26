<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ config('app.name') }}">
        @yield('meta')
        <link href="/favicon.ico?v1" rel="shortcut icon" type="image/x-icon" />
        <style>
            * {
                --company-color: {{ $companyColor }};
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
        <title>{{ config('app.name') }} | @yield('title')</title>
    </head>
    <body>
        <div class="modal-window">
            <div class="modal">
                <div class="modal-wrapper"></div>
            </div>
        </div>

        <div class="content @yield('content-class')">
        @yield('content')
        </div>

        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.maskedinput.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/modalWindow.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
