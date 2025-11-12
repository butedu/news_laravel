<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRequests\NewsletterRequest;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Newsletter::create(['email' => $request->email]);
        return back()->with('success', 'Đăng ký thành công!');
    }
}
