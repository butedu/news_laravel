@extends('main_layouts.master')

@section('title','VN News - Giới thiệu')

@section('content')

<style>
:root {
	--about-primary: #256cb4ff;
	--about-primary-dark: #0959AB;
	--about-surface: #f4f6fb;
	--about-text: #1e293b;
	--about-muted: #4b5563;
}

.about-hero {
	position: relative;
	padding: 120px 0 100px;
	background: linear-gradient(135deg, rgba(12, 37, 83, 0.98) 0%, rgba(9, 89, 171, 0.92) 48%, rgba(44, 133, 223, 0.82) 100%);
	overflow: hidden;
}

.about-hero::before,
.about-hero::after {
	content: "";
	position: absolute;
	border-radius: 50%;
	opacity: 0.25;
}

.about-hero::before {
	width: 360px;
	height: 360px;
	background: radial-gradient(circle, rgba(255, 255, 255, 0.85) 0%, rgba(255, 255, 255, 0) 70%);
	top: -120px;
	right: -120px;
}

.about-hero::after {
	width: 280px;
	height: 280px;
	background: radial-gradient(circle, rgba(12, 74, 165, 0.7) 0%, rgba(12, 74, 165, 0) 70%);
	bottom: -80px;
	left: -80px;
}

.about-hero .container {
	position: relative;
	z-index: 1;
}

.hero-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
	gap: 48px;
	align-items: center;
}

.about-badge {
	display: inline-flex;
	align-items: center;
	gap: 10px;
	padding: 11px 20px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.18);
	color: #fff;
	font-size: 18px;
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 2px;
	margin-bottom: 26px;
}

.about-badge::before {
	content: "✦";
	font-size: 18px;
}

.hero-title {
	font-size: 52px;
	line-height: 1.2;
	font-weight: 700;
	color: #fff;
	margin-bottom: 30px;
	text-shadow: 0 6px 18px rgba(0, 0, 0, 0.28);
}

.hero-lead {
	font-size: 19px;
	line-height: 1.9;
	color: rgba(255, 255, 255, 0.92);
	margin-bottom: 36px;
	text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.hero-lead strong {
	color: #fff;
	font-weight: 600;
}

.hero-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 16px;
	margin-bottom: 44px;
}

.about-button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 10px;
	padding: 15px 30px;
	border-radius: 999px;
	font-size: 18px;
	font-weight: 600;
	text-decoration: none;
	transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
}

.about-button.primary {
	background: #fff;
	color: var(--about-primary-dark);
	box-shadow: 0 18px 42px rgba(12, 42, 89, 0.18);
}

.about-button.primary:hover {
	transform: translateY(-4px);
	box-shadow: 0 24px 52px rgba(12, 42, 89, 0.24);
}

.about-button.ghost {
	border: 2px solid rgba(255, 255, 255, 0.55);
	color: #fff;
}

.about-button.ghost:hover {
	background: rgba(255, 255, 255, 0.18);
	transform: translateY(-4px);
	box-shadow: 0 24px 50px rgba(12, 42, 89, 0.18);
}

.about-button:focus-visible {
	outline: 3px solid rgba(255, 255, 255, 0.5);
	outline-offset: 3px;
}

.hero-metrics {
	display: flex;
	flex-wrap: wrap;
	gap: 20px;
}

.metric-card {
	flex: 1 1 220px;
	min-width: 200px;
	background: rgba(15, 23, 42, 0.28);
	border-radius: 20px;
	padding: 26px;
	color: #fff;
	backdrop-filter: blur(6px);
	border: 1px solid rgba(255, 255, 255, 0.22);
	transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
}

.metric-card:hover {
	transform: translateY(-6px);
	background: rgba(9, 89, 171, 0.58);
	box-shadow: 0 20px 44px rgba(5, 31, 70, 0.3);
}

.metric-card strong {
	display: block;
	font-size: 36px;
	font-weight: 700;
	margin-bottom: 6px;
}

.metric-card span {
	display: block;
	font-size: 18px;
	font-weight: 500;
}

.hero-panel {
	background: rgba(255, 255, 255, 0.96);
	border-radius: 24px;
	padding: 34px;
	box-shadow: 0 26px 60px rgba(9, 89, 171, 0.2);
	color: var(--about-text);
	position: relative;
	overflow: hidden;
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hero-panel::after {
	content: "";
	position: absolute;
	top: -60px;
	right: -60px;
	width: 160px;
	height: 160px;
	background: radial-gradient(circle, rgba(44, 133, 223, 0.25) 0%, rgba(44, 133, 223, 0) 70%);
}

.hero-panel:hover {
	transform: translateY(-6px);
	box-shadow: 0 32px 72px rgba(9, 89, 171, 0.24);
}

.hero-panel h3 {
	font-size: 26px;
	font-weight: 700;
	margin-bottom: 20px;
}

.panel-list {
	display: grid;
	gap: 14px;
}

.panel-list li {
	list-style: none;
	display: flex;
	gap: 12px;
	align-items: center;
	font-size: 18px;
	color: var(--about-muted);
}

.panel-list li span {
	font-size: 20px;
	flex-shrink: 0;
}

.about-section {
	padding: 96px 0;
	background: #fff;
}

.about-values {
	background: var(--about-surface);
}

.section-headline {
	max-width: 780px;
	margin: 0 auto 48px;
	text-align: center;
}

.section-headline h2 {
	font-size: 40px;
	font-weight: 700;
	color: var(--about-text);
	margin-bottom: 18px;
}

.section-headline p {
	font-size: 18px;
	line-height: 1.8;
	color: var(--about-muted);
	margin: 0;
}

.value-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
	gap: 24px;
}

.value-card {
	background: #fff;
	border-radius: 20px;
	padding: 34px;
	box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
	border: 1px solid rgba(44, 133, 223, 0.08);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease, background 0.3s ease;
}

.value-card:hover {
	transform: translateY(-8px);
	box-shadow: 0 32px 60px rgba(15, 23, 42, 0.14);
	border-color: rgba(9, 89, 171, 0.22);
	background: linear-gradient(160deg, #ffffff 0%, rgba(236, 245, 255, 0.92) 100%);
}

.value-card .value-icon {
	font-size: 38px;
	margin-bottom: 20px;
	color: var(--about-primary);
}

.value-card h3 {
	font-size: 22px;
	font-weight: 600;
	margin-bottom: 16px;
	color: var(--about-text);
}

.value-card p,
.value-card ul {
	font-size: 17px;
	line-height: 1.7;
	color: var(--about-muted);
	margin-bottom: 0;
}

.value-card ul {
	margin-top: 14px;
	padding-left: 18px;
}

.mission-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
	gap: 28px;
}

.mission-card {
	background: linear-gradient(160deg, #fff 0%, rgba(44, 133, 223, 0.12) 100%);
	padding: 38px;
	border-radius: 22px;
	border: 1px solid rgba(9, 89, 171, 0.18);
	box-shadow: 0 22px 44px rgba(9, 89, 171, 0.12);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease, background 0.3s ease;
}

.mission-card h3 {
	font-size: 26px;
	font-weight: 700;
	margin-bottom: 16px;
	color: var(--about-primary-dark);
}

.mission-card p,
.mission-card li {
	font-size: 18px;
	line-height: 1.8;
	color: var(--about-muted);
}

.mission-card ul {
	margin-top: 16px;
	padding-left: 20px;
}

.mission-card:hover {
	transform: translateY(-8px);
	box-shadow: 0 34px 68px rgba(9, 89, 171, 0.16);
	border-color: rgba(9, 89, 171, 0.35);
	background: linear-gradient(160deg, rgba(240, 248, 255, 1) 0%, rgba(203, 228, 255, 0.9) 100%);
}

.timeline-wrapper {
	max-width: 960px;
	margin: 0 auto;
}

.timeline-list {
	position: relative;
	padding-left: 26px;
	margin: 0;
	list-style: none;
}

.timeline-list::before {
	content: "";
	position: absolute;
	left: 12px;
	top: 4px;
	bottom: 4px;
	width: 2px;
	background: linear-gradient(180deg, rgba(44, 133, 223, 0.35) 0%, rgba(9, 89, 171, 0.6) 100%);
}

.timeline-item {
	position: relative;
	padding: 28px 30px;
	margin-bottom: 20px;
	background: var(--about-surface);
	border-radius: 18px;
	box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
	border: 1px solid rgba(44, 133, 223, 0.12);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease, background 0.3s ease;
}

.timeline-item::before {
	content: "";
	position: absolute;
	left: -20px;
	top: 32px;
	width: 14px;
	height: 14px;
	border-radius: 50%;
	border: 3px solid #fff;
	background: var(--about-primary);
	box-shadow: 0 0 0 4px rgba(44, 133, 223, 0.2);
}

.timeline-item h4 {
	font-size: 20px;
	font-weight: 700;
	color: var(--about-primary-dark);
	margin-bottom: 12px;
}

.timeline-item p {
	font-size: 17px;
	line-height: 1.7;
	color: var(--about-muted);
	margin: 0;
}

.timeline-item:hover {
	transform: translateY(-6px);
	box-shadow: 0 26px 56px rgba(15, 23, 42, 0.14);
	border-color: rgba(9, 89, 171, 0.28);
	background: #fff;
}

.about-cta {
	padding: 90px 0;
	background: linear-gradient(135deg, rgba(12, 37, 83, 0.98) 0%, rgba(9, 89, 171, 0.92) 55%, rgba(44, 133, 223, 0.88) 100%);
	text-align: center;
	color: #fff;
}

.about-cta .cta-box {
	max-width: 740px;
	margin: 0 auto;
	padding: 44px 40px;
	background: rgba(255, 255, 255, 0.06);
	border-radius: 26px;
	box-shadow: 0 22px 54px rgba(8, 47, 73, 0.3);
	backdrop-filter: blur(6px);
}

.about-cta h2 {
	font-size: 38px;
	font-weight: 700;
	margin-bottom: 20px;
}

.about-cta p {
	font-size: 19px;
	line-height: 1.8;
	margin-bottom: 30px;
	opacity: 0.94;
}

.about-cta .cta-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 18px;
}

.about-cta .about-button.primary {
	box-shadow: 0 18px 46px rgba(4, 16, 42, 0.3);
}

.about-cta .about-button.primary:hover {
	box-shadow: 0 26px 60px rgba(4, 16, 42, 0.34);
}

@media (max-width: 1200px) {
	.hero-grid {
		grid-template-columns: 1fr;
	}

	.hero-panel {
		order: -1;
	}
}

@media (max-width: 992px) {
	.hero-title {
		font-size: 42px;
	}

	.section-headline h2 {
		font-size: 34px;
	}

	.about-section {
		padding: 78px 0;
	}
}

@media (max-width: 768px) {
	.about-hero {
		padding: 100px 0 80px;
	}

	.about-badge {
		font-size: 16px;
	}

	.hero-title {
		font-size: 34px;
	}

	.hero-lead,
	.section-headline p,
	.value-card p,
	.timeline-item p,
	.about-cta p {
		font-size: 17px;
	}

	.hero-actions {
		flex-direction: column;
		align-items: stretch;
	}

	.about-button {
		width: 100%;
		justify-content: center;
	}
}

@media (max-width: 576px) {
	.metric-card {
		min-width: 100%;
	}

	.mission-card {
		padding: 28px;
	}

	.timeline-item {
		padding: 24px;
	}
}
</style>

<section class="about-hero">
	<div class="container">
		<div class="hero-grid">
			<div class="hero-text animate-box">
				<span class="about-badge">VN News</span>
				<h1 class="hero-title">Trang tin được thiết kế cho trải nghiệm đọc hiện đại</h1>
				<p class="hero-lead">
					Trang web tin tức của chúng tôi được xây dựng nhằm mang đến cho độc giả nguồn thông tin nhanh chóng, chính xác và đa chiều.
					Với giao diện trực quan, dễ sử dụng cùng hệ thống phân loại bài viết theo từng lĩnh vực như thời sự, công nghệ, kinh tế,
					giải trí và đời sống, VN News giúp bạn tiếp cận những diễn biến mới nhất trong nước và quốc tế chỉ trong vài thao tác đơn giản.
					<strong>Đội ngũ biên tập viên chuyên nghiệp</strong> luôn cập nhật liên tục, bảo đảm mọi nội dung đều được kiểm chứng kỹ lưỡng
					và trình bày rõ ràng, giúp độc giả nắm bắt thông tin một cách thuận tiện và tin cậy.
				</p>
				<div class="hero-actions">
					<a class="about-button primary" href="{{ route('categories.index') }}">Khám phá chuyên mục</a>
					<a class="about-button ghost" href="{{ route('contact.create') }}">Liên hệ tòa soạn</a>
				</div>
				<div class="hero-metrics">
					<div class="metric-card">
						<strong>50+</strong>
						<span>Nguồn tin đối tác đáng tin cậy</span>
					</div>
					<div class="metric-card">
						<strong>24/7</strong>
						<span>Cập nhật theo thời gian thực</span>
					</div>
					<div class="metric-card">
						<strong>100%</strong>
						<span>Nội dung được kiểm chứng</span>
					</div>
				</div>
			</div>
			<div class="hero-panel animate-box">
				<h3>Chúng tôi đáp ứng kỳ vọng của độc giả hiện đại</h3>
				<ul class="panel-list">
					<li><span>📱</span>Dễ dàng theo dõi trên mọi thiết bị, từ di động đến desktop</li>
					<li><span>⚡</span>Tốc độ tải trang tối ưu giúp nội dung hiển thị mượt mà</li>
					<li><span>🔎</span>Lọc bài viết thông minh theo chủ đề bạn quan tâm</li>
					<li><span>🗞️</span>Bản tin tổng hợp gọn gàng, ưu tiên những tin nổi bật nhất</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="about-section about-values">
	<div class="container">
		<div class="section-headline animate-box">
			<h2>Các giá trị định hình VN News</h2>
			<p>Chúng tôi nghiên cứu hành vi đọc tin hằng ngày để kiến tạo trải nghiệm liền mạch, giúp bạn tiếp thu thông tin sâu sắc và tự tin chia sẻ lại cho cộng đồng.</p>
		</div>
		<div class="value-grid">
			<div class="value-card animate-box">
				<div class="value-icon">🧭</div>
				<h3>Điều hướng rõ ràng</h3>
				<p>Thanh điều hướng được tối ưu theo thói quen đọc, cho phép truy cập nhanh tới chuyên mục ưa thích hoặc tìm kiếm theo từ khóa chỉ với một lần chạm.</p>
			</div>
			<div class="value-card animate-box">
				<div class="value-icon">🧠</div>
				<h3>Nội dung chiều sâu</h3>
				<p>Đội ngũ biên tập cân bằng giữa tốc độ và chất lượng, kết hợp phân tích số liệu để đưa ra góc nhìn đa chiều về từng sự kiện.</p>
			</div>
			<div class="value-card animate-box">
				<div class="value-icon">🎯</div>
				<h3>Trải nghiệm cá nhân hóa</h3>
				<p>Hệ thống gợi ý thông minh ưu tiên tin theo chủ đề bạn theo dõi thường xuyên, giúp bản tin hàng ngày luôn sát với nhu cầu.</p>
			</div>
			<div class="value-card animate-box">
				<div class="value-icon">🤝</div>
				<h3>Bảo mật & minh bạch</h3>
				<p>Chính sách dữ liệu rõ ràng, tôn trọng quyền riêng tư và minh bạch nguồn trích dẫn, bảo đảm sự tin cậy trong từng bài viết.</p>
			</div>
		</div>
	</div>
</section>

<section class="about-section">
	<div class="container">
		<div class="section-headline animate-box">
			<h2>Định hướng phát triển</h2>
			<p>VN News đặt người đọc làm trung tâm, liên tục cải tiến quy trình và công nghệ để mang tới trải nghiệm đọc tin bền vững, thân thiện và đáng tin cậy.</p>
		</div>
		<div class="mission-grid">
			<div class="mission-card animate-box">
				<h3>Sứ mệnh</h3>
				<p>Trở thành người bạn đồng hành đáng tin cậy, giúp cộng đồng cập nhật diễn biến mới nhất và hiểu rõ bối cảnh của từng câu chuyện.</p>
				<ul>
					<li>Chuyển tải thông tin chính xác, dễ hiểu, kịp thời</li>
					<li>Tăng cường kiến thức xã hội qua các chuyên đề chuyên sâu</li>
					<li>Khuyến khích góc nhìn đa dạng, tôn trọng sự thật</li>
				</ul>
			</div>
			<div class="mission-card animate-box">
				<h3>Tầm nhìn</h3>
				<p>Xây dựng hệ sinh thái tin tức số với trải nghiệm liền mạch, cá nhân hóa và linh hoạt cho mọi nhóm độc giả.</p>
				<ul>
					<li>Áp dụng phân tích dữ liệu để hiểu nhu cầu người đọc</li>
					<li>Phát triển các định dạng nội dung mới phù hợp đa nền tảng</li>
					<li>Kết nối độc giả với chuyên gia để mở rộng góc nhìn</li>
				</ul>
			</div>
			<div class="mission-card animate-box">
				<h3>Chuẩn biên tập</h3>
				<p>Mỗi bài viết được kiểm chứng kỹ lưỡng, đảm bảo nguồn gốc minh bạch và tuân thủ đạo đức báo chí.</p>
				<ul>
					<li>Biên tập viên xác thực tối thiểu hai nguồn độc lập</li>
					<li>Thông tin nhạy cảm được rà soát pháp lý trước khi xuất bản</li>
					<li>Độc giả có kênh phản hồi trực tiếp để bổ sung dữ kiện</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="about-section about-timeline">
	<div class="container">
		<div class="section-headline animate-box">
			<h2>Quy trình xuất bản tin</h2>
			<p>Chuỗi kiểm chứng nhiều lớp giúp VN News phát hành nội dung nhanh nhưng vẫn đảm bảo độ chính xác và tính minh bạch.</p>
		</div>
		<div class="timeline-wrapper">
			<ol class="timeline-list">
				<li class="timeline-item animate-box">
					<h4>Thu thập đa nguồn</h4>
					<p>Phối hợp với phóng viên hiện trường, cơ quan chức năng và các hãng thông tấn quốc tế để tổng hợp dữ liệu đa chiều.</p>
				</li>
				<li class="timeline-item animate-box">
					<h4>Phân tích & xác thực</h4>
					<p>Đội ngũ chuyên trách kiểm tra chéo nguồn tin, so sánh bối cảnh và loại bỏ sai lệch trước khi chuyển cho biên tập.</p>
				</li>
				<li class="timeline-item animate-box">
					<h4>Biên tập trực quan</h4>
					<p>Biên tập viên trình bày lại câu chuyện với ngôn ngữ rõ ràng, chèn đồ họa, trích dẫn và đường dẫn tham khảo cần thiết.</p>
				</li>
				<li class="timeline-item animate-box">
					<h4>Phát hành & phản hồi</h4>
					<p>Nội dung được xuất bản đồng thời trên web và bản tin email; đội ngũ theo dõi phản hồi để cập nhật nếu có dữ kiện mới.</p>
				</li>
			</ol>
		</div>
	</div>
</section>

<section class="about-cta">
	<div class="container">
		<div class="cta-box animate-box">
			<h2>Đồng hành cùng VN News mỗi ngày</h2>
			<p>Khám phá kho nội dung phong phú, cập nhật tin nóng và nhận bản tin chuyên sâu được thiết kế dành riêng cho bạn.</p>
			<div class="cta-actions">
				<a class="about-button primary" href="{{ route('home') }}">Truy cập trang chủ</a>
				<a class="about-button ghost" href="{{ route('newPost') }}">Xem tin mới nhất</a>
			</div>
		</div>
	</div>
</section>

@endsection