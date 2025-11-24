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
@endphp
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
            <h3 class="page-header">Thông tin cá nhân</h3>
            <div class="row">
             
                <form action="{{ route('update') }}" method="post"  enctype="multipart/form-data" >
                    @csrf

                    <!-- left column -->
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        @php
                            $avatarUrl = optional($profileUser->image)->url ?? asset('storage/placeholders/user_placeholder.jpg');
                        @endphp
                        <div class="text-center">
                            <img src="{{ $avatarUrl }}" style="border: 4px solid #979993; border-radius: 50%; margin: auto; width: 180px; height: 180px; object-fit: cover; object-position: center;"  alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                            <div class="mb-3">
                            <label for="input_image" class="form-label">Ảnh đai diện</label>
                            <input style="background-color: #ffffff; color: black;"  name="image" type="file" class="form-control text-center center-block well well-sm" id="input_image" >
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="form-body mt-4">
                            <div class="row">
                                    <div class="col-lg-6">
                                        <div class="border border-3 p-4 rounded">

                                            <div style="margin-bottom: 30px;" class="mb-3">
                                                <label for="input_name" class="form-label">Họ Tên</label>
                                                <input name="name" type="text"  class="form-control" id="input_name" value='{{ old("name", $profileUser->name ) }}'>
                                            
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div style="margin-bottom: 30px;" class="mb-3">
                                                <label for="input_email" class="form-label">Email</label>
                                                <input name="email" type="email" class="form-control" id="input_email" value='{{ old("email", $profileUser->email) }}'>
                                            
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button class="btn btn-primary" type="submit">Cập nhật</button>

                                            <a class="btn btn-danger" href="{{ route('home') }}">Quay lại</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    
            </div>
        </div>
    </div>
    <div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
                                                <a class="profile-post-card__link" href="{{ route('posts.show', $savedPost) }}">Đọc ngay</a>
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
