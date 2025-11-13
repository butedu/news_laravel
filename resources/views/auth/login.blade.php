<x-guest-layout>
    <x-auth-card
        :headline="__('Đọc báo thông minh, cập nhật tức thời')"
        :subheadline="__('Đăng nhập để nhận bản tin cá nhân hóa, lưu bài viết hay và tương tác cùng cộng đồng độc giả TDQ News.')"
        :tagline="__('TDQ News')"
    >
        <x-slot name="logo">
            <a href="/">
                <x-application-logo />
            </a>
        </x-slot>

        <div class="auth-form-header">
            <h1 class="auth-title">{{ __('Chào mừng bạn trở lại') }}</h1>
            <p class="auth-subtitle">{{ __('Tiếp tục hành trình khám phá những góc nhìn mới về thế giới xung quanh bạn.') }}</p>
        </div>

        <x-auth-session-status class="auth-status" :status="session('status')" />

        <x-auth-validation-errors class="auth-alert" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <x-label for="email" :value="__('Email')" class="auth-label" />
                <x-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
            </div>

            <div class="auth-field">
                <x-label for="password" :value="__('Mật khẩu')" class="auth-label" />
                <x-input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="********" />
            </div>

            <div class="auth-meta">
                <label for="remember_me" class="auth-checkbox">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>{{ __('Nhớ đăng nhập') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">{{ __('Quên mật khẩu?') }}</a>
                @endif
            </div>

            <x-button class="auth-button">
                {{ __('Đăng nhập') }}
            </x-button>
        </form>

        <x-slot name="footer">
            <span>{{ __('Chưa có tài khoản?') }}</span>
            <a class="auth-link" href="{{ route('register') }}">{{ __('Đăng ký ngay') }}</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>
