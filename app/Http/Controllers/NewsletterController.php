<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Arr;

class NewsletterController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'categories' => 'required|array|min:1',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $newsletter = Newsletter::firstOrCreate(['email' => $validated['email']]);

        $categoryIds = Arr::wrap($validated['categories']);
        $newsletter->categories()->sync($categoryIds);

        $message = $newsletter->wasRecentlyCreated
            ? 'Đăng ký thành công! Chúng tôi sẽ gửi tin mới cho bạn sớm.'
            : 'Cập nhật chủ đề yêu thích thành công. Chúng tôi sẽ gửi tin mới khi có bài viết phù hợp.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
