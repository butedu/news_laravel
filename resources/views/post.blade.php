@extends('main_layouts.master')

@section('title', $post->title. ' - VN News ')

@section('custom_css')
	<style>
		.post--body.post--content{
			color: black;
			font-family: "Source Sans Pro", sans-serif;
			font-size: 18px;
		}

        .post-save-panel{
            margin-top: 32px;
            padding: 24px;
            border-radius: 20px;
            background: linear-gradient(135deg, #f1f5f9, #e0f2fe);
            border: 1px solid rgba(15, 23, 42, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .post-save-panel__info{
            max-width: 520px;
        }

        .post-save-panel__title{
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .post-save-panel__desc{
            margin: 0;
            font-size: 15px;
            color: #475569;
        }

        .post-save-panel__actions{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .post-save-panel__actions form{
            margin: 0;
        }

        .post-save-btn{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            background: #0f172a;
            color: #fff;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .post-save-btn:hover{
            background: linear-gradient(135deg, #0959AB, #2C85DF);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 12px 24px rgba(9, 89, 171, 0.2);
        }

        .post-save-btn.is-active{
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border-color: transparent;
        }

        .post-save-count{
            font-size: 14px;
            color: #475569;
        }

        @media (max-width: 767px){
            .post-save-panel{
                flex-direction: column;
                align-items: flex-start;
            }

            .post-save-panel__actions{
                width: 100%;
                align-items: stretch;
            }

            .post-save-btn{
                justify-content: center;
                width: 100%;
            }
        }

        .post--item.post--title-largest .post--info .title .h4,
        .post--single .post--info .title .h4{
            font-size: 36px;
        }

        .post--info .meta{
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 15px;
            color: #475569;
            margin-bottom: 12px;
        }

        .post--info .meta li{
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .post--info .meta li a,
        .post--info .meta li span{
            color: inherit !important;
            font-weight: 600;
        }

        @media (max-width: 767px){
            .post--item.post--title-largest .post--info .title .h4,
            .post--single .post--info .title .h4{
                font-size: 30px;
            }

            .post--info .meta{
                gap: 12px;
                font-size: 14px;
            }
        }

        .text.capitalize{
            text-transform: capitalize !important;
            color: #ffffff !important;
        }

        .post--tags .nav li a.text.capitalize,
        .post--cats .nav li a.text.capitalize{
            border: 1px solid rgba(15, 23, 42, 0.15) !important;
            color: #0f172a !important;
            background: rgba(240, 246, 255, 0.92) !important;
            padding: 6px 14px !important;
            border-radius: 999px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease-in-out;
        }

        .post--tags .nav li a.text.capitalize:hover,
        .post--cats .nav li a.text.capitalize:hover{
            background: linear-gradient(135deg, #0959AB, #2C85DF) !important;
            color: #ffffff !important;
            box-shadow: 0 12px 24px rgba(9, 89, 171, 0.25);
        }

		.author-info,
		.post-time{
			margin: 0;
			font-size: 14px !important;
			text-align: right;
		}

	</style>
@endsection

@section('content')

@php
    $flashStatuses = ['success','info','warning','error'];
@endphp
@foreach($flashStatuses as $flashStatus)
    <x-blog.message :status="$flashStatus" />
@endforeach

<div class="global-message info d-none"></div>

<!-- Main Breadcrumb Start -->
<div class="main--breadcrumb">
	<div class="container">
			<ul class="breadcrumb">
				<li><a href="{{ route('home') }}" class="btn-link"><i class="fa fm fa-home"></i>Trang Chủ</a></li>
				<li><a href="{{ route('categories.show', $post->category ) }}" class="btn-link">{{ $post->category->name }}</a></li>
				<li class="active"><span>{{ $post->title }}</span></li>
			</ul>
	</div>
</div>
	<!-- Main Breadcrumb End -->

<!-- Main Content Section Start -->
<div class="main-content--section pbottom--30">
        <div class="container">
            <div class="row">
                <!-- Main Content Start -->
                <div class="main--content col-md-8" data-sticky-content="true">
                    <div class="sticky-content-inner">
                        <!-- Post Item Start -->
                        <div class="post--item post--single post--title-largest pd--30-0">
                            <div class="post--cats">
                                <ul class="nav">
                                    <li><span><i class="fa fa-folder-open-o"></i></span></li>
									@for($i = 0; $i <  count($post->tags) ; $i++)
                                    <li><a class="text capitalize" href="{{ route('tags.show',  $post->tags[$i]) }}">{{ $post->tags[$i]->name }}</a></li>
									@endfor
                                </ul>
                            </div>

                            <div class="post--info">
                                <ul class="nav meta">
									<li class="text capitalize"><a href="#">{{ $post->created_at->locale('vi')->translatedFormat('l') }} {{  $post->created_at->locale('vi')->format('d/m/Y') }}</a></li>
                                    <li><a href="#">{{ $post->author->name }}</a></li>
                                    <li><span><i class="fa fm fa-eye"></i>{{ $post->views }}</span></li>
                                    <li><a href="#"><i class="fa fm fa-comments-o"></i>{{ count($post->comments) }}</a></li>
                                </ul>

                                <div class="title">
                                    <h2 class="post_title h4">{{ $post->title }}</h2>
                                </div>
                            </div>

                            <div class="post--body post--content">
								{!! $post->body !!}
                            </div>
                            <div class="post-save-panel">
                                <div class="post-save-panel__info">
                                    <p class="post-save-panel__title">Lưu bài viết để đọc lại sau</p>
                                    <p class="post-save-panel__desc">Theo dõi những bài viết bạn quan tâm và truy cập nhanh trong hồ sơ cá nhân của bạn.</p>
                                </div>
                                <div class="post-save-panel__actions">
                                    @auth
                                        @if($isSaved)
                                            <form action="{{ route('posts.unsave', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="post-save-btn is-active">Bỏ lưu bài viết</button>
                                            </form>
                                        @else
                                            <form action="{{ route('posts.save', $post) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="post-save-btn">Lưu bài viết</button>
                                            </form>
                                        @endif
                                    @else
                                        <a class="post-save-btn" href="{{ route('login') }}">Đăng nhập để lưu</a>
                                    @endauth
                                    <span class="post-save-count">{{ $post->saved_by_count ?? 0 }} lượt lưu</span>
                                </div>
                            </div>
                        </div>
                        <!-- Post Item End -->

                        <!-- Advertisement Start -->
                        <div class="ad--space pd--20-0-40">
							<p class="author-info">Người viết: {{ $post->author->name }}</p>
							<p class="post-time">Thời gian: {{ $post->created_at->locale('vi')->diffForHumans() }}</p>
                        </div>
                        <!-- Advertisement End -->

                        <!-- Post Tags Start -->
                        <div class="post--tags">
                            <ul class="nav">
                                <li><span><i class="fa fa-tags"></i> Từ khóa </span></li>
								@for($i = 0; $i <  count($post->tags) ; $i++)
                                    <li><a class="text capitalize" href="{{ route('tags.show',  $post->tags[$i]) }}">{{ $post->tags[$i]->name }}</a></li>
								@endfor
                            </ul>
                        </div>
                        <!-- Post Tags End -->

                        <!-- Post Social Start -->
                        <div class="post--social pbottom--30">
                            <span class="title"><i class="fa fa-share-alt"></i> Chia sẻ </span>
                             
                            <!-- Social Widget Start -->
                            <div class="social--widget style--4">
                                <ul class="nav">
                                    <li><a href="javascript:"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="javascript:"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="javascript:"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="javascript:"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="javascript:"><i class="fa fa-rss"></i></a></li>
                                    <li><a href="javascript:"><i class="fa fa-youtube-play"></i></a></li>
                                </ul>
                            </div>
                            <!-- Social Widget End -->
                        </div>
                        <!-- Post Social End -->

                    
                        <!-- Comment List Start -->
                        <div class="comment--list pd--30-0">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title">
                                <h2 class="h4"><span class="post_count_comment h4" >{{ count($post->comments) }} </span> bình luận</h2>
                                <i class="icon fa fa-comments-o"></i>
                            </div>
                            <!-- Post Items Title End -->

                            <ul class="comment--items nav">
							@foreach($post->comments as $comment)
                                <li>
                                    <!-- Comment Item Start -->
                                   <div class="comment--item clearfix">
                                        <div class="comment--img float--left">
                                            @php
                                                $commentAvatar = optional($comment->user->image)->url ?? asset('storage/placeholders/user_placeholder.jpg');
                                            @endphp
                                            <img src="{{ $commentAvatar }}" style="border-radius: 50%; margin: auto; width: 68px; height: 68px; object-fit: cover; object-position: center;"  alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                                        </div>
										<div class="comment--info">
											<div class="comment--header clearfix">
												<p class="name">{{ $comment->user->name }}</p>
												<p class="date">{{ $comment->created_at->locale('vi')->diffForHumans() }}</p>
												<a href="javascript:;" class="reply"><i class="fa fa-flag"></i></a>
											</div>
											<div class="comment--content">
												<p>{{ $comment->the_comment }}</p>
												<p class="star">
													<span class="text-left"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
												</p>
											</div>
										</div>
                                    </div>
                                    <!-- Comment Item End -->
                                </li>
								@endforeach
                            </ul>
                        </div>
                        <!-- Comment List End -->

                        <!-- Comment Form Start -->
                        <div class="comment--form pd--30-0">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title">
								<h2 class="h4">Viết bình luận</h2>
                                <i class="icon fa fa-pencil-square-o"></i>
                            </div>
                            <!-- Post Items Title End -->
							
                            <div class="comment-respond">
								@auth	
								<!-- <form method="POST" action="{{ route('posts.add_comment', $post )}}"> -->
                                <form onsubmit="return false;" autocomplete="off" method="POST" >
									@csrf

									<div class="row form-group">
										<div class="col-md-12">
											<textarea name="the_comment" id="message" cols="30" rows="5" class="form-control" placeholder="Đánh giá bài viết này"></textarea>
										</div>
									</div>
                                    <small style="color: red; font-size: 14px;" class="comment_error"> </small>
									<div class="form-group">
										<input id="input_comment" type="submit" value="Bình luận" class="send-comment-btn btn btn-primary">
									</div>
                                </form>
								@endauth

								@guest
								<p class="h4">
									<a href="{{ route('login') }}">Đăng nhập</a> hoặc 
									<a href="{{ route('register') }}">Đăng ký</a> để bình luận bài viết
								</p>
								@endguest
                            </div>

                        </div>
                        <!-- Comment Form End -->

						    <!-- Post Related Start -->
						<div class="post--related ptop--30">
                            <!-- Post Items Title Start -->
                            <div class="post--items-title" data-ajax="tab">
                                <h2 class="h4">Có thể bạn cũng thích</h2>
                            </div>
                            <!-- Post Items Title End -->
                           
							<!-- Post Items Start -->
                            <div class="post--items post--items-2" data-ajax-content="outer">
                                <ul class="nav row" data-ajax-content="inner">
                                    @foreach($postTheSame as $relatedPost)
                                        <li class="col-sm-12 pbottom--30">
											<!-- Post Item Start -->
											<div class="post--item post--layout-3">
												<div class="post--img">
                                        <a href="{{ route('posts.show', $relatedPost) }}"
														class="thumb">
                                                        <img src="{{ optional($relatedPost->image)->url ?? asset('images/placeholder.png') }}"
                                                            alt="">
                                                    </a>

													<div class="post--info">
													
														<div class="title">
															<h3  class="h4">
                                                <a href="{{ route('posts.show', $relatedPost) }}" class="btn-link">{{ $relatedPost->title }}</a>
															</h3>
                                                            <p style="font-size:16px" >
                                                <span >{{ $relatedPost->excerpt }}</span>
                                                            </p>
														</div>

                                                        <ul style="padding-top:10px" class="nav meta ">
                                            <li><a href="javascript:;">{{ $relatedPost->author->name }}</a>
															</li>
                                            <li><a href="javascript:;">{{ $relatedPost->created_at->locale('vi')->diffForHumans() }}</a></li>
                                                            <li><a  href="javascript:;"><i class="fa fm fa-comments"></i>{{ count($relatedPost->comments) }}</a></li>
														</ul>
													</div>
												</div>
											</div>
											<!-- Post Item End -->
										</li>
                                        @endforeach

                                </ul>

                                <!-- Preloader Start -->
                                <div class="preloader bg--color-0--b" data-preloader="1">
                                    <div class="preloader--inner"></div>
                                </div>
                                <!-- Preloader End -->
                            </div>
                            <!-- Post Items End -->
                        </div>
                        <!-- Post Related End -->

                    </div>
                </div>
                <!-- Main Content End -->

                <!-- Main Sidebar Start -->
                <div class="main--sidebar col-md-4 ptop--30 pbottom--30" data-sticky-content="true">
                    <div class="sticky-content-inner">
                       
                        <!-- Widget Start -->
                        <x-blog.side-outstanding_posts :outstanding_posts="$outstanding_posts"/>
                        <!-- Widget End -->

                        <!-- Widget Start -->
                        <x-blog.side-vote />
	                    <!-- Widget End -->

                      <!-- Widget Start -->
                      <x-blog.side-ad_banner />
                      <!-- Widget End -->

                    </div>
                </div>
                <!-- Main Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Main Content Section End -->

@endsection

