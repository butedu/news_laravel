@extends('admin_dashboard.layouts.app')

@section('style')
<style>
    .timeline {
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: rgba(9, 89, 171, 0.25);
    }

    .timeline-item {
        position: relative;
        padding-left: 32px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        top: 6px;
        left: 6px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #2c85df;
        box-shadow: 0 0 0 4px rgba(44, 133, 223, 0.18);
    }
</style>
@endsection

@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Liên hệ</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.contacts') }}">Hộp thư</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết liên hệ</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Thông tin độc giả</h5>
                            <p class="mb-0 text-muted">Gửi lúc {{ $contact->created_at?->locale('vi')->diffForHumans() }}</p>
                        </div>
                        <span class="badge {{ $contact->last_replied_at ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">
                            {{ $contact->last_replied_at ? 'Đã phản hồi' : 'Chưa phản hồi' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Tên độc giả</h6>
                            <p class="mb-0 fw-semibold">{{ $contact->first_name }} {{ $contact->last_name }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Email</h6>
                            <p class="mb-0"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Tiêu đề</h6>
                            <p class="mb-0 fw-semibold">{{ $contact->subject }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Nội dung</h6>
                            <div class="p-3 bg-light rounded border" style="white-space: pre-line;">{{ $contact->message }}</div>
                        </div>
                        @if($contact->attachment_path)
                            <div class="mb-0">
                                <h6 class="text-muted mb-1">Hình ảnh minh họa</h6>
                                <div class="d-inline-flex align-items-center gap-3 p-3 bg-white border rounded shadow-sm">
                                    <img src="{{ asset('storage/' . $contact->attachment_path) }}" alt="Ảnh liên hệ" style="width:120px;height:120px;object-fit:cover;border-radius:12px;">
                                    <div>
                                        <p class="mb-1 fw-semibold">{{ $contact->attachment_original_name ?? 'contact-image.jpg' }}</p>
                                        <a class="btn btn-outline-primary btn-sm" href="{{ asset('storage/' . $contact->attachment_path) }}" target="_blank">Xem / tải xuống</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Lịch sử phản hồi</h5>
                    </div>
                    <div class="card-body">
                        @if($contact->replies->isEmpty())
                            <p class="text-muted mb-0">Chưa có phản hồi nào từ admin.</p>
                        @else
                            <div class="timeline">
                                @foreach($contact->replies->sortByDesc('created_at') as $reply)
                                    <div class="timeline-item mb-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary me-2">{{ $reply->user->name }}</span>
                                            <span class="text-muted small">{{ $reply->created_at->locale('vi')->diffForHumans() }}</span>
                                        </div>
                                        <h6 class="fw-semibold mb-1">{{ $reply->subject }}</h6>
                                        <div class="bg-light border rounded p-3" style="white-space: pre-line;">{{ $reply->message }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Gửi phản hồi</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tiêu đề phản hồi</label>
                                <input type="text" name="reply_subject" class="form-control" value="{{ old('reply_subject', 'Phản hồi: ' . $contact->subject) }}" required>
                                @error('reply_subject')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung gửi độc giả</label>
                                <textarea name="reply_message" rows="6" class="form-control" placeholder="Nhập phản hồi chi tiết cho độc giả" required>{{ old('reply_message') }}</textarea>
                                @error('reply_message')
                                    <p class="text-danger mt-1 small">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><i class='bx bx-mail-send me-1'></i> Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
