<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Mail\ContactReplyMail;

class AdminContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['lastRepliedByUser'])
            ->withCount('replies')
            ->orderByDesc('created_at')
            ->get();

        return view('admin_dashboard.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->forceFill([
                'is_read' => true,
                'read_at' => now(),
            ])->save();
        }

        $contact->load(['replies.user']);

        return view('admin_dashboard.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply_subject' => 'required|string|min:3|max:150',
            'reply_message' => 'required|string|min:5|max:2000',
        ]);

        $admin = $request->user();

        $reply = $contact->replies()->create([
            'user_id' => $admin->id,
            'subject' => $validated['reply_subject'],
            'message' => $validated['reply_message'],
        ]);

        $contact->forceFill([
            'last_replied_at' => now(),
            'last_replied_by' => $admin->id,
            'is_read' => true,
        ])->save();

        Mail::to($contact->email)->send(new ContactReplyMail($contact, $reply, $admin));

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Đã gửi phản hồi tới độc giả.');
    }

    public function attachment(Request $request, Contact $contact)
    {
        if (!$contact->attachment_path || !Storage::disk('public')->exists($contact->attachment_path)) {
            abort(404);
        }

        $filename = $contact->attachment_original_name ?? basename($contact->attachment_path);
        $absolutePath = storage_path('app/public/' . ltrim($contact->attachment_path, '/'));

        if (!is_file($absolutePath)) {
            abort(404);
        }

        if ($request->boolean('download')) {
            return response()->download($absolutePath, $filename);
        }

        return response()->file($absolutePath, [
            'Content-Disposition' => 'inline; filename="' . addslashes($filename) . '"',
        ]);
    }

    public function destroy(Contact $contact)
    {
        DB::transaction(function () use ($contact) {
            $contact->replies()->delete();
            if ($contact->attachment_path) {
                Storage::disk('public')->delete($contact->attachment_path);
            }
            $contact->delete();
        });

        return redirect()->route('admin.contacts')->with('success', 'Xóa liên hệ thành công');
    }
}
