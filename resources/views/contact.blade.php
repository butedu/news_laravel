@extends('main_layouts.master')

@section('title',' VN News - Liên hệ')

@section('content')
<style>
:root {
	--contact-primary: #2c85df;
	--contact-primary-dark: #0959ab;
	--contact-navy: #0c2553;
	--contact-muted: #4b5563;
	--contact-soft: #f4f6fb;
	--contact-border: rgba(15, 23, 42, 0.12);
}

.global-message {
	max-width: 1120px;
	margin: 0 auto 24px;
	padding: 16px 20px;
	border-radius: 14px;
	box-shadow: 0 16px 32px rgba(12, 37, 83, 0.08);
	background: rgba(44, 133, 223, 0.1);
	color: var(--contact-navy);
	border: 1px solid rgba(44, 133, 223, 0.3);
	font-weight: 500;
}

.contact-hero {
	position: relative;
	padding: 140px 0 110px;
	background: linear-gradient(135deg, rgba(12, 37, 83, 0.98) 0%, rgba(9, 89, 171, 0.92) 50%, rgba(44, 133, 223, 0.86) 100%);
	color: #fff;
	overflow: hidden;
}

.contact-hero::before,
.contact-hero::after {
	content: "";
	position: absolute;
	border-radius: 50%;
	opacity: 0.22;
}

.contact-hero::before {
	width: 380px;
	height: 380px;
	background: radial-gradient(circle, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0) 70%);
	top: -160px;
	right: -120px;
}

.contact-hero::after {
	width: 320px;
	height: 320px;
	background: radial-gradient(circle, rgba(12, 74, 165, 0.7) 0%, rgba(12, 74, 165, 0) 70%);
	bottom: -140px;
	left: -120px;
}

.contact-hero .container {
	position: relative;
	z-index: 1;
}

.contact-hero__grid {
	display: grid;
	grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
	gap: 48px;
	align-items: center;
}

.contact-badge {
	display: inline-flex;
	align-items: center;
	gap: 10px;
	padding: 10px 20px;
	border-radius: 999px;
	background: rgba(255, 255, 255, 0.16);
	font-size: 16px;
	font-weight: 600;
	letter-spacing: 1.5px;
	text-transform: uppercase;
	margin-bottom: 26px;
}

.contact-hero__title {
	font-size: 50px;
	line-height: 1.2;
	font-weight: 700;
	margin-bottom: 24px;
	text-shadow: 0 8px 26px rgba(0, 0, 0, 0.3);
}

.contact-hero__lead {
	font-size: 19px;
	line-height: 1.9;
	color: rgba(255, 255, 255, 0.9);
	margin-bottom: 34px;
	text-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
}

.contact-hero__actions {
	display: flex;
	flex-wrap: wrap;
	gap: 16px;
	margin-bottom: 42px;
}

.contact-hero__link {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	padding: 14px 28px;
	border-radius: 999px;
	font-size: 17px;
	font-weight: 600;
	text-decoration: none;
	color: var(--contact-primary-dark);
	background: #fff;
	box-shadow: 0 18px 44px rgba(8, 29, 64, 0.22);
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-hero__link:hover {
	transform: translateY(-4px);
	box-shadow: 0 24px 58px rgba(8, 29, 64, 0.28);
}

.contact-hero__link--ghost {
	background: transparent;
	color: #fff;
	border: 2px solid rgba(255, 255, 255, 0.5);
	box-shadow: none;
}

.contact-hero__link--ghost:hover {
	background: rgba(255, 255, 255, 0.18);
	transform: translateY(-4px);
}

.contact-hero__stats {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
	gap: 18px;
}

.contact-stat-card {
	background: rgba(255, 255, 255, 0.12);
	border: 1px solid rgba(255, 255, 255, 0.18);
	border-radius: 22px;
	padding: 28px;
	backdrop-filter: blur(6px);
	box-shadow: 0 24px 50px rgba(7, 27, 60, 0.22);
	transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
}

.contact-stat-card:hover {
	transform: translateY(-6px);
	box-shadow: 0 30px 62px rgba(7, 27, 60, 0.26);
	background: rgba(255, 255, 255, 0.2);
}

.contact-stat-card strong {
	display: block;
	font-size: 34px;
	font-weight: 700;
	margin-bottom: 6px;
}

.contact-stat-card span {
	display: block;
	font-size: 17px;
	color: rgba(255, 255, 255, 0.86);
}

.contact-section {
	padding: 96px 0;
	background: #fff;
}

.contact-details {
	background: var(--contact-soft);
}

.section-headline {
	max-width: 760px;
	margin: 0 auto 48px;
	text-align: center;
}

.section-headline h2 {
	font-size: 38px;
	font-weight: 700;
	color: var(--contact-navy);
	margin-bottom: 18px;
}

.section-headline p {
	font-size: 18px;
	line-height: 1.8;
	color: var(--contact-muted);
}

.contact-card-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
	gap: 24px;
}

.contact-card {
	background: #fff;
	border-radius: 20px;
	padding: 32px;
	box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
	border: 1px solid rgba(44, 133, 223, 0.06);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
}

.contact-card:hover {
	transform: translateY(-6px);
	box-shadow: 0 28px 58px rgba(15, 23, 42, 0.14);
	border-color: rgba(44, 133, 223, 0.24);
}

.contact-card__icon {
	width: 54px;
	height: 54px;
	border-radius: 16px;
	background: rgba(44, 133, 223, 0.14);
	color: var(--contact-primary-dark);
	display: grid;
	place-items: center;
	font-size: 22px;
	margin-bottom: 20px;
	box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
}

.contact-card h3 {
	font-size: 22px;
	font-weight: 600;
	color: var(--contact-navy);
	margin-bottom: 12px;
}

.contact-card p {
	margin: 0;
	font-size: 17px;
	line-height: 1.7;
	color: var(--contact-muted);
}

.contact-card a {
	color: var(--contact-primary-dark);
	font-weight: 600;
	text-decoration: none;
	transition: color 0.3s ease;
}

.contact-card a:hover {
	color: var(--contact-primary);
}

.contact-main-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
	gap: 40px;
}

.contact-form {
	background: #fff;
	border-radius: 26px;
	padding: 40px;
	box-shadow: 0 26px 60px rgba(15, 23, 42, 0.08);
	border: 1px solid rgba(44, 133, 223, 0.08);
}

.contact-form h3 {
	font-size: 30px;
	font-weight: 700;
	color: var(--contact-navy);
	margin-bottom: 12px;
}

.contact-form p {
	font-size: 17px;
	line-height: 1.7;
	color: var(--contact-muted);
	margin-bottom: 30px;
}

.contact-form__grid {
	display: grid;
	grid-template-columns: repeat(2, minmax(0, 1fr));
	gap: 20px;
}

.contact-field {
	display: flex;
	flex-direction: column;
}

.contact-field--full {
	grid-column: 1 / -1;
}

.contact-form .form-control {
	background: #f8fafc;
	border: 1px solid rgba(15, 23, 42, 0.12);
	border-radius: 14px;
	padding: 16px 18px;
	font-size: 17px;
	color: var(--contact-navy);
	transition: border 0.25s ease, box-shadow 0.25s ease;
}

.contact-form .form-control:focus {
	border-color: rgba(44, 133, 223, 0.6);
	box-shadow: 0 0 0 4px rgba(44, 133, 223, 0.15);
}

.contact-form small.error {
	margin-top: 8px;
	font-size: 14px;
}

.contact-form .send-message-btn {
	width: 100%;
	margin-top: 10px;
	border: none;
	border-radius: 999px;
	padding: 16px 28px;
	font-size: 18px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 1px;
	background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
	color: #fff;
	box-shadow: 0 24px 54px rgba(9, 89, 171, 0.24);
	transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
}

.contact-form .send-message-btn:hover {
	transform: translateY(-4px);
	box-shadow: 0 30px 64px rgba(9, 89, 171, 0.3);
	opacity: 0.95;
}

.contact-aside {
	display: flex;
	flex-direction: column;
	gap: 24px;
}


.contact-aside-card {
	background: linear-gradient(160deg, #ffffff 0%, rgba(240, 246, 255, 0.92) 100%);
	color: var(--contact-navy);
	border-radius: 24px;
	padding: 36px;
	box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08);
	border: 1px solid rgba(44, 133, 223, 0.12);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
}

.contact-aside-card--support {
	border-left: 6px solid var(--contact-primary);
	box-shadow: 0 28px 56px rgba(44, 133, 223, 0.16);
}

.contact-aside-card--cta {
	background: linear-gradient(155deg, rgba(12, 37, 83, 0.96) 0%, rgba(9, 89, 171, 0.9) 100%);
	color: #fff;
	border-left: none;
	border: 1px solid rgba(44, 133, 223, 0.28);
	box-shadow: 0 30px 64px rgba(6, 26, 60, 0.28);
}

.contact-aside-card:hover {
	transform: translateY(-6px);
	box-shadow: 0 32px 64px rgba(15, 23, 42, 0.14);
	border-color: rgba(44, 133, 223, 0.2);
}

.contact-aside-card--cta:hover {
	box-shadow: 0 38px 74px rgba(6, 26, 60, 0.34);
	border-color: rgba(44, 133, 223, 0.38);
}

.contact-aside-card h4 {
	font-size: 24px;
	font-weight: 700;
	margin-bottom: 14px;
	color: var(--contact-primary-dark);
}

.contact-aside-card--cta h4 {
	color: #fff;
}

.contact-aside-card p,
.contact-aside-card li {
	font-size: 17px;
	line-height: 1.7;
	color: var(--contact-muted);
}

.contact-aside-card--cta p,
.contact-aside-card--cta li {
	color: rgba(255, 255, 255, 0.9);
}

.contact-aside-card a {
	color: var(--contact-primary-dark);
	text-decoration: none;
	font-weight: 600;
	transition: color 0.3s ease;
}

.contact-aside-card a:hover {
	color: var(--contact-primary);
}

.contact-aside-card--cta a {
	color: #fff;
}

.contact-aside-card--cta a:hover {
	color: #f8fafc;
}

.contact-aside-list {
	margin: 0 0 18px;
	padding-left: 18px;
}

.contact-aside-list li:not(:last-child) {
	margin-bottom: 8px;
}

.contact-aside__link {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	padding: 12px 18px;
	border-radius: 14px;
	font-weight: 600;
	text-decoration: none;
	transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
}

.contact-aside__link--outline {
	background: rgba(44, 133, 223, 0.08);
	border: 2px solid rgba(44, 133, 223, 0.18);
	color: var(--contact-primary-dark);
	box-shadow: 0 14px 28px rgba(44, 133, 223, 0.12);
}

.contact-aside__link--outline:hover {
	background: rgba(44, 133, 223, 0.16);
	box-shadow: 0 20px 40px rgba(44, 133, 223, 0.16);
	transform: translateY(-3px);
}

.contact-aside__link--filled {
	background: rgba(255, 255, 255, 0.18);
	border: 2px solid rgba(255, 255, 255, 0.32);
	color: #fff;
	box-shadow: 0 18px 42px rgba(4, 16, 42, 0.26);
}

.contact-aside__link--filled:hover {
	background: rgba(255, 255, 255, 0.28);
	box-shadow: 0 24px 50px rgba(4, 16, 42, 0.3);
	transform: translateY(-3px);
}

.contact-faq {
	background: #fff;
}

.contact-faq-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
	gap: 24px;
}

.contact-faq-item {
	background: var(--contact-soft);
	border-radius: 20px;
	padding: 28px;
	box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
	border: 1px solid rgba(44, 133, 223, 0.1);
	transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
}

.contact-faq-item:hover {
	transform: translateY(-6px);
	box-shadow: 0 26px 58px rgba(15, 23, 42, 0.12);
	border-color: rgba(44, 133, 223, 0.2);
}

.contact-faq-item h4 {
	font-size: 20px;
	font-weight: 600;
	color: var(--contact-navy);
	margin-bottom: 12px;
}

.contact-faq-item p {
	margin: 0;
	font-size: 16px;
	line-height: 1.7;
	color: var(--contact-muted);
}

.contact-cta {
	padding: 90px 0;
	background: linear-gradient(135deg, rgba(12, 37, 83, 0.95) 0%, rgba(9, 89, 171, 0.85) 60%, rgba(44, 133, 223, 0.85) 100%);
	color: #fff;
	text-align: center;
}

.contact-cta .cta-box {
	max-width: 720px;
	margin: 0 auto;
	padding: 44px 40px;
	background: rgba(255, 255, 255, 0.1);
	border-radius: 26px;
	box-shadow: 0 28px 64px rgba(8, 29, 64, 0.3);
	backdrop-filter: blur(6px);
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-cta .cta-box:hover {
	transform: translateY(-6px);
	box-shadow: 0 34px 74px rgba(8, 29, 64, 0.34);
}

.contact-cta h2 {
	font-size: 36px;
	font-weight: 700;
	margin-bottom: 18px;
}

.contact-cta p {
	font-size: 18px;
	line-height: 1.8;
	margin-bottom: 28px;
	color: rgba(255, 255, 255, 0.92);
}

.contact-cta .cta-actions {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: 16px;
}

.contact-cta .cta-button {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 8px;
	padding: 14px 28px;
	border-radius: 999px;
	font-size: 17px;
	font-weight: 600;
	text-decoration: none;
	background: #fff;
	color: var(--contact-primary-dark);
	box-shadow: 0 20px 48px rgba(4, 16, 42, 0.24);
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-cta .cta-button:hover {
	transform: translateY(-4px);
	box-shadow: 0 26px 60px rgba(4, 16, 42, 0.3);
}

.contact-cta .cta-button.ghost {
	background: transparent;
	color: #fff;
	border: 2px solid rgba(255, 255, 255, 0.5);
	box-shadow: none;
}

.contact-cta .cta-button.ghost:hover {
	background: rgba(255, 255, 255, 0.16);
}

@media (max-width: 1200px) {
	.contact-hero__grid {
		grid-template-columns: 1fr;
	}

	.contact-hero__stats {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.contact-stat-card {
		background: rgba(255, 255, 255, 0.16);
	}

	.contact-main-grid {
		grid-template-columns: 1fr;
	}
}

@media (max-width: 992px) {
	.contact-hero {
		padding: 120px 0 90px;
	}

	.contact-hero__title {
		font-size: 42px;
	}

	.section-headline h2 {
		font-size: 32px;
	}

	.contact-form {
		padding: 34px;
	}
}

@media (max-width: 768px) {
	.contact-hero__actions,
	.contact-cta .cta-actions {
		flex-direction: column;
		align-items: stretch;
	}

	.contact-hero__link,
	.contact-cta .cta-button {
		width: 100%;
	}

	.contact-form__grid {
		grid-template-columns: 1fr;
	}

	.contact-hero__title {
		font-size: 36px;
	}

	.contact-hero__lead,
	.section-headline p {
		font-size: 17px;
	}
}

@media (max-width: 576px) {
	.contact-card,
	.contact-faq-item {
		padding: 26px;
	}

	.contact-form {
		padding: 28px;
	}

	.contact-form .send-message-btn {
		font-size: 17px;
	}
}
</style>

<div class="global-message info d-none"></div>

<section class="contact-hero">
	<div class="container">
		<div class="contact-hero__grid">
			<div class="contact-hero__content animate-box">
				<span class="contact-badge">Kết nối nhanh</span>
				<h1 class="contact-hero__title">Liên hệ với đội ngũ VN News</h1>
				<p class="contact-hero__lead">Chúng tôi luôn sẵn sàng đồng hành, lắng nghe mọi phản hồi về trải nghiệm đọc báo, vấn đề kỹ thuật hoặc hợp tác nội dung. Hãy gửi thông điệp, đội ngũ VN News sẽ phản hồi trong vòng 24 giờ làm việc.</p>
				<div class="contact-hero__actions">
					<a class="contact-hero__link" href="{{ route('home') }}">Về trang chủ</a>
					<a class="contact-hero__link contact-hero__link--ghost" href="{{ route('categories.index') }}">Khám phá chuyên mục</a>
				</div>
			</div>
			<div class="contact-hero__stats animate-box">
				<div class="contact-stat-card">
					<strong>24h</strong>
					<span>Thời gian phản hồi trung bình</span>
				</div>
				<div class="contact-stat-card">
					<strong>7 ngày/tuần</strong>
					<span>Trực hỗ trợ nội dung & kỹ thuật</span>
				</div>
				<div class="contact-stat-card">
					<strong>98%</strong>
					<span>Độc giả đánh giá hài lòng</span>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="contact-section contact-details">
	<div class="container">
		<div class="section-headline animate-box">
			<h2>Thông tin kết nối trực tiếp</h2>
			<p>Dành cho độc giả, đối tác và báo chí. Vui lòng lựa chọn kênh tương ứng để chúng tôi hỗ trợ bạn nhanh nhất.</p>
		</div>
		<div class="contact-card-grid">
			<div class="contact-card animate-box">
				<div class="contact-card__icon"><i class="icon-location-2"></i></div>
				<h3>Văn phòng</h3>
				<p>140 Lê Trọng Tấn, Tân Phú, TP. Hồ Chí Minh<br/>Tầng 6, Tòa nhà VN News Hub</p>
			</div>
			<div class="contact-card animate-box">
				<div class="contact-card__icon"><i class="icon-phone3"></i></div>
				<h3>Hotline độc giả</h3>
				<p><a href="tel:+84796177075">(+84) 796 177 075</a><br/>Từ 8:00 - 22:00 (T2 - CN)</p>
			</div>
			<div class="contact-card animate-box">
				<div class="contact-card__icon"><i class="icon-paperplane"></i></div>
				<h3>Email biên tập</h3>
				<p><a href="mailto:mbf2907.ntkh@gmail.com">mbf2907.ntkh@gmail.com</a><br/>ưu tiên góp ý nội dung & hợp tác</p>
			</div>
			<div class="contact-card animate-box">
				<div class="contact-card__icon"><i class="icon-clock2"></i></div>
				<h3>Giờ làm việc</h3>
				<p>Thứ 2 - Thứ 6: 08:00 - 18:00<br/>Thứ 7: 09:00 - 17:00</p>
			</div>
		</div>
	</div>
</section>

<section class="contact-section">
	<div class="container">
		<div class="contact-main-grid">
			<div class="contact-form animate-box">
				<h3>Gửi thông điệp cho VN News</h3>
				<p>Bạn có thể gửi ngay yêu cầu qua biểu mẫu dưới đây. Chúng tôi sẽ ghi nhận và phản hồi theo kênh bạn đã cung cấp.</p>
				<form onsubmit="return false;" autocomplete="off" method="POST" class="contact-form__fields">
					@csrf
					<div class="contact-form__grid">
						<div class="contact-field">
							<x-blog.form.input value='{{ old("first_name")}}' placeholder="Họ của bạn" name="first_name"/>
							<small class="error text-danger first_name"></small>
						</div>
						<div class="contact-field">
							<x-blog.form.input value='{{ old("last_name")}}'  placeholder="Tên của bạn"  name="last_name"/>
							<small class="error text-danger last_name"></small>
						</div>
						<div class="contact-field contact-field--full">
							<x-blog.form.input value='{{ old("email")}}'  type="email" placeholder="Địa chỉ Email" name="email"/>
							<small class="error text-danger email"></small>
						</div>
						<div class="contact-field contact-field--full">
							<x-blog.form.input value='{{ old("subject")}}' placeholder="Tiêu đề"  name="subject"/>
							<small class="error text-danger subject"></small>
						</div>
						<div class="contact-field contact-field--full">
							<x-blog.form.textarea value='{{ old("message")}}'  placeholder="Nội dung bạn muốn chia sẻ"  name="message"/>
							<small class="error text-danger message"></small>
						</div>
					</div>
					<input type="submit" value="Gửi đi" class="send-message-btn">
				</form>
				<x-blog.message :status="'success'" />
			</div>
			<div class="contact-aside animate-box">
				<div class="contact-aside-card contact-aside-card--support">
					<h4>Ưu tiên hỗ trợ nhanh</h4>
					<p>Nếu bạn gặp sự cố khẩn hoặc vấn đề bảo mật, hãy gọi trực tiếp để được hỗ trợ ưu tiên.</p>
					<ul class="contact-aside-list">
						<li>Hotline bảo mật: <a href="tel:+84812345678">(+84) 81 234 5678</a></li>
						<li>Hỗ trợ đối tác quảng cáo: <a href="mailto:ads@vnnews.vn">ads@vnnews.vn</a></li>
						<li>Phản hồi trải nghiệm: <a href="mailto:feedback@vnnews.vn">feedback@vnnews.vn</a></li>
					</ul>
					<a class="contact-aside__link contact-aside__link--outline" href="{{ route('about') }}">Tìm hiểu về VN News</a>
				</div>
				<div class="contact-aside-card contact-aside-card--cta">
					<p>Đặt lịch làm việc trực tiếp với đội ngũ VN News để cùng thảo luận và xây dựng giải pháp nội dung hoặc quảng cáo.</p>
					<a class="contact-aside__link contact-aside__link--filled" href="mailto:meet@vnnews.vn">Gửi yêu cầu lịch hẹn</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="contact-section contact-faq">
	<div class="container">
		<div class="section-headline animate-box">
			<h2>Câu hỏi thường gặp</h2>
			<p>Nếu câu hỏi của bạn nằm trong danh sách này, chúng tôi đã chuẩn bị sẵn câu trả lời để bạn có thể xử lý ngay.</p>
		</div>
		<div class="contact-faq-grid">
			<div class="contact-faq-item animate-box">
				<h4>Làm sao cập nhật thông tin tài khoản?</h4>
				<p>Hãy đăng nhập, truy cập mục Hồ sơ cá nhân và điều chỉnh thông tin. Nếu cần hỗ trợ, gửi biểu mẫu kèm chi tiết nội dung cần chỉnh sửa.</p>
			</div>
			<div class="contact-faq-item animate-box">
				<h4>Tôi muốn cộng tác nội dung</h4>
				<p>Gửi email tới <a href="mailto:editor@vnnews.vn">editor@vnnews.vn</a> với hồ sơ và lĩnh vực chuyên môn. Biên tập viên phụ trách sẽ phản hồi trong 2 ngày làm việc.</p>
			</div>
			<div class="contact-faq-item animate-box">
				<h4>Làm sao báo cáo lỗi kỹ thuật?</h4>
				<p>Sử dụng biểu mẫu trên hoặc liên hệ hotline trong giờ hành chính. Cung cấp loại thiết bị, trình duyệt và bước thao tác, chúng tôi sẽ khắc phục trong thời gian sớm nhất.</p>
			</div>
		</div>
	</div>
</section>

<section class="contact-cta">
	<div class="container">
		<div class="cta-box animate-box">
			<h2>Cùng xây dựng trải nghiệm đọc tốt hơn</h2>
			<p>VN News lắng nghe mọi ý kiến để cải tiến sản phẩm. Đừng ngần ngại chia sẻ cảm nhận của bạn, chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
			<div class="cta-actions">
				<a class="cta-button" href="{{ route('newPost') }}">Xem tin mới nhất</a>
				<a class="cta-button ghost" href="{{ route('contact.create') }}">Gửi góp ý thêm</a>
			</div>
		</div>
	</div>
</section>
@endsection

@section('custom_js')

<script>
	$(document).on('click', '.send-message-btn', (e) => {
		e.preventDefault();

		let $this = e.target;

		let csrf_token = $($this).parents("form").find("input[name='_token']").val();
		let first_name =  $($this).parents("form").find("input[name='first_name']").val();
		let last_name =  $($this).parents("form").find("input[name='last_name']").val();
		let email =  $($this).parents("form").find("input[name='email']").val();
		let subject =  $($this).parents("form").find("input[name='subject']").val();
		let message =  $($this).parents("form").find("textarea[name='message']").val();

		
		let formData = new FormData();
		formData.append('_token', csrf_token);
		formData.append('first_name', first_name);
		formData.append('last_name', last_name);
		formData.append('email', email);
		formData.append('subject', subject);
		formData.append('message', message);

		console.log(csrf_token);

		$.ajax({
			url: "{{ route('contact.store') }}",
			data: formData,
			type: 'POST',
			dataType: 'JSON',
			processData: false,
			contentType: false,
			success: function (data) {
				if(data.success){
					$('.global-message').addClass('alert alert-info');
					$('.global-message').fadeIn();
					$('.global-message').text(data.message);

					clearData( $($this).parents("form"), [
						'first_name', 'last_name', 'email', 'subject', 'message'
					]);

					setTimeout(() => {
						$(".global-message").fadeOut();
					}, 7000)
				}else{
					for ( const error in data.errors ){
						$("small."+error).text(data.errors[error]);
					}
				}
			}
		})
	})
</script>

@endsection