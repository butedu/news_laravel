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
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $newsletter = Newsletter::firstOrNew(['email' => $validated['email']]);
        $categoryIds = array_filter(Arr::wrap($validated['categories'] ?? []));

        if (empty($categoryIds)) {
            $message = $newsletter->exists
                ? 'Bạn đã hủy đăng ký nhận tin thành công.'
                : 'Bạn hiện chưa đăng ký nhận tin.';

            if ($newsletter->exists) {
                $newsletter->categories()->detach();
                $newsletter->delete();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                ]);
            }

            return back()->with('success', $message);
        }

        $wasRecentlyCreated = false;

        if (! $newsletter->exists) {
            $newsletter->save();
            $wasRecentlyCreated = true;
        }

        $newsletter->categories()->sync($categoryIds);

        $message = $wasRecentlyCreated
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
