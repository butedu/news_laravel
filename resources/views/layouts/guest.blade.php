<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="icon" type="image/png" href="{{ asset('kcnew/frontend/img/image_iconLogo.png') }}"  sizes="160x160">
        <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
        <title>VN News | Tài khoản</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="auth-body font-sans antialiased">
        {{ $slot }}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-password-toggle="button"]').forEach(function (button) {
                    var field = button.closest('.auth-password-field');
                    if (!field) {
                        return;
                    }

                    var input = field.querySelector('[data-password-toggle="input"]');
                    if (!input) {
                        return;
                    }

                    button.addEventListener('click', function () {
                        var isHidden = input.type === 'password';
                        input.type = isHidden ? 'text' : 'password';
                        button.textContent = isHidden ? 'Ẩn' : 'Hiện';
                        button.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
                        button.classList.toggle('is-active', isHidden);
                    });
                });
            });
        </script>
    </body>
</html>
