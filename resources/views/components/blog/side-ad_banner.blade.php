<div class="sidebar-widget sidebar-widget-ads">
    <h3 class="widget-title"><i class="fa fa-bullhorn"></i> Quảng cáo</h3>
    @php
        $ads = [
            [
                'badge' => 'Đối tác',
                'title' => 'Bộ sưu tập Xuân 2025',
                'highlight' => 'Ưu đãi 40%',
                'description' => 'Chọn ngay đôi sandal nữ yêu thích và nhận ưu đãi cùng quà tặng dành cho khách mới.',
                'image' => '300x250_banner_mwc2.jpg',
                'url' => 'https://mwc.com.vn/products/giay-sandal-nu-mwc-nusd--2887',
                'features' => [
                    'Freeship đơn từ 499k',
                    'Đổi size miễn phí 7 ngày',
                    'Tặng voucher 50k cho khách mới',
                ],
            ],
            [
                'badge' => 'Tài trợ',
                'title' => 'Hosting cho blog tin tức',
                'highlight' => 'Chỉ từ 69K/tháng',
                'description' => 'Xây dựng trang tin tốc độ cao với hạ tầng tối ưu cho WordPress và hỗ trợ kỹ thuật 24/7.',
                'image' => 'banner_quangcao2.png',
                'url' => 'https://www.hostinger.vn/web-hosting',
                'features' => [
                    'Tặng tên miền .com năm đầu',
                    'SSL miễn phí trọn đời',
                    'Tích hợp Cloudflare CDN',
                ],
            ],
            [
                'badge' => 'Ưu đãi độc quyền',
                'title' => 'Khoá học Content Marketing',
                'highlight' => 'Tiết kiệm 35%',
                'description' => 'Nâng cấp kỹ năng viết bài và SEO với chương trình học giàu case study thực tế.',
                'image' => 'banner_quangcao3.png',
                'url' => 'https://edumall.vn/khoa-hoc/content-marketing',
                'features' => [
                    '30+ bài học video HD',
                    'Case study từ chuyên gia',
                    'Hoàn tiền 7 ngày nếu không hài lòng',
                ],
            ],
            [
                'badge' => 'Gợi ý mua sắm',
                'title' => 'Gian hàng công nghệ chính hãng',
                'highlight' => 'Giảm đến 1.5 triệu',
                'description' => 'Sắm laptop, tablet và phụ kiện với ưu đãi độc quyền cho độc giả của News 24h.',
                'image' => 'banner_quangcao1.png',
                'url' => 'https://shopee.vn/mall',
                'features' => [
                    'Hàng chính hãng 100%',
                    'Trả góp 0% lãi suất',
                    'Miễn phí vận chuyển toàn quốc',
                ],
            ],
            [
                'badge' => 'Tin tuyển dụng',
                'title' => 'Tuyển biên tập viên nội dung',
                'highlight' => 'Lương từ 12 triệu',
                'description' => 'Gia nhập đội ngũ sáng tạo nội dung chuyên nghiệp, môi trường năng động và cơ hội phát triển rõ ràng.',
                'image' => 'banner_quangcao.png',
                'url' => 'https://www.topcv.vn/viec-lam/bien-tap-vien-noi-dung',
                'features' => [
                    'Làm việc hybrid linh hoạt',
                    'Thưởng KPI hàng quý',
                    'Đào tạo SEO và data journalism',
                ],
            ],
        ];
    @endphp
    <div class="widget-content">
        <style>
            .sidebar-widget-ads .ad-card {
                background: linear-gradient(135deg, rgba(9, 89, 171, 0.08), rgba(44, 133, 223, 0.04));
                border: 1px solid rgba(15, 23, 42, 0.08);
                border-radius: 20px;
                padding: 22px;
                display: flex;
                flex-direction: column;
                gap: 18px;
                position: relative;
            }

            .sidebar-widget-ads .ad-card + .ad-card {
                margin-top: 20px;
            }

            .sidebar-widget-ads .ad-badge {
                align-self: flex-start;
                background: #0959ab;
                border-radius: 999px;
                color: #fff;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 0.08em;
                padding: 6px 16px;
                text-transform: uppercase;
            }

            .sidebar-widget-ads .ad-highlight {
                align-self: flex-start;
                background: rgba(9, 89, 171, 0.15);
                border-radius: 10px;
                color: #0b6fd5;
                font-size: 12px;
                font-weight: 600;
                padding: 6px 12px;
            }

            .sidebar-widget-ads .ad-image {
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 14px 30px rgba(9, 89, 171, 0.18);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .sidebar-widget-ads .ad-image:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 36px rgba(9, 89, 171, 0.24);
            }

            .sidebar-widget-ads .ad-image img {
                display: block;
                width: 100%;
                height: auto;
            }

            .sidebar-widget-ads .ad-body h4 {
                font-size: 19px;
                font-weight: 700;
                color: #0f172a;
                margin: 0;
            }

            .sidebar-widget-ads .ad-body p {
                font-size: 14px;
                color: #475569;
                margin: 10px 0 0;
                line-height: 1.7;
            }

            .sidebar-widget-ads .ad-features {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .sidebar-widget-ads .ad-feature {
                align-items: center;
                background: rgba(15, 23, 42, 0.06);
                border-radius: 999px;
                color: #1e293b;
                display: inline-flex;
                gap: 6px;
                font-size: 13px;
                font-weight: 500;
                padding: 7px 14px;
            }

            .sidebar-widget-ads .ad-feature i {
                color: #0b6fd5;
                font-size: 12px;
            }

            .sidebar-widget-ads .ad-btn {
                align-self: flex-start;
                background: #0959ab;
                border-radius: 12px;
                color: #fff;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                padding: 11px 20px;
                text-decoration: none;
                transition: background 0.3s ease, transform 0.3s ease;
            }

            .sidebar-widget-ads .ad-btn:hover {
                background: #0b6fd5;
                transform: translateY(-2px);
            }

            @media (max-width: 600px) {
                .sidebar-widget-ads .ad-card {
                    padding: 18px;
                }

                .sidebar-widget-ads .ad-body h4 {
                    font-size: 18px;
                }

                .sidebar-widget-ads .ad-body p {
                    font-size: 13px;
                }

                .sidebar-widget-ads .ad-feature {
                    font-size: 12px;
                    padding: 6px 12px;
                }
            }
        </style>
        @foreach($ads as $ad)
            <div class="ad-card">
                <span class="ad-badge">{{ $ad['badge'] }}</span>
                <span class="ad-highlight">{{ $ad['highlight'] }}</span>
                <a class="ad-image" href="{{ $ad['url'] }}" target="_blank" rel="noopener noreferrer">
                    <img src="{{ asset('kcnew/frontend/img/ads-img/' . $ad['image']) }}" alt="{{ $ad['title'] }}">
                </a>
                <div class="ad-body">
                    <h4>{{ $ad['title'] }}</h4>
                    <p>{{ $ad['description'] }}</p>
                </div>
                <ul class="ad-features">
                    @foreach($ad['features'] as $feature)
                        <li class="ad-feature"><i class="fa fa-check"></i> {{ $feature }}</li>
                    @endforeach
                </ul>
                <a class="ad-btn" href="{{ $ad['url'] }}" target="_blank" rel="noopener noreferrer">
                    Khám phá ngay <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        @endforeach
    </div>
</div>