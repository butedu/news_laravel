<x-guest-layout>
    <x-auth-card
        :headline="__('Khôi phục quyền truy cập của bạn')"
        :subheadline="__('Nhập email đã đăng ký để nhận hướng dẫn đặt lại mật khẩu và quay lại với những bản tin yêu thích.')"
        :tagline="__('Hỗ trợ nhanh')"
    >
        <x-slot name="logo">
            <a href="/">
                <x-application-logo />
            </a>
        </x-slot>

        <div class="auth-form-header">
            <h1 class="auth-title">{{ __('Quên mật khẩu?') }}</h1>
            <p class="auth-subtitle">{{ __('Chúng tôi sẽ gửi cho bạn một email kèm liên kết xác thực để đặt lại mật khẩu mới một cách nhanh chóng và an toàn.') }}</p>
        </div>

        <x-auth-session-status class="auth-status" :status="session('status')" />

        <x-auth-validation-errors class="auth-alert" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <x-label for="email" :value="__('Email đã đăng ký')" class="auth-label" />
                <x-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
                <p class="auth-helper">{{ __('Kiểm tra cả thư mục Spam hoặc Quảng cáo nếu bạn chưa thấy email trong vài phút.') }}</p>
            </div>

            <x-button class="auth-button">
                {{ __('Gửi liên kết đặt lại mật khẩu') }}
            </x-button>
        </form>

        <x-slot name="footer">
            <span>{{ __('Nhớ mật khẩu rồi?') }}</span>
            <a class="auth-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>
