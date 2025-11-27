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

        .post-meta{
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            padding: 16px 0;
        }

        .post-meta__item{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(9, 89, 171, 0.08);
            color: #0f172a;
            font-size: 14px;
            font-weight: 600;
        }

        .post-meta__item i{
            color: #0959ab;
        }

        .post-meta__item time{
            font-weight: 600;
        }

        .post-meta__item small{
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
        }

        .post-meta.post-meta--compact{
            padding: 6px 0 0;
            gap: 12px;
        }

        .post-meta.post-meta--compact .post-meta__item{
            background: transparent;
            padding: 0;
            color: #475569;
            font-weight: 500;
            font-size: 13px;
        }

        .post-meta.post-meta--compact .post-meta__item i{
            color: #64748b;
        }

        @media (max-width: 767px){
            .post-meta{
                flex-direction: column;
                align-items: flex-start;
            }

            .post-meta__item{
                width: 100%;
                justify-content: flex-start;
            }
        }

        .comment-section{
            margin-top: 48px;
        }

        .comment-section__header{
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 24px;
        }

        .comment-section__title{
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }

        .comment-section__subtitle{
            margin: 6px 0 0;
            color: #475569;
            font-size: 15px;
        }

        .comment-section__count{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(9, 89, 171, 0.08);
            color: #0959ab;
            font-weight: 600;
        }

        .comment-list{
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .comment-item{
            list-style: none;
        }

        .comment-card{
            display: flex;
            gap: 18px;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(135deg, #ffffff, rgba(241, 245, 249, 0.6));
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }

        .comment-card__avatar img{
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            border: 3px solid rgba(9, 89, 171, 0.15);
        }

        .comment-card__body{
            flex: 1;
            min-width: 0;
        }

        .comment-card__header{
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 12px;
        }

        .comment-card__author{
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .comment-card__name{
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
        }

        .comment-card__meta{
            font-size: 13px;
            color: #64748b;
        }

        .comment-card__actions{
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .comment-card__action{
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .comment-card__action:hover{
            color: #0959ab;
        }

        .comment-card__action--icon{
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(9, 89, 171, 0.08);
        }

        .comment-card__action--icon:hover{
            background: rgba(9, 89, 171, 0.16);
        }

        .comment-card__delete{
            font-weight: 600;
        }

        .comment-card__content p{
            margin: 0;
            color: #1e293b;
            font-size: 15px;
            line-height: 1.6;
        }

        .comment-empty{
            padding: 32px;
            text-align: center;
            border-radius: 14px;
            border: 1px dashed rgba(148, 163, 184, 0.6);
            background: rgba(248, 250, 252, 0.85);
            color: #475569;
            font-weight: 600;
        }

        .comment-compose{
            margin-top: 48px;
            padding: 28px;
            border-radius: 20px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: linear-gradient(135deg, rgba(9, 89, 171, 0.08), rgba(15, 118, 110, 0.05));
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        .comment-compose__header{
            margin-bottom: 20px;
        }

        .comment-compose__title{
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        .comment-compose__subtitle{
            margin: 6px 0 0;
            color: #475569;
            font-size: 15px;
        }

        .comment-compose__field{
            margin-bottom: 16px;
        }

        .comment-compose__field label{
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .comment-compose__textarea{
            width: 100%;
            min-height: 140px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            padding: 16px;
            font-size: 15px;
            resize: vertical;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background: rgba(255, 255, 255, 0.92);
        }

        .comment-compose__textarea:focus{
            outline: none;
            border-color: #0959ab;
            box-shadow: 0 0 0 3px rgba(9, 89, 171, 0.12);
        }

        .comment-compose__error{
            display: block;
            min-height: 18px;
            font-size: 13px;
            color: #dc2626;
            margin-top: 6px;
        }

        .comment-compose__footer{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .comment-compose__hint{
            font-size: 14px;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .comment-compose__submit{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 700;
            background: linear-gradient(135deg, #2c85df, #0959ab);
            border: none;
            color: #fff;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .comment-compose__submit:hover{
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(9, 89, 171, 0.3);
            color: #fff;
        }

        .comment-compose__auth-prompt{
            padding: 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.4);
            text-align: center;
            font-size: 15px;
        }

        .comment-compose__auth-prompt a{
            font-weight: 700;
            color: #0959ab;
        }

        .comment-compose__auth-prompt a:hover{
            text-decoration: underline;
        }

        @media (max-width: 767px){
            .comment-card{
                flex-direction: column;
                align-items: flex-start;
            }

            .comment-card__header{
                flex-direction: column;
                align-items: flex-start;
            }

            .comment-card__actions{
                width: 100%;
                justify-content: flex-start;
            }

            .comment-compose{
                padding: 20px;
            }

            .comment-compose__footer{
                flex-direction: column;
                align-items: flex-start;
            }

            .comment-compose__submit{
                width: 100%;
            }
        }

		.author-info,
		.post-time{
			margin: 0;
			font-size: 14px !important;
			text-align: right;
		}

	</style>
@endsection

@section('custom_js')
<script>
    document.addEventListener('click', function (event) {
        const target = event.target.closest('a[data-action="copy-link"]');
        if (!target) {
            return;
        }

        event.preventDefault();

        const linkToCopy = target.getAttribute('href');
        if (!linkToCopy) {
            return;
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(linkToCopy)
                .then(function () {
                    window.alert('Đã sao chép liên kết bài viết vào bộ nhớ tạm.');
                })
                .catch(function () {
                    window.prompt('Sao chép thủ công liên kết này:', linkToCopy);
                });
        } else {
            window.prompt('Sao chép thủ công liên kết này:', linkToCopy);
        }
    });
</script>
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
                                <div class="post-meta">
                                    <span class="post-meta__item">
                                        <i class="fa fa-calendar"></i>
                                        <span>
                                            <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->locale('vi')->translatedFormat('l, d/m/Y') }}</time>
                                        </span>
                                    </span>
                                    <span class="post-meta__item">
                                        <i class="fa fa-user-circle"></i>
                                        <span>{{ $post->author->name }}</span>
                                    </span>
                                    <span class="post-meta__item">
                                        <i class="fa fa-eye"></i>
                                        <span>{{ number_format($post->views) }} lượt xem</span>
                                    </span>
                                    <span class="post-meta__item">
                                        <i class="fa fa-comments-o"></i>
                                        <span><span class="post_count_comment">{{ count($post->comments) }}</span> bình luận</span>
                                    </span>
                                </div>

                                <div class="title">
                                    <h2 class="post_title"><strong>{{ $post->title }}</strong></h2>
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
                        @php
                            $absolutePostUrl = route('posts.show', $post);
                            $encodedPostUrl = urlencode($absolutePostUrl);
                            $encodedTitle = urlencode($post->title);
                        @endphp

                        <div class="post--social pbottom--30">
                            <span class="title"><i class="fa fa-share-alt"></i> Chia sẻ </span>
                             
                            <!-- Social Widget Start -->
                            <div class="social--widget style--4">
                                <ul class="nav">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedPostUrl }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên Facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?url={{ $encodedPostUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên Twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $encodedPostUrl }}&title={{ $encodedTitle }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên LinkedIn">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://t.me/share/url?url={{ $encodedPostUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" aria-label="Chia sẻ lên Telegram">
                                            <i class="fa fa-send"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mailto:?subject={{ $encodedTitle }}&body={{ $encodedPostUrl }}" aria-label="Gửi qua email">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $absolutePostUrl }}" data-action="copy-link" aria-label="Sao chép liên kết" title="Sao chép liên kết">
                                            <i class="fa fa-link"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Social Widget End -->
                        </div>
                        <!-- Post Social End -->

                    
                        <section class="comment-section">
                            <div class="comment-section__header">
                                <div>
                                    <h2 class="comment-section__title">Bình luận</h2>
                                    <p class="comment-section__subtitle">Chia sẻ suy nghĩ của bạn về bài viết này.</p>
                                </div>
                                <span class="comment-section__count"><span class="post_count_comment">{{ count($post->comments) }}</span> ý kiến</span>
                            </div>

                            @if($post->comments->isEmpty())
                                <div class="comment-empty">Hiện chưa có bình luận nào. Hãy là người đầu tiên chia sẻ cảm nhận của bạn!</div>
                            @else
                                <ul class="comment-list">
                                @foreach($post->comments as $comment)
                                    <li class="comment-item" id="comment_{{ $comment->id }}">
                                        <div class="comment-card">
                                            <div class="comment-card__avatar">
                                                @php
                                                    $commentAvatar = optional($comment->user->image)->url ?? asset('storage/placeholders/user_placeholder.jpg');
                                                @endphp
                                                <img src="{{ $commentAvatar }}" alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                                            </div>
                                            <div class="comment-card__body">
                                                <div class="comment-card__header">
                                                    <div class="comment-card__author">
                                                        <span class="comment-card__name">{{ $comment->user->name }}</span>
                                                        <span class="comment-card__meta">{{ $comment->created_at->locale('vi')->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="comment-card__actions">
                                                        <a href="javascript:;" class="comment-card__action comment-card__action--icon" aria-label="Báo cáo bình luận">
                                                            <i class="fa fa-flag"></i>
                                                        </a>
                                                        @if(auth()->check() && auth()->id() === $comment->user_id)
                                                            <form method="POST" action="{{ route('posts.deleteCommentUser', $comment) }}" class="delete-comment-form" data-comment-id="{{ $comment->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="comment-card__action comment-card__delete delete-comment-btn">Xóa</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="comment-card__content">
                                                    <p>{{ $comment->the_comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            @endif
                        </section>

                        <section class="comment-compose">
                            <div class="comment-compose__header">
                                <h3 class="comment-compose__title">Viết bình luận của bạn</h3>
                                <p class="comment-compose__subtitle">Chúng tôi rất mong nhận được ý kiến đóng góp để bài viết ngày càng tốt hơn.</p>
                            </div>

                            @auth
                                <form method="POST" action="{{ route('posts.add_comment', $post) }}" autocomplete="off" class="js-comment-form" data-post-slug="{{ $post->slug }}" data-post-id="{{ $post->id }}">
                                    @csrf

                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="post_slug" value="{{ $post->slug }}">

                                    <div class="comment-compose__field">
                                        <label for="comment-message">Nội dung bình luận</label>
                                        <textarea name="the_comment" id="comment-message" class="comment-compose__textarea" placeholder="Chia sẻ cảm nhận, câu hỏi hoặc góp ý của bạn..."></textarea>
                                        <small class="comment-compose__error comment_error"></small>
                                    </div>

                                    <div class="comment-compose__footer">
                                        <span class="comment-compose__hint"><i class="fa fa-lightbulb-o"></i> Nội dung nên lịch sự, tôn trọng và không quá 300 ký tự.</span>
                                        <button type="submit" class="comment-compose__submit send-comment-btn">Gửi bình luận</button>
                                    </div>
                                </form>
                            @endauth

                            @guest
                                <div class="comment-compose__auth-prompt">
                                    <strong>Bạn cần đăng nhập để bình luận.</strong>
                                    <div>
                                        <a href="{{ route('login') }}">Đăng nhập</a> hoặc <a href="{{ route('register') }}">Đăng ký tài khoản</a> để tham gia thảo luận.
                                    </div>
                                </div>
                            @endguest
                        </section>

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

                                                        <div class="post-meta post-meta--compact">
                                                            <span class="post-meta__item">
                                                                <i class="fa fa-user-circle"></i>
                                                                <span>{{ $relatedPost->author->name }}</span>
                                                            </span>
                                                            <span class="post-meta__item">
                                                                <i class="fa fa-clock-o"></i>
                                                                <span>{{ $relatedPost->created_at->locale('vi')->diffForHumans() }}</span>
                                                            </span>
                                                            <span class="post-meta__item">
                                                                <i class="fa fa-comments-o"></i>
                                                                <span>{{ count($relatedPost->comments) }}</span>
                                                            </span>
                                                        </div>
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

