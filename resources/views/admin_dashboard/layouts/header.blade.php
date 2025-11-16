<?php
    use App\Models\Comment;
    use App\Models\Contact;
    use Illuminate\Support\Str;

    $recentNotifications = Contact::orderByDesc('created_at')->take(7)->get();
    $unreadNotificationCount = Contact::where('is_read', false)->count();

    $recentComments = Comment::with([
        'post:id,slug,title',
        'user:id,name',
        'user.image'
    ])->orderByDesc('created_at')->take(10)->get();
    $unreviewedCommentCount = Comment::where('is_reviewed', false)->count();

    $notificationBadge = $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount;
    $commentBadge = $unreviewedCommentCount > 99 ? '99+' : $unreviewedCommentCount;
    $commentPlaceholder = asset('storage/placeholders/user_placeholder.jpg');
?>

<!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <form class="position-relative search-bar-box" method="GET" action="{{ route('admin.posts.index') }}">
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control search-control" placeholder="Nhập để tìm kiếm bài viết...">
                            <button type="submit" class="position-absolute top-50 search-show translate-middle-y border-0 bg-transparent p-0"><i class='bx bx-search'></i></button>
                            @if(request('search'))
                                <a href="{{ route('admin.posts.index') }}" class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></a>
                            @else
                                <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                            @endif
                        </form>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item mobile-search-icon">
                                <a class="nav-link" href="#">   <i class='bx bx-search'></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class='bx bx-category'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="row row-cols-3 g-3 p-3">
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                                            </div>
                                            <div class="app-title">Teams</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                            </div>
                                            <div class="app-title">Projects</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                                            </div>
                                            <div class="app-title">Tasks</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                                            </div>
                                            <div class="app-title">Feeds</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                                            </div>
                                            <div class="app-title">Files</div>
                                        </div>
                                        <div class="col text-center">
                                            <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
                                            </div>
                                            <div class="app-title">Alerts</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">{{ $notificationBadge }}</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="msg-header">
                                        <p class="msg-header-title mb-0">Thông báo</p>
                                        <form method="POST" action="{{ route('admin.notifications.contacts.read_all') }}" class="ms-auto">
                                            @csrf
                                            <button type="submit" class="msg-header-clear ms-auto" {{ $unreadNotificationCount === 0 ? 'disabled' : '' }}>Đánh dấu tất cả đã đọc</button>
                                        </form>
                                    </div>
                                    <div class="header-notifications-list">
                                        @forelse ($recentNotifications as $notification)
                                            @php
                                                $isUnreadNotification = ! $notification->is_read;
                                            @endphp
                                            <form method="POST" action="{{ route('admin.notifications.contacts.read', $notification) }}" class="dropdown-item-form p-0">
                                                @csrf
                                                <input type="hidden" name="redirect_to" value="{{ route('admin.contacts') }}">
                                                <button type="submit" class="dropdown-item w-100 px-0 py-0 border-0 bg-transparent">
                                                    <div class="d-flex align-items-center px-3 py-2 {{ $isUnreadNotification ? 'notification-unread' : 'notification-read' }}">
                                                        <div class="notify bg-light-primary text-primary"><i class="bx bx-envelope"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="msg-name mb-1 {{ $isUnreadNotification ? 'fw-semibold' : '' }}">
                                                                {{ trim(($notification->first_name ?? '') . ' ' . ($notification->last_name ?? '')) ?: ($notification->email ?? 'Khách') }}
                                                                <span class="msg-time float-end">{{ optional($notification->created_at)->diffForHumans() }}</span>
                                                            </h6>
                                                            <p class="msg-info mb-0">{{ Str::limit($notification->subject ?? 'Không có tiêu đề', 60) }}</p>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        @empty
                                        <div class="dropdown-item text-center text-muted py-2">Không có thông báo mới</div>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('admin.contacts') }}">
                                        <div class="text-center msg-footer">Xem tất cả thông báo</div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">{{ $commentBadge }}</span>
                                    <i class='bx bx-comment'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="msg-header">
                                        <p class="msg-header-title mb-0">Tin nhắn bình luận</p>
                                        <form method="POST" action="{{ route('admin.notifications.comments.read_all') }}" class="ms-auto">
                                            @csrf
                                            <button type="submit" class="msg-header-clear ms-auto" {{ $unreviewedCommentCount === 0 ? 'disabled' : '' }}>Đánh dấu tất cả đã đọc</button>
                                        </form>
                                    </div>

                                    <div class="header-message-list">
                                        @forelse ($recentComments as $recentComment)
                                            @php
                                                $commentUser = $recentComment->user;
                                                $commentPost = $recentComment->post;
                                                $commentAvatar = $commentUser && $commentUser->image ? $commentUser->image->url : $commentPlaceholder;
                                                $commentLink = $commentPost ? route('posts.show', $commentPost) : route('admin.comments.index');
                                                $isUnreadComment = ! $recentComment->is_reviewed;
                                            @endphp
                                            <form method="POST" action="{{ route('admin.notifications.comments.read', $recentComment) }}" class="dropdown-item-form p-0">
                                                @csrf
                                                <input type="hidden" name="redirect_to" value="{{ $commentLink }}">
                                                <button type="submit" class="dropdown-item w-100 px-0 py-0 border-0 bg-transparent">
                                                    <div class="d-flex align-items-center px-3 py-2 {{ $isUnreadComment ? 'notification-unread' : 'notification-read' }}">
                                                        <div class="user-online">
                                                            <img class="img_admn--user img-avatar" width="50" height="50" style="border-radius: 50%; margin: auto; object-fit: cover; object-position: center;" src="{{ $commentAvatar }}" alt="Ảnh người dùng" onerror="this.onerror=null;this.src='{{ $commentPlaceholder }}';">
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <h6 class="msg-name mb-1 {{ $isUnreadComment ? 'fw-semibold' : '' }}">
                                                                {{ $commentUser->name ?? 'Người dùng' }}
                                                                <span class="msg-time float-end">{{ optional($recentComment->created_at)->diffForHumans() }}</span>
                                                            </h6>
                                                            <p class="msg-info mb-1">{{ Str::limit($recentComment->the_comment ?? '', 80) }}</p>
                                                            @if ($commentPost)
                                                                <p class="msg-info text-muted mb-0">{{ Str::limit($commentPost->title, 40) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        @empty
                                            <div class="dropdown-item text-center text-muted py-2">Chưa có bình luận mới</div>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('admin.comments.index') }}">
                                        <div class="text-center msg-footer">Xem tất cả</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        @php
                            $navAvatar = auth()->user()->image ? auth()->user()->image->url : asset('storage/placeholders/user_placeholder.jpg');
                        @endphp
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img_admn--user img-avatar" width="50" height="50" style="border-radius: 50%; margin: auto; object-fit: cover; object-position: center;" src="{{ $navAvatar }}" alt="Ảnh đại diện" onerror="this.onerror=null;this.src='{{ asset('storage/placeholders/user_placeholder.jpg') }}';">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ auth()->user()->name }}</p>
                                <p class="designattion mb-0">{{ auth()->user()->role->name }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bx bx-user"></i><span>Hồ sơ</span>
                                </a>
                            </li>
                            @if(function_exists('checkPermission') ? checkPermission('admin.setting.edit') : true)
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.setting.edit') }}">
                                    <i class="bx bx-cog"></i><span>Cài đặt</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            
                            <li><a onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();"
							     class="dropdown-item" ><i class='bx bx-log-out-circle'></i><span>Đăng xuất</span></a>
                                <form id="nav-logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->