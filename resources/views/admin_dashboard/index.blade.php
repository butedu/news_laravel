@extends("admin_dashboard.layouts.app")
@section('style')
    <link href="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
    <style>
        :root {
            --ds-surface: #ffffff;
            --ds-surface-muted: #f6f9ff;
            --ds-surface-strong: #0f172a;
            --ds-muted: #64748b;
            --ds-accent: #2c85df;
            --ds-accent-dark: #0959ab;
            --ds-rose: #e63270;
            --ds-amber: #f59e0b;
            --ds-teal: #0f766e;
            --ds-border: rgba(15, 23, 42, 0.08);
        }

        .dashboard-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .dashboard-hero {
            position: relative;
            border: none;
            border-radius: 26px;
            background: radial-gradient(circle at top left, rgba(44, 133, 223, 0.2), rgba(9, 89, 171, 0.08)), linear-gradient(150deg, #ffffff 0%, #f4f8ff 100%);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .dashboard-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(230, 50, 112, 0.15), transparent 55%);
            pointer-events: none;
        }

        .dashboard-hero .card-body {
            position: relative;
            z-index: 1;
            padding: 40px;
        }

        .hero-greeting {
            font-size: 28px;
            font-weight: 700;
            color: var(--ds-surface-strong);
            margin-bottom: 8px;
        }

        .hero-subtitle {
            max-width: 520px;
            color: var(--ds-muted);
            font-size: 16px;
        }

        .hero-metrics {
            margin-top: 26px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            color: var(--ds-surface-strong);
            font-weight: 600;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
        }

        .hero-figure {
            position: absolute;
            right: -60px;
            bottom: -60px;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(9, 89, 171, 0.32), rgba(9, 89, 171, 0));
            border-radius: 50%;
        }

        .metric-card {
            border: none;
            border-radius: 22px;
            padding: 24px;
            background: var(--ds-surface);
            box-shadow: 0 22px 44px rgba(15, 23, 42, 0.08);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 56px rgba(15, 23, 42, 0.12);
        }

        .metric-card .metric-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(44, 133, 223, 0.15);
            color: var(--ds-accent-dark);
            font-size: 28px;
            box-shadow: 0 16px 32px rgba(44, 133, 223, 0.2);
        }

        .metric-card--categories .metric-icon {
            background: rgba(230, 50, 112, 0.18);
            color: var(--ds-rose);
            box-shadow: 0 16px 32px rgba(230, 50, 112, 0.22);
        }

        .metric-card--admins .metric-icon {
            background: rgba(45, 212, 191, 0.18);
            color: var(--ds-teal);
            box-shadow: 0 16px 32px rgba(45, 212, 191, 0.22);
        }

        .metric-card--users .metric-icon {
            background: rgba(245, 158, 11, 0.18);
            color: var(--ds-amber);
            box-shadow: 0 16px 32px rgba(245, 158, 11, 0.22);
        }

        .metric-label {
            font-size: 15px;
            color: var(--ds-muted);
            margin-bottom: 4px;
        }

        .metric-value {
            font-size: 30px;
            font-weight: 700;
            color: var(--ds-surface-strong);
            margin-bottom: 2px;
        }

        .metric-subtext {
            font-size: 13px;
            color: rgba(15, 23, 42, 0.6);
        }

        .analytics-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.12);
            background: var(--ds-surface);
            height: 100%;
        }

        .analytics-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
        }

        .analytics-header h5 {
            font-size: 20px;
            font-weight: 700;
            color: var(--ds-surface-strong);
            margin-bottom: 6px;
        }

        .analytics-header p {
            margin: 0;
            color: var(--ds-muted);
            font-size: 14px;
        }

        .analytics-actions .btn {
            border-radius: 12px;
            background: rgba(44, 133, 223, 0.12);
            color: var(--ds-accent-dark);
            border: none;
            font-weight: 600;
        }

        .analytics-legend {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin: 20px 0 14px;
        }

        .legend-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.06);
            color: var(--ds-surface-strong);
            font-size: 13px;
            font-weight: 600;
        }

        .legend-pill i {
            font-size: 12px;
        }

        .chart-wrapper {
            position: relative;
            height: 340px;
        }

        .analytics-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            margin-top: 26px;
        }

        .analytics-summary .summary-item {
            background: var(--ds-surface-muted);
            border-radius: 16px;
            padding: 16px;
        }

        .summary-item span {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: rgba(15, 23, 42, 0.6);
            margin-bottom: 6px;
        }

        .summary-item strong {
            font-size: 20px;
            color: var(--ds-surface-strong);
        }

        .insight-card {
            border: none;
            border-radius: 24px;
            background: var(--ds-surface);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.1);
        }

        .insight-card h5 {
            font-size: 18px;
            font-weight: 700;
            color: var(--ds-surface-strong);
            margin-bottom: 16px;
        }

        .insight-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .insight-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-radius: 16px;
            background: var(--ds-surface-muted);
        }

        .insight-item span:first-child {
            font-weight: 600;
            color: var(--ds-muted);
        }

        .insight-item span:last-child {
            font-weight: 700;
            color: var(--ds-surface-strong);
        }

        .insight-note {
            margin-top: 14px;
            font-size: 12px;
            color: rgba(15, 23, 42, 0.6);
        }

        .category-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .category-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.04);
        }

        .category-item strong {
            color: var(--ds-surface-strong);
        }

        .category-views {
            font-size: 12px;
            color: rgba(15, 23, 42, 0.55);
        }

        .dashboard-table thead th {
            border: none;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: rgba(15, 23, 42, 0.6);
        }

        .dashboard-table tbody tr {
            vertical-align: middle;
            transition: background 0.2s ease;
        }

        .dashboard-table tbody tr:hover {
            background: rgba(44, 133, 223, 0.05);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-approved {
            background: rgba(15, 118, 110, 0.12);
            color: var(--ds-teal);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.12);
            color: var(--ds-amber);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .activity-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
        }

        .activity-body h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--ds-surface-strong);
        }

        .activity-body p {
            margin: 4px 0 0;
            font-size: 13px;
            color: var(--ds-muted);
        }

        .activity-time {
            font-size: 12px;
            color: rgba(15, 23, 42, 0.5);
            margin-top: 4px;
        }

        .author-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .author-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .author-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-meta .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
        }

        .author-meta .info {
            display: flex;
            flex-direction: column;
        }

        .author-meta .info strong {
            color: var(--ds-surface-strong);
        }

        .author-meta .info span {
            font-size: 12px;
            color: rgba(15, 23, 42, 0.55);
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
        }

        .quick-actions .btn {
            border-radius: 14px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .btn-outline-soft {
            border: 1px solid rgba(44, 133, 223, 0.28);
            background: rgba(44, 133, 223, 0.08);
            color: var(--ds-accent-dark);
        }

        .btn-outline-soft:hover {
            background: rgba(44, 133, 223, 0.15);
            color: var(--ds-accent-dark);
        }

        @media (max-width: 991px) {
            .dashboard-hero .card-body {
                padding: 28px;
            }

            .hero-greeting {
                font-size: 24px;
            }

            .metric-card {
                padding: 20px;
            }

            .chart-wrapper {
                height: 280px;
            }
        }

        @media (max-width: 575px) {
            .hero-metrics {
                flex-direction: column;
            }

            .dashboard-hero .card-body {
                padding: 24px;
            }
        }
    </style>
@endsection

@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content dashboard-page">
            <div class="card dashboard-hero">
                <div class="card-body">
                    <h2 class="hero-greeting">Xin chào, {{ auth()->user()->name ?? 'Quản trị viên' }} 👋</h2>
                    <p class="hero-subtitle">Theo dõi hiệu suất nội dung, tương tác của độc giả và tiến độ vận hành chỉ trong một bảng điều khiển duy nhất.</p>
                    <div class="hero-metrics">
                        <span class="hero-chip"><i class='bx bx-edit-alt'></i> {{ $postsLast7 }} bài viết mới / 7 ngày</span>
                        <span class="hero-chip"><i class='bx bx-message-rounded-dots'></i> {{ $commentsLast7 }} bình luận mới</span>
                        <span class="hero-chip"><i class='bx bx-user-plus'></i> {{ $usersLast7 }} thành viên đăng ký</span>
                    </div>
                    <div class="hero-figure"></div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-4 g-4">
                <div class="col">
                    <div class="metric-card metric-card--posts">
                        <div class="metric-icon"><i class='bx bx-news'></i></div>
                        <div>
                            <div class="metric-label">Tổng bài viết</div>
                            <div class="metric-value">{{ number_format($countPost) }}</div>
                            <div class="metric-subtext">{{ $postsLast7 }} bài viết được xuất bản 7 ngày qua</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="metric-card metric-card--categories">
                        <div class="metric-icon"><i class='bx bx-grid'></i></div>
                        <div>
                            <div class="metric-label">Tổng danh mục</div>
                            <div class="metric-value">{{ number_format($countCategories) }}</div>
                            <div class="metric-subtext">Danh mục hoạt động mạnh: {{ optional($popularCategories->first())->name ?? 'Đang cập nhật' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="metric-card metric-card--admins">
                        <div class="metric-icon"><i class='bx bx-shield-quarter'></i></div>
                        <div>
                            <div class="metric-label">Thành viên quản trị</div>
                            <div class="metric-value">{{ number_format($countAdmin) }}</div>
                            <div class="metric-subtext">{{ $pendingPosts }} bài viết đang chờ duyệt</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="metric-card metric-card--users">
                        <div class="metric-icon"><i class='bx bxs-user-detail'></i></div>
                        <div>
                            <div class="metric-label">Tổng độc giả</div>
                            <div class="metric-value">{{ number_format($countUser) }}</div>
                            <div class="metric-subtext">{{ $newsletterCount }} người theo dõi bản tin</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-12 col-xxl-8">
                    <div class="card analytics-card h-100">
                        <div class="card-body">
                            <div class="analytics-header">
                                <div>
                                    <h5>Hiệu suất nội dung</h5>
                                    <p>Lượt xem và bình luận theo ngày trong 7 ngày gần nhất</p>
                                </div>
                                <div class="analytics-actions">
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm">Xem chi tiết bài viết</a>
                                </div>
                            </div>
                            <div class="analytics-legend">
                                <span class="legend-pill"><i class='bx bxs-circle' style="color: #2c85df"></i> Lượt xem</span>
                                <span class="legend-pill"><i class='bx bxs-circle' style="color: #e63270"></i> Bình luận</span>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="trafficChart"></canvas>
                            </div>
                            <div class="analytics-summary">
                                <div class="summary-item">
                                    <span>Lượt xem trung bình</span>
                                    <strong>{{ number_format($avgViewsPerPost) }}</strong>
                                </div>
                                <div class="summary-item">
                                    <span>Bình luận / bài viết</span>
                                    <strong>{{ number_format($avgCommentsPerPost, 1) }}</strong>
                                </div>
                                <div class="summary-item">
                                    <span>Tỉ lệ tương tác</span>
                                    <strong>{{ number_format($engagementRate, 1) }}%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-4 d-flex flex-column gap-4">
                    <div class="card insight-card">
                        <div class="card-body">
                            <h5>Tổng quan tương tác</h5>
                            <div class="insight-list">
                                <div class="insight-item">
                                    <span>Lượt xem</span>
                                    <span>{{ number_format($countView) }}</span>
                                </div>
                                <div class="insight-item">
                                    <span>Bình luận</span>
                                    <span>{{ number_format($countComments) }}</span>
                                </div>
                                <div class="insight-item">
                                    <span>Lượt thích</span>
                                    <span>{{ number_format($countLikes) }}</span>
                                </div>
                            </div>
                            @if($likesEstimated)
                                <p class="insight-note">* Số lượt thích được ước tính dựa trên tần suất tương tác bình luận. Thiết lập cột <code>likes</code> cho bảng <strong>posts</strong> để hiển thị số liệu thực tế.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card insight-card">
                        <div class="card-body">
                            <h5>Chuyên mục nổi bật</h5>
                            <div class="category-list">
                                @forelse($popularCategories as $category)
                                    <div class="category-item">
                                        <div>
                                            <strong>{{ $category->name }}</strong>
                                            <div class="category-views">{{ $category->posts_count }} bài viết</div>
                                        </div>
                                        <i class='bx bx-right-arrow-alt'></i>
                                    </div>
                                @empty
                                    <p class="mb-0 text-muted">Chưa có dữ liệu chuyên mục.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xxl-8">
                    <div class="card insight-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Bài viết mới nhất</h5>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-outline-soft"><i class='bx bx-plus'></i> Tạo bài viết</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table dashboard-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tiêu đề</th>
                                            <th>Chuyên mục</th>
                                            <th>Trạng thái</th>
                                            <th>Lượt xem</th>
                                            <th>Ngày cập nhật</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentPosts as $post)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('posts.show', $post) }}" target="_blank" class="text-decoration-none fw-semibold">{{ Str::limit($post->title, 55) }}</a>
                                                </td>
                                                <td>{{ optional($post->category)->name ?? 'Không xác định' }}</td>
                                                <td>
                                                    @if($post->approved)
                                                        <span class="status-badge status-approved"><i class='bx bx-check'></i> Đã duyệt</span>
                                                    @else
                                                        <span class="status-badge status-pending"><i class='bx bx-time'></i> Chờ duyệt</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($post->views) }}</td>
                                                <td>{{ $post->updated_at?->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">Chưa có bài viết nào.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-4">
                    <div class="card insight-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Bình luận gần đây</h5>
                                <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-soft"><i class='bx bx-message-square-detail'></i> Quản lý</a>
                            </div>
                            <div class="activity-list">
                                @forelse($recentComments as $comment)
                                    @php
                                        $commentUser = $comment->user;
                                        $avatar = $commentUser && $commentUser->image ? asset('storage/' . $commentUser->image->path) : asset('storage/placeholders/user_placeholder.jpg');
                                    @endphp
                                    <div class="activity-item">
                                        <div class="activity-avatar" style="background-image: url('{{ $avatar }}');"></div>
                                        <div class="activity-body">
                                            <h6>{{ $commentUser->name ?? 'Người dùng ẩn danh' }}</h6>
                                            <p>"{{ Str::limit($comment->the_comment, 60) }}" trên <a href="{{ route('posts.show', $comment->post) }}" target="_blank">{{ Str::limit($comment->post->title ?? '', 40) }}</a></p>
                                            <div class="activity-time">{{ $comment->created_at?->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Chưa có bình luận gần đây.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xxl-4">
                    <div class="card insight-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Tác giả nổi bật</h5>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-soft"><i class='bx bx-user'></i> Quản lý</a>
                            </div>
                            <div class="author-list">
                                @forelse($topAuthors as $author)
                                    @php
                                        $avatar = $author->image ? asset('storage/' . $author->image->path) : asset('storage/placeholders/user_placeholder.jpg');
                                    @endphp
                                    <div class="author-item">
                                        <div class="author-meta">
                                            <div class="avatar" style="background-image: url('{{ $avatar }}');"></div>
                                            <div class="info">
                                                <strong>{{ $author->name }}</strong>
                                                <span>{{ $author->posts_count }} bài viết</span>
                                            </div>
                                        </div>
                                        <span class="metric-subtext">{{ $author->created_at?->diffForHumans() }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">Chưa có dữ liệu tác giả.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-8">
                    <div class="card insight-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Tác vụ nhanh</h5>
                                <span class="metric-subtext">{{ $contactCount }} liên hệ đã tiếp nhận</span>
                            </div>
                            <div class="quick-actions">
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-soft"><i class='bx bx-pencil'></i> Viết bài mới</a>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-soft"><i class='bx bx-category'></i> Quản lý danh mục</a>
                                <a href="{{ route('admin.contacts') }}" class="btn btn-outline-soft"><i class='bx bx-mail-send'></i> Hộp thư liên hệ</a>
                                <a href="{{ route('admin.setting.edit') }}" class="btn btn-outline-soft"><i class='bx bx-cog'></i> Cài đặt hệ thống</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section("script")
    <script src="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/js/index.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var labels = @json($trafficLabels);
            var viewsData = @json($trafficViews);
            var commentsData = @json($trafficComments);

            var canvas = document.getElementById('trafficChart');
            if (!canvas) {
                return;
            }

            var ctx = canvas.getContext('2d');
            var viewGradient = ctx.createLinearGradient(0, 0, 0, canvas.height || 340);
            viewGradient.addColorStop(0, '#2c85df');
            viewGradient.addColorStop(1, '#0959ab');

            var commentGradient = ctx.createLinearGradient(0, 0, 0, canvas.height || 340);
            commentGradient.addColorStop(0, '#e63270');
            commentGradient.addColorStop(1, '#b4234c');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Lượt xem',
                            data: viewsData,
                            backgroundColor: viewGradient,
                            hoverBackgroundColor: viewGradient,
                            borderWidth: 0,
                        },
                        {
                            label: 'Bình luận',
                            data: commentsData,
                            backgroundColor: commentGradient,
                            hoverBackgroundColor: commentGradient,
                            borderWidth: 0,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + tooltipItem.yLabel.toLocaleString('vi-VN');
                            },
                        },
                    },
                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: false,
                                },
                                ticks: {
                                    fontFamily: 'Inter, sans-serif',
                                },
                                barPercentage: 0.6,
                                categoryPercentage: 0.6,
                            },
                        ],
                        yAxes: [
                            {
                                gridLines: {
                                    color: 'rgba(15, 23, 42, 0.05)',
                                },
                                ticks: {
                                    beginAtZero: true,
                                    callback: function (value) {
                                        return value.toLocaleString('vi-VN');
                                    },
                                    fontFamily: 'Inter, sans-serif',
                                },
                            },
                        ],
                    },
                },
            });
        });
    </script>


@endsection
