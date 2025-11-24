<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostSaveController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasSavedPost($post)) {
            return redirect()->back()->with('info', __('Bài viết đã nằm trong danh sách lưu.'));
        }

        $user->savedPosts()->attach($post->id);

        return redirect()->back()->with('success', __('Đã lưu bài viết để đọc sau.'));
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $request->user()->savedPosts()->detach($post->id);

        return redirect()->back()->with('success', __('Đã bỏ lưu bài viết.'));
    }
}
