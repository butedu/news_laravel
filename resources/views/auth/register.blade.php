<x-guest-layout>
    <x-auth-card
        :headline="__('Gia nhập cộng đồng độc giả thông minh')"
        :subheadline="__('Tạo tài khoản VN News để tùy biến trải nghiệm đọc tin, lưu bài viết ưa thích và nhận nhắc nhở nội dung phù hợp mỗi ngày.')"
        :tagline="__('Thành viên mới')"
    >
        <x-slot name="logo">
            <a href="/">
                <x-application-logo />
            </a>
        </x-slot>

        <div class="auth-form-header">
            <h1 class="auth-title">{{ __('Tạo tài khoản VN News') }}</h1>
            <p class="auth-subtitle">{{ __('Chỉ mất vài bước để mở khóa kho nội dung và các tiện ích cá nhân hóa dành riêng cho bạn.') }}</p>
        </div>

        <x-auth-validation-errors class="auth-alert" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <x-label for="name" :value="__('Họ và tên đầy đủ')" class="auth-label" />
                <x-input id="name" class="auth-input" type="text" name="name" :value="old('name')" required autofocus placeholder="Nguyễn Văn A" />
            </div>

            <div class="auth-field">
                <x-label for="email" :value="__('Email liên hệ')" class="auth-label" />
                <x-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required placeholder="name@example.com" />
            </div>

            <div class="auth-field">
                <x-label for="password" :value="__('Mật khẩu mới')" class="auth-label" />
                <div class="auth-password-field">
                    <x-input id="password" class="auth-input" type="password" name="password" required autocomplete="new-password" placeholder="Ít nhất 8 ký tự" data-password-toggle="input" />
                    <button type="button" class="auth-password-toggle" data-password-toggle="button" aria-label="{{ __('Hiển thị mật khẩu') }}" aria-pressed="false">{{ __('Hiện') }}</button>
                </div>
                <p class="auth-helper">{{ __('Sử dụng tối thiểu 8 ký tự, kết hợp chữ hoa, chữ thường và số để tăng độ an toàn.') }}</p>
            </div>

            <div class="auth-field">
                <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" class="auth-label" />
                <div class="auth-password-field">
                    <x-input id="password_confirmation" class="auth-input" type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu" data-password-toggle="input" />
                    <button type="button" class="auth-password-toggle" data-password-toggle="button" aria-label="{{ __('Hiển thị mật khẩu') }}" aria-pressed="false">{{ __('Hiện') }}</button>
                </div>
            </div>

            <x-button class="auth-button">
                {{ __('Đăng ký tài khoản') }}
            </x-button>
        </form>

        <x-slot name="footer">
            <span>{{ __('Đã có tài khoản?') }}</span>
            <a class="auth-link" href="{{ route('login') }}">{{ __('Đăng nhập ngay') }}</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>
