<?php 
use App\Models\Post;
use App\Models\Category;

    // Bài viết nổi bật
    $category_hot = Category::where('name','!=','Chưa phân loại')->first();
    $outstanding_posts_hots = Post::approved()
            ->where('category_id',  $category_hot->id )
            ->orderBy('created_at','DESC')
            ->take(5)->get();
    $outstanding_posts_views =  Post::approved()->orderBy('views','DESC')->take(5)->get();
    
 ?>

@props(['outstanding_posts'] )
<div class="sidebar-widget sidebar-widget-featured">
    <h3 class="widget-title"><i class="fa fa-newspaper-o"></i> Tin tức nổi bật</h3>
    <div class="widget-content">
        <style>
            .featured-tabs-wrapper {
                background: var(--widget-tab-bg, #fff);
                border: 1px solid rgba(15, 23, 42, 0.08);
                border-radius: 16px;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
                padding: 6px;
                margin-bottom: 20px;
            }

            .featured-tabs {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 6px;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .featured-tabs button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 9px 12px;
                border-radius: 12px;
                border: none;
                background: transparent;
                font-size: 14px;
                font-weight: 600;
                color: #1e293b;
                white-space: nowrap;
                cursor: pointer;
                transition: background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
            }

            .featured-tabs button:hover {
                background: rgba(44, 133, 223, 0.15);
                color: #0959ab;
            }

            .featured-tabs button.active {
                background: #fff;
                color: #0959ab;
                box-shadow: 0 10px 24px rgba(44, 133, 223, 0.18);
                transform: translateY(-1px);
            }

            @media (max-width: 600px) {
                .featured-tabs {
                    grid-template-columns: 1fr;
                }

                .featured-tabs button {
                    padding: 11px 14px;
                    font-size: 13px;
                }
            }
        </style>
        <div class="featured-tabs-wrapper">
            <ul class="featured-tabs" data-ajax="tab">
                <li>
                    <button type="button" class="outstandPosts" data-ajax-action="load_widget_hot_news">Tin nóng</button>
                </li>
                <li>
                    <button type="button" class="outstandPosts active" data-ajax-action="load_widget_trendy_news">Xu hướng</button>
                </li>
                <li>
                    <button type="button" class="outstandPosts" data-ajax-action="load_widget_most_watched">Xem nhiều</button>
                </li>
            </ul>
        </div>

        <div class="widget-posts" data-ajax-content="outer">
            <ul class="list-unstyled widget-post-list listPost" data-ajax-content="inner">
            @foreach($outstanding_posts as $outstanding_post)
                <li>
                    <div class="sidebar-post-item-simple featured">
                        <a href="{{ route('posts.show', $outstanding_post) }}" class="thumb-sm">
                            <img src="{{ optional($outstanding_post->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}" alt="">
                        </a>
                        <div class="post-info">
                            <h4><a href="{{ route('posts.show', $outstanding_post) }}">{{ $outstanding_post->title}}</a></h4>
                            <div class="meta-sm">
                                <span><i class="fa fa-clock-o"></i> {{ $outstanding_post->created_at->locale('vi')->diffForHumans() }}</span>
                                <span><i class="fa fa-comments"></i> {{ count($outstanding_post->comments) }}</span>
                                <span><i class="fa fa-eye"></i> {{ $outstanding_post->views }}</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>

@section('custom_js')
@parent

<script>
	setTimeout(() => {
		$(".global-message").fadeOut();
	}, 5000)
</script>

<script>
        const outstandPosts = document.querySelectorAll('.outstandPosts');
        outstandPosts.forEach((item, index)=>{
            $(item).on('click', function(e){
                e.preventDefault();

                outstandPosts.forEach(btn => btn.classList.remove('active'));
                item.classList.add('active');

                const ListPost=  $('.listPost');
                const ListPost_item = $('.listPost li');
                ListPost_item.remove();
                if(index==0){
                    const htmls  = (() =>{
                    return `
                        @foreach($outstanding_posts_hots as $outstanding_posts_hot)
                            <li>
                                <div class="sidebar-post-item-simple featured">
                                        <a href="{{ route('posts.show', $outstanding_posts_hot) }}" class="thumb-sm"><img
                                            src="{{ optional($outstanding_posts_hot->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}"
                                            alt=""></a>
                                    <div class="post-info">
                                        <h4><a href="{{ route('posts.show', $outstanding_posts_hot) }}">{{ $outstanding_posts_hot->title}}</a></h4>
                                        <div class="meta-sm">
                                            <span><i class="fa fa-clock-o"></i> {{ $outstanding_posts_hot->created_at->locale('vi')->diffForHumans() }}</span>
                                            <span><i class="fa fa-comments"></i> {{ count($outstanding_posts_hot->comments) }}</span>
                                            <span><i class="fa fa-eye"></i> {{ $outstanding_posts_hot->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    `
                        });
                    ListPost.append(htmls);
                }
                if(index==1){
                    const htmls  = (() =>{
                    return `
                        @foreach($outstanding_posts as $outstanding_post)
                            <li>
                                <div class="sidebar-post-item-simple featured">
                                        <a href="{{ route('posts.show', $outstanding_post) }}" class="thumb-sm"><img
                                            src="{{ optional($outstanding_post->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}"
                                            alt=""></a>
                                    <div class="post-info">
                                        <h4><a href="{{ route('posts.show', $outstanding_post) }}">{{ $outstanding_post->title}}</a></h4>
                                        <div class="meta-sm">
                                            <span><i class="fa fa-clock-o"></i> {{ $outstanding_post->created_at->locale('vi')->diffForHumans() }}</span>
                                            <span><i class="fa fa-comments"></i> {{ count($outstanding_post->comments) }}</span>
                                            <span><i class="fa fa-eye"></i> {{ $outstanding_post->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    `
                        });
                    ListPost.append(htmls);
                }
                if(index==2){
                    const htmls  = (() =>{
                    return `
                         @foreach($outstanding_posts_views as $outstanding_posts_view)
                            <li>
                                <div class="sidebar-post-item-simple featured">
                                        <a href="{{ route('posts.show', $outstanding_posts_view) }}" class="thumb-sm"><img
                                            src="{{ optional($outstanding_posts_view->image)->url ?? asset('storage/placeholders/placeholder-image.png') }}"
                                            alt=""></a>
                                    <div class="post-info">
                                        <h4><a href="{{ route('posts.show', $outstanding_posts_view) }}">{{ $outstanding_posts_view->title}}</a></h4>
                                        <div class="meta-sm">
                                            <span><i class="fa fa-clock-o"></i> {{ $outstanding_posts_view->created_at->locale('vi')->diffForHumans() }}</span>
                                            <span><i class="fa fa-comments"></i> {{ count($outstanding_posts_view->comments) }}</span>
                                            <span><i class="fa fa-eye"></i> {{ $outstanding_posts_view->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    `
                        });
                    ListPost.append(htmls);
                }


            });
        });
</script>

<script>
    $(document).on('submit', '.js-comment-form', function (event) {
        const $form = $(this);
        const postSlug = $form.data('post-slug') || $form.find("input[name='post_slug']").val();
        const postId = $form.data('post-id') || $form.find("input[name='post_id']").val();

        if (!postSlug || !postId) {
            return; // Thiếu dữ liệu, để form submit bình thường
        }

        event.preventDefault();

        const $error = $form.find('.comment_error');
        const $message = $('.global-message');
        const $commentField = $form.find("textarea[name='the_comment']");
        const commentText = ($commentField.val() || '').trim();

        if (commentText.length === 0) {
            $error.text('Vui lòng nhập nội dung bình luận.');
            return;
        }

        $error.text('');

        let commentCount = parseInt($('.post_count_comment').text(), 10);
        if (Number.isNaN(commentCount)) {
            commentCount = 0;
        }

        const commentList = $('.comment--items');
        const formData = new FormData($form[0]);

        $.ajax({
            url: "{{ route('posts.addCommentUser') }}",
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success) {
                    commentCount += 1;
                    $('.post_count_comment').text(commentCount);

                    const escapedComment = $('<div>').text(data.result.the_comment).html();

                    const newCommentHtml = `
                        @auth
                        <li id="comment_${data.result.id}">
                            <div class="comment--item clearfix">
                                <div class="comment--img float--left">
                                    <img src="{{ optional(auth()->user()->image)->url ?? asset('storage/placeholders/user_placeholder.jpg') }}" style="border-radius: 50%; margin: auto; width: 68px; height: 68px; object-fit: cover; object-position: center;"  alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                                </div>
                                <div class="comment--info">
                                    <div class="comment--header clearfix">
                                        <p class="name">{{ auth()->user()->name }}</p>
                                        <p class="date">vừa xong</p>
                                        <a href="javascript:;" class="reply"><i class="fa fa-flag"></i></a>
                                        <form method="POST" action="{{ url('/binh-luan') }}/${data.result.id}" class="delete-comment-form d-inline-block" data-comment-id="${data.result.id}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="delete-comment-btn btn btn-link btn-sm text-danger p-0 ms-2">Xóa</button>
                                        </form>
                                    </div>
                                    <div class="comment--content">
                                        <p>${escapedComment}</p>
                                        <p class="star">
                                            <span class="text-left"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endauth
                    `;

                    commentList.append(newCommentHtml);

                    if ($message.length) {
                        $message.removeClass('alert-success alert-danger').addClass('alert alert-info').text(data.message).fadeIn();
                        setTimeout(() => {
                            $(".global-message").fadeOut();
                        }, 5000);
                    }

                    clearData($form, ['the_comment']);
                    $commentField.focus();
                } else {
                    const errorText = data.errors || data.message || 'Không thể bình luận. Vui lòng thử lại.';
                    $error.text(errorText);
                }
            },
            error: function () {
                $error.text('Đã xảy ra lỗi trong quá trình gửi bình luận. Vui lòng thử lại.');
            }
        });
    });

    $(document).on('submit', '.delete-comment-form', function (event) {
        const $form = $(this);
        const actionUrl = $form.attr('action');
        const commentId = $form.data('comment-id');

        if (!actionUrl || !commentId) {
            return;
        }

        if (!$form.find('input[name="_token"]').length) {
            return; // Thiếu CSRF token nên để form submit bình thường
        }

        event.preventDefault();

        const $button = $form.find('.delete-comment-btn');
        const $message = $('.global-message');
        const requestData = $form.serialize();

        $button.prop('disabled', true);

        $.ajax({
            url: actionUrl,
            type: 'POST',
            dataType: 'json',
            data: requestData,
            headers: {
                'Accept': 'application/json',
            },
            success: function (response) {
                if (response.success) {
                    const $commentItem = $('#comment_' + commentId);
                    if ($commentItem.length) {
                        $commentItem.remove();
                    }

                    let commentCount = parseInt($('.post_count_comment').text(), 10);
                    if (Number.isNaN(commentCount) || commentCount <= 0) {
                        commentCount = 0;
                    } else {
                        commentCount -= 1;
                    }
                    $('.post_count_comment').text(commentCount);

                    if ($message.length) {
                        $message.removeClass('alert-success alert-danger').addClass('alert alert-info').text(response.message || 'Bình luận đã được xóa.').fadeIn();
                        setTimeout(() => {
                            $(".global-message").fadeOut();
                        }, 5000);
                    }
                } else if (response.message) {
                    if ($message.length) {
                        $message.removeClass('alert-info alert-success').addClass('alert alert-danger').text(response.message).fadeIn();
                        setTimeout(() => {
                            $(".global-message").fadeOut();
                        }, 5000);
                    }
                }
            },
            error: function (xhr) {
                const errorMessage = xhr?.responseJSON?.message || 'Không thể xóa bình luận. Vui lòng thử lại.';

                if ($message.length) {
                    $message.removeClass('alert-info alert-success').addClass('alert alert-danger').text(errorMessage).fadeIn();
                    setTimeout(() => {
                        $(".global-message").fadeOut();
                    }, 5000);
                }
            },
            complete: function () {
                $button.prop('disabled', false);
            }
        });
    });
</script>

@endsection
