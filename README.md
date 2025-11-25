## VN News

VN News là dự án báo điện tử được xây dựng bằng Laravel, mang đến trải nghiệm đọc tin hiện đại với khả năng phân quyền chi tiết, quản lý bài viết trực quan và hệ thống bản tin theo chuyên mục. Người dùng có thể đăng ký nhận email theo dõi chuyên mục yêu thích, trong khi đội ngũ biên tập xử lý nội dung qua trang quản trị tối ưu cho quy trình duyệt bài.

### Các tính năng nổi bật
- Quản trị bài viết, chuyên mục, thẻ và người dùng với phân quyền cụ thể.
- Hệ thống liên hệ được nâng cấp với upload tệp đính kèm, thông báo quản trị và xem trước tài liệu.
- Đăng ký nhận bản tin theo chuyên mục, gửi email tự động khi bài viết được duyệt.
- Giao diện người dùng responsive, hỗ trợ lưu bài viết và tìm kiếm theo chuyên mục hoặc thẻ.

## Yêu cầu hệ thống

- PHP 8.1 trở lên, hỗ trợ các extension `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`.
- Composer 2.x để quản lý package PHP.
- Node.js >= 18 và npm >= 9 (dùng để build assets front-end nếu cần).
- MySQL 8 hoặc MariaDB 10.5 với quyền tạo database/tables.
- Redis (tùy chọn) nếu muốn sử dụng queue hoặc cache nâng cao.
- Một SMTP server (ví dụ Gmail, Mailgun) để gửi email liên hệ và bản tin.

## Hướng dẫn cài đặt

1. **Clone dự án**
	```bash
	git clone https://github.com/butedu/news_laravel.git
	cd news_laravel
	```

2. **Cài đặt dependencies**
	```bash
	composer install
	npm install
	```

3. **Tạo file cấu hình**
	```bash
	copy .env.example .env
	```
	Cập nhật các biến môi trường: thông tin database, `APP_URL`, `NEWSLETTER_BASE_URL`, cấu hình SMTP...

4. **Khởi tạo khóa ứng dụng**
	```bash
	php artisan key:generate
	```

5. **Thiết lập database**
	```bash
	php artisan migrate --seed
	```
	Lệnh seed sẽ tạo dữ liệu mẫu gồm người dùng quản trị, quyền và các chuyên mục cơ bản.

6. **Liên kết storage và build assets**
	```bash
	php artisan storage:link
	npm run build   # hoặc npm run dev khi phát triển
	```

7. **Chạy ứng dụng**
	```bash
	php artisan serve
	```
	Mặc định ứng dụng hoạt động tại `http://127.0.0.1:8000`.

8. **Queue và cron (khuyến nghị)**
	- Cập nhật `QUEUE_CONNECTION=database` trong `.env` và chạy: `php artisan queue:table && php artisan migrate`.
	- Khởi chạy worker: `php artisan queue:work` để xử lý email liên hệ và bản tin.
	- Thiết lập cron `php artisan schedule:run` mỗi phút để đảm bảo các tác vụ định kỳ vận hành.

## Thông tin đăng nhập mẫu

- **Admin:** `admin@example.com` / `password`
- **Biên tập viên:** `editor@example.com` / `password`
- Bạn có thể thay đổi hoặc tạo thêm tài khoản trong trang quản trị.

## Cấu trúc thư mục chính

- `app/` - Code PHP lõi (controller, model, job, mail, service provider...).
- `resources/views/` - Blade template cho frontend và trang quản trị.
- `public/` - Tài nguyên tĩnh (ảnh, CSS, JS đã build).
- `database/migrations` & `seeders` - Lược đồ và dữ liệu mẫu.
- `routes/web.php` - Định nghĩa tuyến web chính của ứng dụng.

## Đóng góp & Liên hệ

- Tạo issue hoặc pull request trên repository nếu bạn muốn đóng góp.
- Mọi thắc mắc liên hệ nhóm phát triển qua email: `contact@nhom7.vn`.
