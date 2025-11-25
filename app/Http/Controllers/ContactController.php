<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendContactNotification;

use App\Models\Category;
use App\Models\Post;

class ContactController extends Controller
{
    public function create(){
        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name','Chưa phân loại')->first();
        $posts_new[0]= Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->take(1)->get();
        $posts_new[1] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->take(1)->get();
        $posts_new[2] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->where('category_id','!=', $posts_new[1][0]->category->id )
                    ->take(1)->get();
        $posts_new[3] = Post::latest()->approved()
                    ->where('category_id','!=', $category_unclassified->id )
                    ->where('category_id','!=', $posts_new[0][0]->category->id )
                    ->where('category_id','!=', $posts_new[1][0]->category->id)
                    ->where('category_id','!=', $posts_new[2][0]->category->id )
                    ->take(1)->get();
        
        return view('contact',[
            'categories' => $categories = Category::where('name','!=','Chưa phân loại')->orderBy('created_at','DESC')->take(10)->get(),
            'posts_new' => $posts_new,
        ]);
    }

    public function store(Request $request)
    {
        $data = [
            'success' => 0,
            'errors' => [],
        ];

        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|min:5|max:120',
            'message' => 'required|string|min:5|max:1000',
            'attachment' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ];

        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            foreach (['first_name', 'last_name', 'email', 'subject', 'message', 'attachment'] as $field) {
                $data['errors'][$field] = $validated->errors()->first($field);
            }

            $data['message'] = 'Thông báo lỗi: kiểm tra thông tin và nhập lại lần nữa.';
        } else {
            $attributes = $validated->validated();

            $attachmentPath = null;
            $attachmentOriginalName = null;
            $attachmentMime = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $attachmentPath = $file->store('contact_attachments', 'public');
                $attachmentOriginalName = $file->getClientOriginalName();
                $attachmentMime = $file->getClientMimeType();
            }

            $contact = Contact::create([
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                'email' => $attributes['email'],
                'subject' => $attributes['subject'],
                'message' => $attributes['message'],
                'attachment_path' => $attachmentPath,
                'attachment_original_name' => $attachmentOriginalName,
                'attachment_mime' => $attachmentMime,
            ]);

            $recipient = config('contact.notification_recipient');

            if (!empty($recipient)) {
                SendContactNotification::dispatch($contact, $recipient)->afterResponse();
            }

            $data['success'] = 1;
            $data['message'] = 'Cảm ơn bạn! Liên hệ đã được gửi thành công. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.';
        }

        return response()->json($data);
    }
}
