@props([
    'headline' => __('Không bỏ lỡ bản tin nóng'),
    'subheadline' => __('Khám phá kho nội dung chọn lọc, nhận thông báo cá nhân hóa và quản lý trải nghiệm đọc tin của bạn chỉ với một tài khoản VN News.'),
    'tagline' => __(' VN News'),
    'image' => asset('kcnew/frontend/img/bg_website.PNG'),
])

<div class="auth-shell">
    <div class="auth-illustration" style="--auth-illustration: url('{{ $image }}');">
        <div class="auth-illustration__content">
            <span class="auth-tag">{{ $tagline }}</span>
            <h2 class="auth-headline">{{ $headline }}</h2>
            <p class="auth-subheadline">{{ $subheadline }}</p>

            @isset($features)
                {{ $features }}
            @else
                <ul class="auth-feature-list">
                    <li>{{ __('Theo dõi chuyên mục yêu thích với bảng tin cá nhân hóa.') }}</li>
                    <li>{{ __('Nhận cảnh báo tin nóng ngay khi bài viết được xuất bản.') }}</li>
                    <li>{{ __('Tham gia bình luận và lưu trữ bài viết quan trọng để xem lại bất kỳ lúc nào.') }}</li>
                </ul>
            @endisset
        </div>
    </div>

    <div class="auth-panel">
        @isset($logo)
            <div class="auth-brand">
                {{ $logo }}
            </div>
        @endisset

        <div class="auth-panel__body">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="auth-footer">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
