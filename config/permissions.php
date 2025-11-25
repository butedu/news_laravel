<?php

return [
    'fallback_group_label' => 'Chức năng khác',

    'labels' => [
        'admin.index' => 'Bảng điều khiển',
        'admin.upload_tinymce_image' => 'Tải ảnh TinyMCE',

        'admin.posts.index' => 'Danh sách bài viết',
        'admin.posts.create' => 'Tạo bài viết',
        'admin.posts.store' => 'Lưu bài viết',
        'admin.posts.edit' => 'Chỉnh sửa bài viết',
        'admin.posts.update' => 'Cập nhật bài viết',
        'admin.posts.destroy' => 'Xóa bài viết',
        'admin.posts.to_slug' => 'Tạo slug từ tiêu đề',

        'admin.categories.index' => 'Danh sách chuyên mục',
        'admin.categories.create' => 'Tạo chuyên mục',
        'admin.categories.store' => 'Lưu chuyên mục',
        'admin.categories.edit' => 'Chỉnh sửa chuyên mục',
        'admin.categories.update' => 'Cập nhật chuyên mục',
        'admin.categories.destroy' => 'Xóa chuyên mục',

        'admin.tags.index' => 'Danh sách thẻ',
        'admin.tags.show' => 'Xem chi tiết thẻ',
        'admin.tags.destroy' => 'Xóa thẻ',

        'admin.comments.index' => 'Danh sách bình luận',
        'admin.comments.create' => 'Tạo bình luận',
        'admin.comments.store' => 'Lưu bình luận',
        'admin.comments.edit' => 'Chỉnh sửa bình luận',
        'admin.comments.update' => 'Cập nhật bình luận',
        'admin.comments.destroy' => 'Xóa bình luận',

        'admin.roles.index' => 'Danh sách quyền',
        'admin.roles.create' => 'Tạo quyền mới',
        'admin.roles.store' => 'Lưu quyền mới',
        'admin.roles.edit' => 'Chỉnh sửa quyền',
        'admin.roles.update' => 'Cập nhật quyền',
        'admin.roles.destroy' => 'Xóa quyền',

        'admin.users.index' => 'Danh sách người dùng',
        'admin.users.create' => 'Tạo người dùng',
        'admin.users.store' => 'Lưu người dùng',
        'admin.users.edit' => 'Chỉnh sửa người dùng',
        'admin.users.update' => 'Cập nhật người dùng',
        'admin.users.destroy' => 'Xóa người dùng',

        'admin.contacts' => 'Hộp thư liên hệ',
        'admin.contacts.attachment' => 'Xem tệp liên hệ',
        'admin.contacts.show' => 'Xem chi tiết liên hệ',
        'admin.contacts.reply' => 'Trả lời liên hệ',
        'admin.contacts.destroy' => 'Xóa liên hệ',

        'admin.notifications.contacts.read_all' => 'Đánh dấu tất cả liên hệ đã đọc',
        'admin.notifications.contacts.read' => 'Đánh dấu liên hệ đã đọc',
        'admin.notifications.comments.read_all' => 'Đánh dấu tất cả bình luận đã đọc',
        'admin.notifications.comments.read' => 'Đánh dấu bình luận đã đọc',

        'admin.setting.edit' => 'Chỉnh sửa trang giới thiệu',
        'admin.setting.update' => 'Cập nhật trang giới thiệu',

        'newsletter.store' => 'Đăng ký nhận tin',
        'newsletter_store' => 'Đăng ký nhận tin (cũ)',

        'home' => 'Trang chủ',
        'profile' => 'Hồ sơ cá nhân',
        'update' => 'Cập nhật hồ sơ',
        'erorrs.404' => 'Trang 404',
        'search' => 'Tìm kiếm',
        'newPost' => 'Tin mới nhất',
        'hotPost' => 'Tin nóng',
        'viewPost' => 'Xem nhiều nhất',
        'contact.create' => 'Trang liên hệ',
        'contact.store' => 'Gửi liên hệ',
        'categories.index' => 'Danh sách chuyên mục (frontend)',
        'categories.show' => 'Xem chuyên mục',
        'tags.show' => 'Xem thẻ',
        'posts.show' => 'Xem bài viết',
        'posts.add_comment' => 'Bình luận trên bài viết',
        'posts.addCommentUser' => 'Bình luận (AJAX)',
        'login' => 'Đăng nhập',
        'logout' => 'Đăng xuất',
        'register' => 'Đăng ký',
    ],

    'groups' => [
        'dashboard' => [
            'label' => 'Bảng điều khiển',
            'icon' => 'bx bx-home-circle',
            'items' => [
                'admin.index',
                'admin.upload_tinymce_image',
            ],
        ],

        'posts' => [
            'label' => 'Quản lý bài viết',
            'icon' => 'bx bx-news',
            'items' => [
                'admin.posts.index',
                'admin.posts.create',
                'admin.posts.store',
                'admin.posts.edit',
                'admin.posts.update',
                'admin.posts.destroy',
                'admin.posts.to_slug',
            ],
        ],

        'categories' => [
            'label' => 'Quản lý chuyên mục',
            'icon' => 'bx bx-category',
            'items' => [
                'admin.categories.index',
                'admin.categories.create',
                'admin.categories.store',
                'admin.categories.edit',
                'admin.categories.update',
                'admin.categories.destroy',
            ],
        ],

        'tags' => [
            'label' => 'Quản lý thẻ',
            'icon' => 'bx bx-purchase-tag',
            'items' => [
                'admin.tags.index',
                'admin.tags.show',
                'admin.tags.destroy',
            ],
        ],

        'comments' => [
            'label' => 'Quản lý bình luận',
            'icon' => 'bx bx-message-dots',
            'items' => [
                'admin.comments.index',
                'admin.comments.create',
                'admin.comments.store',
                'admin.comments.edit',
                'admin.comments.update',
                'admin.comments.destroy',
            ],
        ],

        'roles' => [
            'label' => 'Quyền & phân quyền',
            'icon' => 'bx bx-shield-quarter',
            'items' => [
                'admin.roles.index',
                'admin.roles.create',
                'admin.roles.store',
                'admin.roles.edit',
                'admin.roles.update',
                'admin.roles.destroy',
            ],
        ],

        'users' => [
            'label' => 'Quản lý người dùng',
            'icon' => 'bx bx-user-circle',
            'items' => [
                'admin.users.index',
                'admin.users.create',
                'admin.users.store',
                'admin.users.edit',
                'admin.users.update',
                'admin.users.destroy',
            ],
        ],

        'contacts' => [
            'label' => 'Hộp thư liên hệ',
            'icon' => 'bx bx-envelope',
            'items' => [
                'admin.contacts',
                'admin.contacts.attachment',
                'admin.contacts.show',
                'admin.contacts.reply',
                'admin.contacts.destroy',
            ],
        ],

        'notifications' => [
            'label' => 'Thông báo',
            'icon' => 'bx bx-bell',
            'items' => [
                'admin.notifications.contacts.read_all',
                'admin.notifications.contacts.read',
                'admin.notifications.comments.read_all',
                'admin.notifications.comments.read',
            ],
        ],

        'settings' => [
            'label' => 'Cấu hình hệ thống',
            'icon' => 'bx bx-cog',
            'items' => [
                'admin.setting.edit',
                'admin.setting.update',
            ],
        ],

        'newsletter' => [
            'label' => 'Bản tin',
            'icon' => 'bx bx-mail-send',
            'items' => [
                'newsletter.store',
                'newsletter_store',
            ],
        ],

        'frontend' => [
            'label' => 'Trang người dùng',
            'icon' => 'bx bx-window-alt',
            'items' => [
                'home',
                'profile',
                'update',
                'search',
                'newPost',
                'hotPost',
                'viewPost',
                'contact.create',
                'contact.store',
                'categories.index',
                'categories.show',
                'tags.show',
                'posts.show',
                'posts.add_comment',
                'posts.addCommentUser',
                'login',
                'logout',
                'register',
                'erorrs.404',
            ],
        ],
    ],
];
