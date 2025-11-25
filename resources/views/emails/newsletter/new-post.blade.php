@php($post = $post ?? null)
@if($post)
<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 24px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="background-color: #0e73b8; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 20px;">Tin mới từ {{ config('app.name') }}</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 24px; color: #333333;">
                        <p style="margin-top: 0; font-size: 16px;">Chúng tôi vừa xuất bản bài viết mới trong chuyên mục <strong>{{ $post->category->name ?? '' }}</strong>.</p>
                        <h2 style="font-size: 22px; margin-bottom: 12px; color: #0e73b8;">{{ $post->title }}</h2>
                        <p style="font-size: 15px; line-height: 1.6;">{{ $post->excerpt }}</p>
                        <p style="margin-top: 20px;">
                            <a href="{{ $postUrl ?? route('posts.show', $post) }}" style="display: inline-block; padding: 12px 20px; background-color: #0e73b8; color: #ffffff; text-decoration: none; border-radius: 4px;">Đọc ngay</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 24px; background-color: #f0f4f8; color: #666666; font-size: 12px; text-align: center;">
                        <p style="margin: 0;">Bạn nhận được email này vì đã đăng ký theo dõi tin tức từ {{ config('app.name') }}.</p>
                        <p style="margin: 8px 0 0;">Nếu bạn không muốn nhận email nữa, vui lòng phản hồi để chúng tôi hỗ trợ.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endif
