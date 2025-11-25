@component('mail::message')
#Tin nhắn khách hàng

Khách hàng đã gửi một tin nhắn liên hệ mới 
<br><br>
Họ: {{ $firstname }}
<br>
Tên: {{ $secondname }}
<br>
Email: {{ $email }}
<br>
Tiêu đề: {{ $subject }}
<br>
Nội dung liên hệ: {{ $message }}

@if(!empty($hasAttachment) && $hasAttachment && !empty($attachmentUrl))

Tệp đính kèm: [{{ $attachmentName ?? 'Xem hình ảnh' }}]({{ $attachmentUrl }})

@endif

@component('mail::button', ['url' => $contactShowUrl ?? url('/admin/contacts')])
Xem tin nhắn
@endcomponent

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
