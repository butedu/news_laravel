<?php 
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
$now = Carbon::now('Asia/Ho_Chi_Minh')->locale('vi');
$categoryFooter  = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('created_at','DESC')->take(12)->get();
$categories = Category::where('name','!=','Chưa phân loại')->orderBy('created_at','DESC')->take(10)->get();

/*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
$category_unclassified = Category::where('name','Chưa phân loại')->first();
$posts_new[0]= Post::latest()->approved()
             ->where('category_id','!=', $category_unclassified->id )
              ->take(1)->get();
$posts_new[1] = Post::latest()->approved()
            ->where('category_id','!=', $category_unclassified->id )
            ->where('category_id','!=', $posts_new[0][0]->category->id )
            ->take(1)->get();
$posts_new[2] = Post::latest()->approved()
            ->where('category_id','!=', $category_unclassified->id )
            ->where('category_id','!=', $posts_new[0][0]->category->id )
            ->where('category_id','!=', $posts_new[1][0]->category->id )
            ->take(1)->get();
$posts_new[3] = Post::latest()->approved()
            ->where('category_id','!=', $category_unclassified->id )
            ->where('category_id','!=', $posts_new[0][0]->category->id )
            ->where('category_id','!=', $posts_new[1][0]->category->id)
            ->where('category_id','!=', $posts_new[2][0]->category->id )
            ->take(1)->get();



?>
@extends('main_layouts.master')

@section('title','VN News - Thông tin tài khoản')
@section('custom_css')
<style>
    .profile-page{
        background: #f5f7fa;
        padding-bottom: 60px;
    }
    .profile-page .main-content--section.pbottom--30{
        padding-bottom: 0;
        margin-bottom: 36px;
    }
    .profile-section{
        position: relative;
        background: #ffffff;
        border-radius: 28px;
        border: 1px solid rgba(148, 163, 184, 0.14);
        padding: 36px;
        box-shadow: 0 22px 46px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .profile-section::before{
        content: "";
        position: absolute;
        inset: -80px auto auto -80px;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle at center, rgba(148, 163, 184, 0.25), transparent 72%);
        z-index: 0;
    }
    .profile-section::after{
        content: "";
        position: absolute;
        inset: auto -120px -120px auto;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle at center, rgba(100, 116, 139, 0.18), transparent 70%);
        z-index: 0;
    }
    .profile-section--secondary{
        padding: 32px;
        background: rgba(248, 250, 252, 0.96);
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
    }
    .profile-section--secondary::before,
    .profile-section--secondary::after{
        content: none;
    }
    .profile-section__inner{
        position: relative;
        z-index: 1;
    }
    .profile-section__header{
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
    }
    .profile-section__title{
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
    }
    .profile-section__subtitle{
        margin: 6px 0 0;
        font-size: 15px;
        color: #475569;
    }
    .profile-section__meta{
        font-size: 14px;
        color: #475569;
        background: rgba(148, 163, 184, 0.18);
        border-radius: 999px;
        padding: 6px 14px;
        font-weight: 600;
    }
    .profile-section__grid{
        display: grid;
        grid-template-columns: minmax(240px, 320px) minmax(0, 1fr);
        gap: 28px;
    }
    .profile-section__col{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .profile-avatar-card{
        background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        border-radius: 24px;
        padding: 28px;
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.08);
    }
    .profile-avatar-card__preview{
        display: flex;
        justify-content: center;
        margin-bottom: 22px;
    }
    .profile-avatar-card__preview img{
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 6px solid rgba(148, 163, 184, 0.2);
        object-fit: cover;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.18);
    }
    .profile-avatar-card__title{
        margin: 0 0 8px;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
    }
    .profile-avatar-card__desc{
        margin: 0 0 18px;
        font-size: 14px;
        color: #475569;
    }
    .profile-avatar-card__input{
        background: rgba(227, 233, 242, 0.6);
        border: 1px dashed rgba(148, 163, 184, 0.55);
        border-radius: 14px;
        padding: 10px 14px;
        text-align: center;
        transition: background 0.2s ease, transform 0.2s ease;
    }
    .profile-avatar-card__input:hover{
        background: rgba(221, 229, 240, 0.9);
        transform: translateY(-2px);
    }
    .profile-avatar-card__input input[type="file"]{
        background: transparent;
        color: #1e293b;
        border: none;
        padding: 0;
        font-size: 14px;
    }
    .profile-avatar-card__input input[type="file"]::-webkit-file-upload-button{
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(148, 163, 184, 0.45);
        border-radius: 999px;
        color: #1f2937;
        padding: 6px 16px;
        cursor: pointer;
    }
    .profile-avatar-card__input--url{
        text-align: left;
        background: #ffffff;
        border: 1px solid rgba(148, 163, 184, 0.45);
        margin-top: 18px;
    }
    .profile-avatar-card__input--url label{
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #1e293b;
    }
    .profile-avatar-card__input--url input[type="url"]{
        background: #f8fafc;
        border: 1px solid rgba(148, 163, 184, 0.6);
        border-radius: 10px;
        padding: 10px 12px;
        width: 100%;
        font-size: 14px;
        color: #0f172a;
    }
    .profile-avatar-card__input--url input[type="url"]:focus{
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .profile-card{
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(148, 163, 184, 0.22);
        padding: 26px 28px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }
    .profile-card__title{
        margin: 0 0 18px;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }
    .profile-form-field{
        margin-bottom: 18px;
    }
    .profile-form-field label{
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .profile-form-field small{
        display: block;
        margin-top: 8px;
        color: #64748b;
    }
    .profile-action-group{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 12px;
    }
    .profile-action-group .btn{
        padding: 10px 22px;
        border-radius: 999px;
        font-weight: 600;
    }
    .profile-note{
        font-size: 13px;
        color: #64748b;
        margin-top: 6px;
    }
    @media (max-width: 1199px){
        .profile-section{
            padding: 32px;
        }
        .profile-section__grid{
            grid-template-columns: minmax(0, 1fr);
        }
    }
    @media (max-width: 767px){
        .profile-page{
            padding-bottom: 36px;
        }
        .profile-section{
            padding: 24px;
            border-radius: 20px;
        }
        .profile-section__title{
            font-size: 24px;
        }
        .profile-card{
            padding: 22px;
        }
        .profile-avatar-card{
            padding: 22px;
        }
        .profile-avatar-card__preview img{
            width: 150px;
            height: 150px;
        }
    }
    .profile-collection{
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        padding: 24px;
        margin-bottom: 36px;
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.06);
    }
    .profile-collection__header{
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }
    .profile-collection__title{
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
    }
    .profile-collection__count{
        font-size: 14px;
        color: #64748b;
    }
    .profile-collection__grid{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    .profile-post-card{
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #f8fafc, #eef2ff);
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.2);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        height: 100%;
    }
    .profile-post-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.16);
    }
    .profile-post-card__cover{
        position: relative;
        display: block;
        padding-top: 60%;
        overflow: hidden;
    }
    .profile-post-card__cover img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-post-card__category{
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(15, 23, 42, 0.85);
        color: #fff;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        text-transform: capitalize;
    }
    .profile-post-card__body{
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }
    .profile-post-card__title{
        margin: 0;
        font-size: 18px;
        line-height: 1.35;
        color: #0f172a;
        font-weight: 700;
    }
    .profile-post-card__title a{
        color: inherit;
        text-decoration: none;
    }
    .profile-post-card__excerpt{
        margin: 0;
        font-size: 14px;
        color: #475569;
    }
    .profile-post-card__footer{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        font-size: 13px;
        color: #64748b;
        margin-top: auto;
    }
    .profile-post-card__link{
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
    }
    .profile-post-card__link:hover{
        text-decoration: underline;
    }
    .profile-empty-state{
        padding: 40px;
        text-align: center;
        border-radius: 18px;
        border: 1px dashed rgba(148, 163, 184, 0.6);
        color: #475569;
        background: #f8fafc;
        margin-bottom: 36px;
    }
    .profile-empty-state h4{
        margin-bottom: 8px;
        font-weight: 700;
        color: #0f172a;
    }
    .profile-empty-state p{
        margin: 0;
        font-size: 15px;
    }
    .profile-alert{
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 500;
    }
    .profile-alert--success{
        background: rgba(34, 197, 94, 0.1);
        color: #047857;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }
    .profile-alert--error{
        background: rgba(248, 113, 113, 0.1);
        color: #b91c1c;
        border: 1px solid rgba(248, 113, 113, 0.2);
    }
    .newsletter-preference-card{
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        padding: 18px 20px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        margin-bottom: 28px;
    }
    .newsletter-preference-header{
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }
    .newsletter-email-field{
        margin-bottom: 18px;
    }
    .newsletter-email-field label{
        display: block;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .newsletter-email-field input[type="email"]{
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.4);
        background: #f8fafc;
        color: #0f172a;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .newsletter-email-field input[type="email"]:focus{
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .newsletter-preference-title{
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }
    .newsletter-preference-meta{
        font-size: 13px;
        color: #64748b;
    }
    .newsletter-category-grid{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .newsletter-category-option{
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        transition: background 0.2s ease, border-color 0.2s ease;
        flex: 0 1 240px;
    }
    .newsletter-category-option:hover{
        background: #eef2ff;
        border-color: rgba(59, 130, 246, 0.6);
    }
    .newsletter-category-option input[type="checkbox"]{
        margin: 0;
    }
    .newsletter-category-label{
        display: flex;
        flex-direction: column;
        gap: 2px;
        color: #0f172a;
        font-weight: 500;
    }
    .newsletter-category-label span{
        font-size: 12px;
        color: #64748b;
    }
    .newsletter-preference-actions{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    .newsletter-btn{
        padding: 8px 18px;
        border-radius: 999px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .newsletter-btn--primary{
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
    }
    .newsletter-btn--secondary{
        background: #e2e8f0;
        color: #334155;
    }
    .newsletter-btn:hover{
        transform: translateY(-1px);
    }
    @media (max-width: 767px){
        .newsletter-preference-card{
            padding: 18px;
        }
        .newsletter-category-option{
            flex: 1 1 100%;
        }
    }
    @media (max-width: 767px){
        .profile-collection{
            padding: 20px;
        }
        .profile-collection__title{
            font-size: 20px;
        }
    }
</style>
@endsection
@section('content')

@auth
@php
    $profileUser = $user ?? auth()->user();
    $savedPosts = $savedPosts ?? collect();
    $commentedPosts = $commentedPosts ?? collect();
    $newsletterSubscription = $newsletterSubscription ?? null;
    $newsletterCategories = $newsletterCategories ?? collect();
    $subscribedCategoryIds = $newsletterSubscription
        ? $newsletterSubscription->categories->pluck('id')->all()
        : [];
    $lastProfileUpdate = optional($profileUser->updated_at)->diffForHumans();
    $currentExternalAvatar = '';
    $existingAvatarPath = optional($profileUser->image)->path;
    if ($existingAvatarPath && Str::startsWith($existingAvatarPath, ['http://', 'https://'])) {
        $currentExternalAvatar = $existingAvatarPath;
    }
    $selectedNewsletterCategoryIds = old('newsletter_context') === 'profile'
        ? collect(old('categories', []))->map(fn ($id) => (int) $id)->all()
        : $subscribedCategoryIds;
@endphp
<div class="profile-page">
<div class="main--breadcrumb">
    <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}" class="btn-link"><i class="fa fm fa-home"></i>Trang chủ</a></li>
                <li class="active"><span>Tài khoản</span></li>
            </ul>
        </div>
    </div>
 
	<!-- Main Content Section Start -->
	<div class="main-content--section pbottom--30">
		<div class="container">
            <div class="profile-section">
                <div class="profile-section__inner">
                    <div class="profile-section__header">
                        <div>
                            <h3 class="profile-section__title">Thông tin cá nhân</h3>
                            <p class="profile-section__subtitle">Tùy chỉnh hồ sơ và bảo mật tài khoản của bạn.</p>
                        </div>
                        @if($lastProfileUpdate)
                            <span class="profile-section__meta">Cập nhật gần nhất: {{ $lastProfileUpdate }}</span>
                        @endif
                    </div>
            @if(session('success'))
                <div class="profile-alert profile-alert--success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="profile-alert profile-alert--error" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('update') }}" method="post" enctype="multipart/form-data" class="profile-section__inner">
                    @csrf
                    @php
                        $avatarUrl = optional($profileUser->image)->url ?? asset('storage/placeholders/user_placeholder.jpg');
                    @endphp
                    <div class="profile-section__grid">
                        <div class="profile-section__col">
                            <div class="profile-avatar-card">
                                <div class="profile-avatar-card__preview">
                                    <img src="{{ $avatarUrl }}" alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                                </div>
                                <h4 class="profile-avatar-card__title">Ảnh đại diện</h4>
                                <p class="profile-avatar-card__desc">Tăng mức độ tin tưởng khi ảnh đại diện phản ánh đúng con người của bạn.</p>
                                <div class="profile-avatar-card__input">
                                    <label for="input_image" class="form-label">Chọn ảnh mới</label>
                                    <input name="image" type="file" class="form-control" id="input_image">
                                </div>
                                @error('image')
                                    <p class="text-danger profile-note">{{ $message }}</p>
                                @enderror
                                <div class="profile-avatar-card__input profile-avatar-card__input--url">
                                    <label for="input_image_url" class="form-label">Hoặc dán liên kết ảnh</label>
                                    <input name="image_url" type="url" class="form-control" id="input_image_url" value="{{ old('image_url', $currentExternalAvatar) }}" placeholder="https://example.com/avatar.jpg">
                                    <small class="profile-note">Ảnh liên kết sẽ được sử dụng nếu bạn nhập cả hai.</small>
                                </div>
                                @error('image_url')
                                    <p class="text-danger profile-note">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="profile-section__col">
                            <div class="profile-card">
                                <h4 class="profile-card__title">Thông tin cơ bản</h4>
                                <div class="profile-form-field">
                                    <label for="input_name">Họ Tên</label>
                                    <input name="name" type="text" class="form-control" id="input_name" value='{{ old("name", $profileUser->name ) }}'>
                                    @error('name')
                                        <p class="text-danger profile-note">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="profile-form-field">
                                    <label for="input_email">Email</label>
                                    <input name="email" type="email" class="form-control" id="input_email" value='{{ old("email", $profileUser->email) }}'>
                                    @error('email')
                                        <p class="text-danger profile-note">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="profile-card">
                                <h4 class="profile-card__title">Đổi mật khẩu</h4>
                                <div class="profile-form-field">
                                    <label for="input_current_password">Mật khẩu hiện tại</label>
                                    <input name="current_password" type="password" class="form-control" id="input_current_password" autocomplete="current-password">
                                    @error('current_password')
                                        <p class="text-danger profile-note">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="profile-form-field">
                                    <label for="input_password">Mật khẩu mới</label>
                                    <input name="password" type="password" class="form-control" id="input_password" autocomplete="new-password">
                                    @error('password')
                                        <p class="text-danger profile-note">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="profile-form-field">
                                    <label for="input_password_confirmation">Xác nhận mật khẩu mới</label>
                                    <input name="password_confirmation" type="password" class="form-control" id="input_password_confirmation" autocomplete="new-password">
                                </div>
                                <small class="profile-note">Để trống các ô trên nếu bạn không muốn đổi mật khẩu.</small>
                            </div>
                            <div class="profile-action-group">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                                <a class="btn btn-danger" href="{{ route('home') }}">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="profile-section profile-section--secondary">
                <div class="profile-section__inner">
                    <div class="newsletter-preference-card">
                        <div class="newsletter-preference-header">
                            <div>
                                <h3 class="newsletter-preference-title">Danh mục nhận bản tin</h3>
                                <small class="permission-helper">Bật/tắt chuyên mục để nhận email phù hợp.</small>
                            </div>
                            <span class="newsletter-preference-meta">
                                @if(!empty($subscribedCategoryIds))
                                    Đang theo dõi {{ count($subscribedCategoryIds) }} chuyên mục
                                @else
                                    Chưa đăng ký nhận tin
                                @endif
                            </span>
                        </div>

                        @if($newsletterCategories->isEmpty())
                            <p class="permission-helper mb-0">Hiện chưa có chuyên mục nào để đăng ký.</p>
                        @else
                            <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-preference-form">
                                @csrf
                                <input type="hidden" name="newsletter_context" value="profile">
                                <div class="newsletter-email-field">
                                    <label for="newsletter_email">Email nhận tin</label>
                                    <input type="email" name="email" id="newsletter_email" value="{{ old('email', $profileUser->email) }}" placeholder="ban@example.com">
                                    @if(old('newsletter_context') === 'profile')
                                        @error('email')
                                            <p class="text-danger profile-note">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>
                                <div class="newsletter-category-grid">
                                    @foreach($newsletterCategories as $newsletterCategory)
                                        @php
                                            $isChecked = in_array($newsletterCategory->id, $selectedNewsletterCategoryIds, true);
                                        @endphp
                                        <label class="newsletter-category-option">
                                            <input type="checkbox" name="categories[]" value="{{ $newsletterCategory->id }}" {{ $isChecked ? 'checked' : '' }}>
                                            <div class="newsletter-category-label">
                                                <strong>{{ $newsletterCategory->name }}</strong>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="newsletter-preference-actions">
                                    <button type="submit" class="newsletter-btn newsletter-btn--primary">Cập nhật đăng ký</button>
                                    <button type="button" class="newsletter-btn newsletter-btn--secondary" data-role="unsubscribe">Hủy đăng ký</button>
                                </div>
                                <small class="permission-helper">Bỏ chọn toàn bộ hoặc dùng nút “Hủy đăng ký” để dừng nhận mail.</small>
                            </form>
                        @endif
                    </div>
                    @if($savedPosts->isNotEmpty())
                        <div class="profile-collection">
                            <div class="profile-collection__header">
                                <h3 class="profile-collection__title">Bài viết đã lưu</h3>
                                <span class="profile-collection__count">{{ $savedPosts->count() }} bài viết</span>
                            </div>
                            <div class="profile-collection__grid">
                                @foreach($savedPosts as $savedPost)
                                    <article class="profile-post-card">
                                        <a class="profile-post-card__cover" href="{{ route('posts.show', $savedPost) }}">
                                            <img src="{{ optional($savedPost->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}" alt="{{ $savedPost->title }}">
                                            @if(optional($savedPost->category)->name)
                                                <span class="profile-post-card__category">{{ optional($savedPost->category)->name }}</span>
                                            @endif
                                        </a>
                                        <div class="profile-post-card__body">
                                            <h4 class="profile-post-card__title"><a href="{{ route('posts.show', $savedPost) }}">{{ $savedPost->title }}</a></h4>
                                            @if($savedPost->excerpt)
                                                <p class="profile-post-card__excerpt">{{ Str::limit(strip_tags($savedPost->excerpt), 100) }}</p>
                                            @endif
                                            <div class="profile-post-card__footer">
                                                <span>{{ $savedPost->pivot->created_at?->locale('vi')->diffForHumans() }}</span>
                                                <div class="profile-post-card__actions">
                                                    <form class="profile-post-card__unsave-form" action="{{ route('posts.unsave', $savedPost) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="profile-post-card__unsave">Bỏ lưu</button>
                                                    </form>
                                                    <a class="profile-post-card__link" href="{{ route('posts.show', $savedPost) }}">Đọc ngay</a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="profile-empty-state">
                            <h4>Bạn chưa lưu bài viết nào</h4>
                            <p>Nhấn nút lưu dưới mỗi bài viết để thêm vào danh sách yêu thích.</p>
                        </div>
                    @endif

                    @if($commentedPosts->isNotEmpty())
                        <div class="profile-collection">
                            <div class="profile-collection__header">
                                <h3 class="profile-collection__title">Bài viết đã bình luận</h3>
                                <span class="profile-collection__count">{{ $commentedPosts->count() }} bài viết</span>
                            </div>
                            <div class="profile-collection__grid">
                                @foreach($commentedPosts as $commentedPost)
                                    <article class="profile-post-card">
                                        <a class="profile-post-card__cover" href="{{ route('posts.show', $commentedPost) }}">
                                            <img src="{{ optional($commentedPost->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}" alt="{{ $commentedPost->title }}">
                                            @if(optional($commentedPost->category)->name)
                                                <span class="profile-post-card__category">{{ optional($commentedPost->category)->name }}</span>
                                            @endif
                                        </a>
                                        <div class="profile-post-card__body">
                                            <h4 class="profile-post-card__title"><a href="{{ route('posts.show', $commentedPost) }}">{{ $commentedPost->title }}</a></h4>
                                            @if($commentedPost->excerpt)
                                                <p class="profile-post-card__excerpt">{{ Str::limit(strip_tags($commentedPost->excerpt), 100) }}</p>
                                            @endif
                                            <div class="profile-post-card__footer">
                                                <span>{{ optional($commentedPost->latest_user_comment_at)->locale('vi')->diffForHumans() ?? 'Vừa cập nhật' }}</span>
                                                <a class="profile-post-card__link" href="{{ route('posts.show', $commentedPost) }}">Xem bài</a>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="profile-empty-state">
                            <h4>Bạn chưa bình luận bài viết nào</h4>
                            <p>Hãy để lại cảm nghĩ của bạn ở những bài viết yêu thích để xem lại tại đây.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

@guest
    <div class="wrapper">
	<!-- Main Content Section Start -->
	<div class="main-content--section pbottom--30">
		<div class="container">
            <div class="row">
                <div class="cold-md-8 offset-md-2 text-center">
                    <h1 style="font-size: 162px; color: #dc3545; font-weight: bold;">404</h1>
                    <h2>Trang không tồn tại</h2>
                    <p>Chúng tôi xin lỗi, trang bạn yêu cầu có thể được tìm thấy. Vui lòng quay lại trang chủ.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endguest

@endsection
