<?php

function checkPermission($name) {
    $roleName = strtolower(auth()->user()->role->name ?? '');
    if (in_array($roleName, ['admin', 'administrator'], true)) {
        return true;
    }
    $route_arr = auth()->user()->role->permissions;
    $route = $route_arr->where('name', $name)->count();
    if($route == 1){
        return true;
    }
    return false;
}

?>
<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-brand">
            <img src="{{ asset('kcnew/frontend/img/image_iconLogo.png') }}" class="logo-icon" alt="VN News logo">
            <div class="brand-text">
                <span class="brand-title">VN News</span>
                <span class="brand-tagline">Dashboard</span>
            </div>
        </div>
        <div class="toggle-icon ms-auto">
            <i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    @php
        $user = auth()->user();
        $avatar = $user && $user->image ? asset('storage/' . $user->image->path) : asset('storage/placeholders/user_placeholder.jpg');
        $roleName = $user && $user->role ? ($user->role->display_name ?? ucfirst($user->role->name)) : 'Quản trị viên';
        $today = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->locale('vi');
        $hasContentManagement = checkPermission('admin.posts.index') || checkPermission('admin.posts.create') || checkPermission('admin.categories.index') || checkPermission('admin.categories.create') || checkPermission('admin.tags.index') || checkPermission('admin.comments.index') || checkPermission('admin.comments.create');
        $hasUserManagement = checkPermission('admin.roles.index') || checkPermission('admin.roles.create') || checkPermission('admin.users.index') || checkPermission('admin.users.create');
        $hasOperations = checkPermission('admin.contacts') || checkPermission('admin.setting.edit');
    @endphp

    <div class="sidebar-hero">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar" style="background-image: url('{{ $avatar }}');"></div>
            <div>
                <p class="sidebar-welcome">Xin chào 👋</p>
                <h4 class="sidebar-username">{{ $user->name ?? 'Quản trị viên' }}</h4>
                <span class="sidebar-role">{{ $roleName }}</span>
            </div>
        </div>
        <div class="sidebar-chips">
            <span class="sidebar-chip"><i class='bx bx-calendar'></i> {{ $today->translatedFormat('d F Y') }}</span>
            <span class="sidebar-chip"><i class='bx bx-time-five'></i> {{ $today->format('H:i') }}</span>
        </div>
    </div>

    <!--navigation-->
    <ul class="metismenu sidebar-nav" id="menu">
        @if(checkPermission('admin.index'))
            <li class="nav-section-title">Tổng quan</li>
            <li>
                <a href="{{ route('admin.index') }}">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                    <div class="menu-title">Bảng điều khiển</div>
                </a>
            </li>
        @endif

        @if($hasContentManagement)
            <li class="nav-section-title">Quản lý nội dung</li>
        @endif

        @if(checkPermission('admin.posts.index') || checkPermission('admin.posts.create'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-news'></i></div>
                    <div class="menu-title">Bài viết</div>
                </a>
                <ul>
                    @if(checkPermission('admin.posts.index'))
                        <li><a href="{{ route('admin.posts.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả bài viết</a></li>
                    @endif
                    @if(checkPermission('admin.posts.create'))
                        <li><a href="{{ route('admin.posts.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm bài viết mới</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(checkPermission('admin.categories.index') || checkPermission('admin.categories.create'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-category'></i></div>
                    <div class="menu-title">Danh mục</div>
                </a>
                <ul>
                    @if(checkPermission('admin.categories.index'))
                        <li><a href="{{ route('admin.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả danh mục</a></li>
                    @endif
                    @if(checkPermission('admin.categories.create'))
                        <li><a href="{{ route('admin.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm danh mục mới</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(checkPermission('admin.tags.index'))
            <li>
                <a href="{{ route('admin.tags.index') }}">
                    <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
                    <div class="menu-title">Từ khóa</div>
                </a>
            </li>
        @endif

        @if(checkPermission('admin.comments.index') || checkPermission('admin.comments.create'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-message-rounded-dots'></i></div>
                    <div class="menu-title">Bình luận</div>
                </a>
                <ul>
                    @if(checkPermission('admin.comments.index'))
                        <li><a href="{{ route('admin.comments.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả bình luận</a></li>
                    @endif
                    @if(checkPermission('admin.comments.create'))
                        <li><a href="{{ route('admin.comments.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm bình luận mới</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if($hasUserManagement)
            <li class="nav-section-title">Người dùng &amp; quyền</li>
        @endif

        @if(checkPermission('admin.roles.index') || checkPermission('admin.roles.create'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-key'></i></div>
                    <div class="menu-title">Phân quyền</div>
                </a>
                <ul>
                    @if(checkPermission('admin.roles.index'))
                        <li><a href="{{ route('admin.roles.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả quyền</a></li>
                    @endif
                    @if(checkPermission('admin.roles.create'))
                        <li><a href="{{ route('admin.roles.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm quyền mới</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(checkPermission('admin.users.index') || checkPermission('admin.users.create'))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
                    <div class="menu-title">Tài khoản</div>
                </a>
                <ul>
                    @if(checkPermission('admin.users.index'))
                        <li><a href="{{ route('admin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>Tất cả tài khoản</a></li>
                    @endif
                    @if(checkPermission('admin.users.create'))
                        <li><a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Thêm tài khoản mới</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if($hasOperations)
            <li class="nav-section-title">Vận hành</li>
        @endif

        @if(checkPermission('admin.contacts'))
            <li>
                <a href="{{ route('admin.contacts') }}">
                    <div class="parent-icon"><i class='bx bx-mail-send'></i></div>
                    <div class="menu-title">Liên hệ</div>
                </a>
            </li>
        @endif

        @if(checkPermission('admin.setting.edit'))
            <li>
                <a href="{{ route('admin.setting.edit') }}">
                    <div class="parent-icon"><i class='bx bx-cog'></i></div>
                    <div class="menu-title">Cài đặt hệ thống</div>
                </a>
            </li>
        @endif
    </ul>
    <!--end navigation-->

    <div class="sidebar-footer-actions">
        @if(checkPermission('admin.posts.create'))
            <a href="{{ route('admin.posts.create') }}" class="btn-quick-link">
                <i class='bx bx-pencil'></i>
                Viết bài mới
            </a>
        @endif
        <a href="{{ route('home') }}" target="_blank" class="btn-quick-link btn-quick-link--ghost">
            <i class='bx bx-globe'></i>
            Xem trang ngoài
        </a>
    </div>
</div>
<!--end sidebar wrapper -->