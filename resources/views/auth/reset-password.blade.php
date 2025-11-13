<x-guest-layout>
    <x-auth-card
        :headline="__('Đặt lại mật khẩu an toàn')"
        :subheadline="__('Tạo mật khẩu mới đủ mạnh để bảo vệ tài khoản TDQ News của bạn và tiếp tục cập nhật tin tức mỗi ngày.')"
        :tagline="__('Bảo mật tối đa')"
    >
        <x-slot name="logo">
            <a href="/">
                <x-application-logo />
            </a>
        </x-slot>

        <div class="auth-form-header">
            <h1 class="auth-title">{{ __('Thiết lập mật khẩu mới') }}</h1>
            <p class="auth-subtitle">{{ __('Nhập mật khẩu mới cho tài khoản của bạn. Đừng quên chọn mật khẩu khó đoán để đảm bảo an toàn.') }}</p>
        </div>

        <x-auth-validation-errors class="auth-alert" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-field">
                <x-label for="email" :value="__('Email đăng ký')" class="auth-label" />
                <x-input id="email" class="auth-input" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="name@example.com" />
            </div>

            <div class="auth-field">
                <x-label for="password" :value="__('Mật khẩu mới')" class="auth-label" />
                <x-input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="Ít nhất 8 ký tự" />
            </div>

            <div class="auth-field">
                <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu mới')" class="auth-label" />
                <x-input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu" />
            </div>

            <x-button class="auth-button">
                {{ __('Cập nhật mật khẩu') }}
            </x-button>
        </form>

        <x-slot name="footer">
            <span>{{ __('Quay lại trang') }}</span>
            <a class="auth-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>
