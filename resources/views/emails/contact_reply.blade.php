<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phản hồi từ VN News</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fb;font-family:'Segoe UI',Arial,sans-serif;color:#1f2937;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:32px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 16px 40px rgba(9,89,171,0.18);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#0c2553 0%,#0959ab 55%,#2c85df 100%);padding:36px 40px 30px 40px;color:#ffffff;">
                            <h1 style="margin:0;font-size:26px;font-weight:700;">VN News</h1>
                            <p style="margin:12px 0 0;font-size:16px;opacity:0.85;">Phản hồi yêu cầu của bạn</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 40px 28px 40px;">
                            <p style="margin:0 0 18px;font-size:17px;">Chào {{ $contact->first_name }} {{ $contact->last_name }},</p>
                            <p style="margin:0 0 18px;font-size:16px;line-height:1.7;">Cảm ơn bạn đã liên hệ với VN News. Đội ngũ chúng tôi đã xem xét nội dung bạn gửi và phản hồi kèm theo chi tiết bên dưới.</p>
                            <div style="border-left:4px solid #0959ab;background-color:#f0f6ff;padding:18px 22px;margin:0 0 26px;border-radius:12px;">
                                <h2 style="margin:0 0 12px;font-size:18px;color:#0c2553;">Phản hồi từ {{ $admin->name }}</h2>
                                <p style="margin:0;font-size:16px;line-height:1.7;white-space:pre-line;">{{ $reply->message }}</p>
                            </div>
                            <div style="margin:0 0 26px;">
                                <h3 style="margin:0 0 10px;font-size:17px;color:#0c2553;">Tóm tắt yêu cầu của bạn</h3>
                                <ul style="margin:0;padding:0 0 0 20px;font-size:15px;color:#4b5563;line-height:1.7;">
                                    <li><strong>Tiêu đề:</strong> {{ $contact->subject }}</li>
                                    <li><strong>Ngày gửi:</strong> {{ optional($contact->created_at)->locale('vi')->translatedFormat('d/m/Y H:i') }}</li>
                                </ul>
                                <div style="background-color:#f9fbff;border:1px solid rgba(9,89,171,0.16);padding:16px 20px;border-radius:12px;margin-top:14px;">
                                    <p style="margin:0;font-size:15px;color:#4b5563;line-height:1.7;white-space:pre-line;">{{ $contact->message }}</p>
                                </div>
                            </div>
                            <p style="margin:0 0 22px;font-size:16px;line-height:1.7;">Nếu bạn cần hỗ trợ thêm, hãy trả lời lại email này hoặc truy cập trang liên hệ của chúng tôi để gửi thêm thông tin.</p>
                            <table cellpadding="0" cellspacing="0" style="margin:0 0 28px;">
                                <tr>
                                    <td>
                                        <a href="{{ route('contact.create') }}" style="display:inline-block;padding:14px 28px;border-radius:999px;background:linear-gradient(135deg,#2c85df 0%,#0959ab 100%);color:#ffffff;text-decoration:none;font-weight:600;font-size:15px;">Gửi thêm yêu cầu</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0;font-size:14px;color:#6b7280;">Trân trọng,<br><strong>Đội ngũ VN News</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#0c2553;color:#cbd5f5;text-align:center;padding:18px 24px;font-size:13px;">
                            &copy; {{ date('Y') }} VN News. Mọi quyền được bảo lưu. | 140 Lê Trọng Tấn, Tân Phú, TP.HCM
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
