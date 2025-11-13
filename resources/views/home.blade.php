@extends('main_layouts.master')

@section('title','VN News - Trang Tin Tức Việt Nam')

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
@endsection

@section('content')
<div class="wrapper">
    <!-- Hero Section - Tin Nổi Bật -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <!-- Tin chính lớn -->
                <div class="col-lg-8 col-md-7">
                    @if(isset($hero_posts[0]))
                    <div class="hero-main">
                        <a href="{{ route('posts.show', $hero_posts[0]) }}">
                            <img src="{{ asset($hero_posts[0]->image ? 'storage/' . $hero_posts[0]->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $hero_posts[0]->title }}">
                            <div class="overlay">
                                @if($hero_posts[0]->category)
                                <span class="category-badge">{{ $hero_posts[0]->category->name }}</span>
                                @endif
                                <h2>{{ $hero_posts[0]->title }}</h2>
                                <p class="excerpt-text">{{ Str::limit($hero_posts[0]->excerpt, 150) }}</p>
                                <div class="meta">
                                    <span><i class="fa fa-clock-o"></i> {{ $hero_posts[0]->created_at->locale('vi')->diffForHumans() }}</span>
                                    <span class="mx-2">|</span>
                                    <span><i class="fa fa-eye"></i> {{ number_format($hero_posts[0]->views) }} lượt xem</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- 4 tin phụ -->
                <div class="col-lg-4 col-md-5">
                    <div class="hero-sub-wrapper">
                        @for($i = 1; $i <= 4; $i++)
                            @if(isset($hero_posts[$i]))
                            <div class="hero-sub-item">
                                <a href="{{ route('posts.show', $hero_posts[$i]) }}">
                                    <img src="{{ asset($hero_posts[$i]->image ? 'storage/' . $hero_posts[$i]->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $hero_posts[$i]->title }}">
                                    <div class="overlay">
                                        @if($hero_posts[$i]->category)
                                        <span class="category-badge-sm">{{ $hero_posts[$i]->category->name }}</span>
                                        @endif
                                        <h3>{{ Str::limit($hero_posts[$i]->title, 70) }}</h3>
                                        <div class="meta-sm">
                                            <span><i class="fa fa-clock-o"></i> {{ $hero_posts[$i]->created_at->locale('vi')->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content--section">
        <div class="container">
            <div class="row">
                <!-- Content chính -->
                <div class="col-lg-8 col-md-12">
                    @foreach($category_home as $index => $category)
                        @php
                            $varName = 'post_category_home' . $index;
                            $categoryPosts = $$varName ?? [];
                        @endphp
                        
                        @if(count($categoryPosts) > 0)
                        <!-- Category Section -->
                        <section class="category-section animate-fade-in">
                            <div class="category-header">
                                <h2><i class="fa fa-newspaper-o"></i> {{ $category->name }}</h2>
                                <a href="{{ route('categories.show', $category) }}" class="view-all-link">
                                    Xem tất cả <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>
                            
                            @if($index === 0 && count($categoryPosts) >= 5)
                                <!-- First Category: Feature Layout (1 large + 4 small) -->
                                <div class="category-feature-layout">
                                    @if(isset($categoryPosts[0]))
                                    <article class="feature-main-post">
                                        <a href="{{ route('posts.show', $categoryPosts[0]) }}" class="thumb">
                                            <img src="{{ asset($categoryPosts[0]->image ? 'storage/' . $categoryPosts[0]->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $categoryPosts[0]->title }}">
                                        </a>
                                        <div class="post-content">
                                            <h3>
                                                <a href="{{ route('posts.show', $categoryPosts[0]) }}">{{ $categoryPosts[0]->title }}</a>
                                            </h3>
                                            <p class="excerpt">{{ Str::limit($categoryPosts[0]->excerpt, 180) }}</p>
                                            <div class="meta">
                                                @if($categoryPosts[0]->user)
                                                <span><i class="fa fa-user"></i> {{ $categoryPosts[0]->user->name }}</span>
                                                @endif
                                                <span><i class="fa fa-clock-o"></i> {{ $categoryPosts[0]->created_at->locale('vi')->diffForHumans() }}</span>
                                                <span><i class="fa fa-eye"></i> {{ number_format($categoryPosts[0]->views) }}</span>
                                                <span><i class="fa fa-comments"></i> {{ $categoryPosts[0]->comments_count ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </article>
                                    @endif
                                    
                                    <div class="feature-side-posts">
                                        @foreach($categoryPosts->slice(1, 4) as $post)
                                        <article class="feature-side-item">
                                            <a href="{{ route('posts.show', $post) }}" class="thumb-sm">
                                                <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
                                            </a>
                                            <div class="post-content-sm">
                                                <h4>
                                                    <a href="{{ route('posts.show', $post) }}">{{ Str::limit($post->title, 80) }}</a>
                                                </h4>
                                                <div class="meta-sm">
                                                    <span><i class="fa fa-clock-o"></i> {{ $post->created_at->locale('vi')->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </article>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($index % 2 === 1)
                                <!-- Odd Categories: Grid Layout (3 columns) -->
                                <div class="post-grid post-grid-3">
                                    @foreach($categoryPosts->take(6) as $post)
                                    <article class="post-item-grid">
                                        <a href="{{ route('posts.show', $post) }}" class="thumb">
                                            <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
                                        </a>
                                        <div class="post-content">
                                            <h3>
                                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                            </h3>
                                            <p class="excerpt">{{ Str::limit($post->excerpt, 100) }}</p>
                                            <div class="meta">
                                                <span><i class="fa fa-clock-o"></i> {{ $post->created_at->locale('vi')->diffForHumans() }}</span>
                                                <span><i class="fa fa-eye"></i> {{ number_format($post->views) }}</span>
                                            </div>
                                        </div>
                                    </article>
                                    @endforeach
                                </div>
                            @else
                                <!-- Even Categories: List Layout -->
                                <div class="post-list-layout">
                                    @foreach($categoryPosts->take(4) as $post)
                                    <article class="post-item-list">
                                        <a href="{{ route('posts.show', $post) }}" class="thumb">
                                            <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
                                        </a>
                                        <div class="post-content">
                                            <h3>
                                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                            </h3>
                                            <p class="excerpt">{{ Str::limit($post->excerpt, 150) }}</p>
                                            <div class="meta">
                                                @if($post->user)
                                                <span><i class="fa fa-user"></i> {{ $post->user->name }}</span>
                                                @endif
                                                <span><i class="fa fa-clock-o"></i> {{ $post->created_at->locale('vi')->diffForHumans() }}</span>
                                                <span><i class="fa fa-eye"></i> {{ number_format($post->views) }}</span>
                                            </div>
                                        </div>
                                    </article>
                                    @endforeach
                                </div>
                            @endif
                        </section>
                        @endif
                    @endforeach
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <aside class="sidebar-sticky">
                        <!-- Xem nhiều nhất -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title"><i class="fa fa-fire"></i> Xem nhiều nhất</h3>
                            <div class="widget-content">
                                @foreach($most_viewed as $index => $post)
                                <div class="sidebar-post-item">
                                    <div class="rank-number">{{ $index + 1 }}</div>
                                    <a href="{{ route('posts.show', $post) }}" class="thumb-sm">
                                        <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
                                    </a>
                                    <div class="post-info">
                                        <h4>
                                            <a href="{{ route('posts.show', $post) }}">{{ Str::limit($post->title, 55) }}</a>
                                        </h4>
                                        <div class="meta-sm">
                                            <span><i class="fa fa-eye"></i> {{ number_format($post->views) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tin nổi bật -->
                        <x-blog.side-outstanding_posts :outstanding_posts="$outstanding_posts"/>

                        <!-- Tin mới nhất -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> Tin mới nhất</h3>
                            <div class="widget-content">
                                @if(isset($latest_posts))
                                    @foreach($latest_posts as $post)
                                    <div class="sidebar-post-item-simple">
                                        <a href="{{ route('posts.show', $post) }}" class="thumb-xs">
                                            <img src="{{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/placeholder-image.png')}}" alt="{{ $post->title }}">
                                        </a>
                                        <div class="post-info">
                                            <h4>
                                                <a href="{{ route('posts.show', $post) }}">{{ Str::limit($post->title, 55) }}</a>
                                            </h4>
                                            <div class="meta-xs">
                                                <span><i class="fa fa-clock-o"></i> {{ $post->created_at->locale('vi')->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Quảng cáo 1 -->
                        <x-blog.side-ad_banner />

                        <!-- Chuyên mục -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title"><i class="fa fa-list-ul"></i> Chuyên mục</h3>
                            <div class="widget-content">
                                @if(isset($categories))
                                <ul class="category-list">
                                    @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('categories.show', $category) }}">
                                            <span class="category-icon"><i class="fa fa-angle-right"></i></span>
                                            <span class="category-name">{{ $category->name }}</span>
                                            <span class="category-count">{{ $category->posts_count }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>

                        <!-- Bình luận nhiều nhất -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title"><i class="fa fa-comments"></i> Bình luận nhiều</h3>
                            <div class="widget-content">
                                @if(isset($most_commented))
                                    @foreach($most_commented as $post)
                                    <div class="sidebar-post-item-minimal">
                                        <h4>
                                            <a href="{{ route('posts.show', $post) }}">
                                                <i class="fa fa-angle-right"></i> {{ Str::limit($post->title, 65) }}
                                            </a>
                                        </h4>
                                        <div class="meta-xs">
                                            <span><i class="fa fa-comments"></i> {{ $post->comments_count }} bình luận</span>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Video nổi bật -->
                        <x-blog.side-video />

                        <!-- Thẻ tag phổ biến -->
                        <div class="sidebar-widget">
                            <h3 class="widget-title"><i class="fa fa-tags"></i> Thẻ phổ biến</h3>
                            <div class="widget-content">
                                @if(isset($popular_tags))
                                <div class="tag-cloud">
                                    @foreach($popular_tags as $tag)
                                    <a href="{{ route('tags.show', $tag) }}" class="tag-item">
                                        {{ $tag->name }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Newsletter đăng ký -->
                        <div class="sidebar-widget sidebar-newsletter">
                            <h3 class="widget-title"><i class="fa fa-envelope"></i> Nhận tin mới</h3>
                            <div class="widget-content">
                                <p>Đăng ký để nhận tin tức mới nhất qua email</p>
                                <form action="#" method="POST" class="newsletter-form" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã đăng ký! Tính năng này sẽ sớm được kích hoạt.');">
                                    @csrf
                                    <input type="email" name="email" placeholder="Email của bạn" required>
                                    <button type="submit"><i class="fa fa-paper-plane"></i> Đăng ký</button>
                                </form>
                            </div>
                        </div>

                        <!-- Quảng cáo 2 -->
                        <div class="sidebar-widget">
                            <div class="ad-banner">
                                <a href="https://mwc.com.vn/" target="_blank">
                                    <img src="{{ asset('kcnew/frontend/img/ads-img/banner_quangcao.png') }}" alt="Quảng cáo">
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

