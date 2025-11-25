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
	padding: 18px 22px;
	border-radius: 18px;
	box-shadow: 0 18px 44px rgba(9, 30, 66, 0.12);
	background: #ffffff;
	color: var(--contact-navy);
	border-left: 6px solid var(--contact-primary);
	font-weight: 600;
	display: flex;
	align-items: center;
	gap: 14px;
	font-size: 16px;
	line-height: 1.6;
	transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.3s ease;
}

.global-message:not(.d-none) {
	transform: translateY(0);
}

.global-message--success {
	border-left-color: #0f9d58;
	background: linear-gradient(135deg, rgba(15, 157, 88, 0.12) 0%, rgba(44, 133, 223, 0.05) 100%);
	color: #0c5132;
}

.global-message--error {
	border-left-color: #d93025;
	background: linear-gradient(135deg, rgba(217, 48, 37, 0.12) 0%, rgba(255, 238, 238, 0.7) 100%);
	color: #7f1d1d;
}

.global-message--info {
	border-left-color: var(--contact-primary-dark);
	background: linear-gradient(135deg, rgba(9, 89, 171, 0.15) 0%, rgba(44, 133, 223, 0.05) 100%);
	color: var(--contact-navy);
}

.global-message__icon {
	width: 48px;
	height: 48px;
	border-radius: 16px;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	background: rgba(44, 133, 223, 0.16);
	color: var(--contact-primary-dark);
	box-shadow: 0 14px 32px rgba(9, 30, 66, 0.12);
	flex-shrink: 0;
}

.global-message__icon svg {
	width: 22px;
	height: 22px;
}

.global-message--success .global-message__icon {
	background: rgba(15, 157, 88, 0.18);
	color: #0f9d58;
}

.global-message--error .global-message__icon {
	background: rgba(217, 48, 37, 0.2);
	color: #d93025;
}

.global-message--info .global-message__icon {
	background: rgba(9, 89, 171, 0.22);
	color: var(--contact-primary-dark);
}

.global-message__spinner {
	width: 20px;
	height: 20px;
	border-radius: 50%;
	border: 2px solid rgba(9, 89, 171, 0.28);
	border-top-color: var(--contact-primary-dark);
	animation: contact-spin 0.8s linear infinite;
}

.global-message__content {
	display: flex;
	flex-direction: column;
	gap: 4px;
	line-height: 1.5;
}

.global-message__heading {
	font-size: 15px;
	font-weight: 700;
	color: inherit;
	letter-spacing: 0.3px;
}

.global-message__text {
	margin: 0;
	font-size: 15px;
	font-weight: 500;
	color: inherit;
}

.global-message--error .global-message__text {
	color: #7f1d1d;
}

.global-message--success .global-message__text {
	color: #0c5132;
}

.global-message--info .global-message__text {
	color: var(--contact-navy);
}

.global-message--success .global-message__heading {
	color: #0b7041;
}

.global-message--error .global-message__heading {
	color: #a01919;
}

.global-message--info .global-message__heading {
	color: var(--contact-primary-dark);
}

.visually-hidden {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border: 0;
}
.contact-uploader {
	position: relative;
	display: flex;
	align-items: center;
	gap: 18px;
	padding: 18px 22px;
	border-radius: 18px;
	background: #f8fbff;
	border: 1px dashed rgba(44, 133, 223, 0.35);
	cursor: pointer;
	transition: border 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.contact-uploader:hover,
.contact-uploader:focus-within,
.contact-uploader.is-active {
	border-color: var(--contact-primary);
	background: rgba(44, 133, 223, 0.12);
	box-shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
}

.contact-uploader__icon {
	width: 58px;
	height: 58px;
	border-radius: 16px;
	background: rgba(9, 89, 171, 0.14);
	display: grid;
	place-items: center;
	color: var(--contact-primary-dark);
	font-size: 24px;
}

.contact-uploader__icon svg {
	width: 28px;
	height: 28px;
}

.contact-uploader__content {
	flex: 1;
}

.contact-uploader__title {
	margin: 0;
	font-weight: 600;
	color: var(--contact-navy);
	font-size: 16px;
}

.contact-uploader__subtitle {
	margin: 4px 0 0;
	font-size: 14px;
	color: var(--contact-muted);
}

.contact-uploader__subtitle span {
	color: var(--contact-primary-dark);
	font-weight: 600;
}

.contact-uploader__button {
	border: none;
	background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
	color: #ffffff;
	font-weight: 600;
	border-radius: 999px;
	padding: 10px 18px;
	font-size: 14px;
	cursor: pointer;
	transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.contact-uploader__button:hover {
	transform: translateY(-2px);
	box-shadow: 0 12px 22px rgba(9, 89, 171, 0.22);
}

.contact-uploader__input {
	position: absolute;
	inset: 0;
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	z-index: -1;
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
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 12px;
	cursor: pointer;
	position: relative;
}

.contact-form .send-message-btn:disabled {
	opacity: 0.9;
	cursor: not-allowed;
}

.contact-form .send-message-btn .btn-label {
	transition: opacity 0.2s ease;
}

.contact-form .send-message-btn .btn-spinner {
	width: 18px;
	height: 18px;
	border-radius: 50%;
	border: 2px solid rgba(255, 255, 255, 0.4);
	border-top-color: #fff;
	animation: contact-spin 0.8s linear infinite;
	opacity: 0;
	transform: scale(0.8);
	transition: opacity 0.2s ease, transform 0.2s ease;
}

.contact-form .send-message-btn.is-loading {
	opacity: 0.95;
}

.contact-form .send-message-btn.is-loading .btn-spinner {
	opacity: 1;
	transform: scale(1);
}

.contact-form .send-message-btn.is-loading .btn-label {
	opacity: 0.82;
}

.contact-form__label {
	font-weight: 600;
	margin-bottom: 8px;
	color: var(--contact-navy);
}

.contact-form__hint {
	margin-top: 10px;
	font-size: 14px;
	color: var(--contact-muted);
}

.contact-form__preview {
	margin-top: 14px;
	padding: 12px 16px;
	border-radius: 14px;
	border: 1px dashed rgba(44, 133, 223, 0.3);
	background: rgba(44, 133, 223, 0.08);
	display: none;
	align-items: center;
	gap: 14px;
}

.contact-form__preview.is-visible {
	display: flex;
}

.contact-form__preview img {
	width: 72px;
	height: 72px;
	object-fit: cover;
	border-radius: 12px;
	box-shadow: 0 12px 24px rgba(9, 89, 171, 0.15);
}

.contact-form__preview button {
	margin-left: auto;
	border: none;
	background: #c60000;
	color: #ffffff;
	font-size: 13px;
	font-weight: 600;
	border-radius: 999px;
	padding: 8px 16px;
	cursor: pointer;
	transition: opacity 0.2s ease;
}

.contact-form__preview button:hover {
	opacity: 0.85;
}

.contact-form .send-message-btn:not(:disabled):hover {
	transform: translateY(-4px);
	box-shadow: 0 30px 64px rgba(9, 89, 171, 0.3);
	opacity: 0.95;
}

@keyframes contact-spin {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
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

<div class="global-message d-none"></div>

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
						<div class="contact-field contact-field--full">
							<label class="contact-form__label" for="contact-attachment">Hình ảnh minh họa (tùy chọn)</label>
							<div class="contact-uploader" data-input="#contact-attachment" tabindex="0">
								<div class="contact-uploader__icon" aria-hidden="true">
									<svg viewBox="0 0 24 24" focusable="false">
										<path fill="currentColor" d="M9.5 4.5a1.5 1.5 0 0 1 1.3-.75h2.4a1.5 1.5 0 0 1 1.3.75l.64 1.15H18a3 3 0 0 1 3 3V17a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V8.65a3 3 0 0 1 3-3h2.33zm5.13 1.85-.44-.8a.5.5 0 0 0-.44-.25h-2.5a.5.5 0 0 0-.44.25l-.44.8a1 1 0 0 1-.88.55H6a1.5 1.5 0 0 0-1.5 1.5V17A1.5 1.5 0 0 0 6 18.5h12A1.5 1.5 0 0 0 19.5 17V8.65A1.5 1.5 0 0 0 18 7.15h-3.05a1 1 0 0 1-.88-.8zM12 10.5A3.5 3.5 0 1 1 8.5 14 3.5 3.5 0 0 1 12 10.5zm0 2A1.5 1.5 0 1 0 13.5 14 1.5 1.5 0 0 0 12 12.5z" />
									</svg>
								</div>
								<div class="contact-uploader__content">
									<p class="contact-uploader__title">Kéo &amp; thả ảnh vào đây</p>
									<p class="contact-uploader__subtitle">hoặc <span>chọn ảnh từ thiết bị</span></p>
								</div>
								<button type="button" class="contact-uploader__button" aria-label="Chọn ảnh tải lên">Chọn ảnh</button>
								<input id="contact-attachment" class="contact-uploader__input" type="file" name="attachment" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
							</div>
							<small class="error text-danger attachment"></small>
							<p class="contact-form__hint">Chấp nhận định dạng JPG, PNG, GIF hoặc WEBP với kích thước tối đa 5MB.</p>
							<div class="contact-form__preview" data-preview="contact-attachment">
								<img src="" alt="Xem trước ảnh liên hệ">
								<div class="contact-form__preview-text">
									<p style="margin:0;font-size:14px;color:#0c2553;font-weight:600;"></p>
								</div>
								<button type="button" class="contact-form__preview-remove">Gỡ ảnh</button>
							</div>
						</div>
					</div>
					<button type="submit" class="send-message-btn">
						<span class="btn-label">Gửi đi</span>
						<span class="btn-spinner" aria-hidden="true"></span>
					</button>
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
	let globalMessageTimer = null;
	const $globalMessage = $('.global-message');
	const globalMessageFallbackError = 'Thông báo lỗi: kiểm tra thông tin và nhập lại lần nữa.';

	const clearGlobalMessageTimer = () => {
		if (globalMessageTimer) {
			clearTimeout(globalMessageTimer);
			globalMessageTimer = null;
		}
	};

	const resetGlobalMessageState = () => {
		clearGlobalMessageTimer();
		if (!$globalMessage.length) {
			return;
		}

		$globalMessage
			.removeClass('global-message--success global-message--error global-message--info')
			.addClass('d-none')
			.removeAttr('role')
			.removeAttr('aria-live')
			.attr('aria-hidden', 'true')
			.empty();
	};

	const hideGlobalMessage = () => {
		resetGlobalMessageState();
	};

	const escapeHtml = (value) => $('<div/>').text(value ?? '').html();

	const renderGlobalMessage = (tone, text) => {
		const icons = {
			success: '<span class="global-message__icon global-message__icon--success" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M9.4 16.3 5.7 12.6l1.4-1.4 2.3 2.3 7.2-7.2 1.4 1.4z"/></svg></span>',
			error: '<span class="global-message__icon global-message__icon--error" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path fill="currentColor" d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Zm0-10.41 2.89-2.9 1.42 1.42-2.9 2.89 2.9 2.89-1.42 1.42-2.89-2.9-2.89 2.9-1.42-1.42 2.9-2.89-2.9-2.89 1.42-1.42Z"/></svg></span>',
			info: '<span class="global-message__icon global-message__icon--info" aria-hidden="true"><span class="global-message__spinner"></span></span>',
		};

		const headings = {
			success: 'Gửi liên hệ thành công',
			error: 'Không thể gửi liên hệ',
			info: 'Đang xử lý yêu cầu',
		};

		const icon = icons[tone] || icons.info;
		const heading = headings[tone] ? `<span class="global-message__heading">${headings[tone]}</span>` : '';
		const safeText = escapeHtml(text || '');

		return `${icon}<div class="global-message__content">${heading}<p class="global-message__text">${safeText}</p></div>`;
	};

	const applyGlobalMessage = (tone, text, options = {}) => {
		if (!$globalMessage.length) {
			return;
		}

		const { autoHide = false, hideAfter = 7000 } = options;

		resetGlobalMessageState();

		const toneClass = `global-message--${tone}`;
		$globalMessage
			.removeClass('d-none')
			.addClass(toneClass)
			.attr('aria-hidden', 'false')
			.attr('role', tone === 'error' ? 'alert' : 'status')
			.attr('aria-live', tone === 'error' ? 'assertive' : 'polite')
			.html(renderGlobalMessage(tone, text));

		if (autoHide) {
			globalMessageTimer = setTimeout(() => {
				hideGlobalMessage();
			}, hideAfter);
		}
	};

	$(document).on('click', '.send-message-btn', function(e) {
		e.preventDefault();

		const $button = $(this);

		if ($button.data('loading')) {
			return;
		}

		const $form = $button.closest('form');

		const setLoadingState = () => {
			$button.data('loading', true).prop('disabled', true).addClass('is-loading');
			const $label = $button.find('.btn-label');
			if (!$button.data('original-label')) {
				$button.data('original-label', $label.text());
			}
			$label.text('Đang gửi...');
		};

		const resetLoadingState = () => {
			const $label = $button.find('.btn-label');
			$label.text($button.data('original-label') || 'Gửi đi');
			$button.prop('disabled', false).removeClass('is-loading').data('loading', false);
		};

		const fields = ['first_name', 'last_name', 'email', 'subject', 'message', 'attachment'];
		fields.forEach((field) => {
			$form.find(`small.${field}`).text('');
		});

		setLoadingState();
		applyGlobalMessage('info', 'Đang gửi liên hệ, vui lòng đợi trong giây lát...');

		const csrf_token = $form.find("input[name='_token']").val();
		const first_name =  $form.find("input[name='first_name']").val();
		const last_name =  $form.find("input[name='last_name']").val();
		const email =  $form.find("input[name='email']").val();
		const subject =  $form.find("input[name='subject']").val();
		const message =  $form.find("textarea[name='message']").val();
		const attachmentInput = $form.find("input[name='attachment']")[0];

		let formData = new FormData();
		formData.append('_token', csrf_token);
		formData.append('first_name', first_name);
		formData.append('last_name', last_name);
		formData.append('email', email);
		formData.append('subject', subject);
		formData.append('message', message);

		if (attachmentInput && attachmentInput.files[0]) {
			formData.append('attachment', attachmentInput.files[0]);
		}

		$.ajax({
			url: "{{ route('contact.store') }}",
			data: formData,
			type: 'POST',
			dataType: 'JSON',
			processData: false,
			contentType: false,
			success: function (data) {
				if(data.success){
					applyGlobalMessage('success', data.message || 'Cảm ơn bạn! Liên hệ đã được gửi thành công.', { autoHide: true });

					clearData($form, [
						'first_name', 'last_name', 'email', 'subject', 'message', 'attachment'
					]);

					if (attachmentInput) {
						attachmentInput.value = '';
					}
					const $preview = $form.find('.contact-form__preview');
					$preview.removeClass('is-visible');
					$preview.find('img').attr('src', '');
					$preview.find('p').text('');
					$form.find('.contact-uploader').removeClass('is-active');
				}else{
					for ( const field in data.errors ){
						$form.find(`small.${field}`).text(data.errors[field] || '');
					}

					if (data.message || (data.errors && Object.keys(data.errors).length)) {
						applyGlobalMessage('error', data.message || globalMessageFallbackError);
					} else {
						hideGlobalMessage();
					}
				}
			},
			error: function () {
				applyGlobalMessage('error', 'Đã xảy ra lỗi khi gửi liên hệ. Vui lòng thử lại sau.');
			},
			complete: function () {
				resetLoadingState();
			}
		});
	});

	$(document).on('click', '.contact-uploader, .contact-uploader__button', function(e) {
		if ($(e.target).is('.contact-uploader__input')) {
			return;
		}
		e.preventDefault();
		const $field = $(this).closest('.contact-field');
		const $input = $field.find('.contact-uploader__input');
		$input.trigger('click');
	});

	$(document).on('keydown', '.contact-uploader', function(e) {
		if (e.key !== 'Enter' && e.key !== ' ') {
			return;
		}
		e.preventDefault();
		$(this).trigger('click');
	});

	$(document).on('change', "input[name='attachment']", function() {
		const file = this.files && this.files[0];
		const $field = $(this).closest('.contact-field');
		const $preview = $field.find('.contact-form__preview');
		const $previewText = $preview.find('p');
		const $uploader = $field.find('.contact-uploader');

		if (!file) {
			$preview.removeClass('is-visible');
			$preview.find('img').attr('src', '');
			$previewText.text('');
			$uploader.removeClass('is-active');
			return;
		}

		const reader = new FileReader();
		reader.onload = (event) => {
			$preview.addClass('is-visible');
			$preview.find('img').attr('src', event.target.result);
			$previewText.text(file.name);
			$uploader.addClass('is-active');
		};
		reader.readAsDataURL(file);
	});

	$(document).on('click', '.contact-form__preview-remove', function() {
		const $preview = $(this).closest('.contact-form__preview');
		const inputName = $preview.data('preview');
		const $input = $(`#${inputName}`);
		const $field = $preview.closest('.contact-field');

		$input.val('');
		$preview.removeClass('is-visible');
		$preview.find('img').attr('src', '');
		$preview.find('p').text('');
		$field.find('.contact-uploader').removeClass('is-active');
	});
</script>

@endsection