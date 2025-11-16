<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminNotificationController extends Controller
{
    /**
     * Đánh dấu tất cả liên hệ là đã đọc.
     */
    public function markAllContactsRead(Request $request): RedirectResponse
    {
        $now = Carbon::now();
        Contact::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => $now,
        ]);

        return $this->redirectAfterAction($request, route('admin.contacts'))
            ->with('success', 'Đã đánh dấu tất cả liên hệ là đã đọc.');
    }

    /**
     * Đánh dấu một liên hệ đã đọc.
     */
    public function markContactRead(Request $request, Contact $contact): RedirectResponse
    {
        if (! $contact->is_read) {
            $contact->forceFill([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ])->save();
        }

        return $this->redirectAfterAction($request, route('admin.contacts'));
    }

    /**
     * Đánh dấu tất cả bình luận là đã xem.
     */
    public function markAllCommentsRead(Request $request): RedirectResponse
    {
        $now = Carbon::now();
        Comment::where('is_reviewed', false)->update([
            'is_reviewed' => true,
            'reviewed_at' => $now,
        ]);

        return $this->redirectAfterAction($request, route('admin.comments.index'))
            ->with('success', 'Đã đánh dấu tất cả bình luận là đã xem.');
    }

    /**
     * Đánh dấu một bình luận đã xem.
     */
    public function markCommentRead(Request $request, Comment $comment): RedirectResponse
    {
        if (! $comment->is_reviewed) {
            $comment->forceFill([
                'is_reviewed' => true,
                'reviewed_at' => Carbon::now(),
            ])->save();
        }

        return $this->redirectAfterAction($request, route('admin.comments.index'));
    }

    /**
     * Xác định URL cần chuyển hướng sau khi đánh dấu đọc.
     */
    protected function redirectAfterAction(Request $request, string $fallback): RedirectResponse
    {
        $redirectTo = $request->input('redirect_to');

        if ($redirectTo && Str::startsWith($redirectTo, url('/'))) {
            return redirect()->to($redirectTo);
        }

        return redirect()->to($fallback);
    }
}
