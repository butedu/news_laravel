@extends("admin_dashboard.layouts.app")

@section('style')
<style>
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .status-chip::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-chip--approved {
        background: rgba(15, 118, 110, 0.14);
        color: #0f766e;
        box-shadow: 0 12px 24px rgba(15, 118, 110, 0.18);
    }

    .status-chip--pending {
        background: rgba(245, 158, 11, 0.16);
        color: #b45309;
        box-shadow: 0 12px 24px rgba(245, 158, 11, 0.18);
    }

    html.dark-theme .status-chip {
        box-shadow: none;
        backdrop-filter: blur(6px);
    }

    html.dark-theme .status-chip--approved {
        background: rgba(45, 212, 191, 0.16);
        color: #99f6e4;
    }

    html.dark-theme .status-chip--pending {
        background: rgba(251, 191, 36, 0.18);
        color: #fde68a;
    }

    .status-chip:hover {
        transform: translateY(-1px);
    }
</style>
@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Bài viết</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả bài viết</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <form method="GET" action="{{ route('admin.posts.index') }}" class="position-relative">
                        <input type="search" name="search" value="{{ old('search', $searchTerm ?? request('search')) }}" class="form-control ps-5 radius-30" placeholder="Tìm kiếm bài viết">
                        <button type="submit" class="position-absolute top-50 product-show translate-middle-y border-0 bg-transparent"><i class="bx bx-search"></i></button>
                    </form>
                    <div class="ms-auto"><a href="{{ route('admin.posts.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm bài viết mới</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã bài viết</th>
                                <th>Tên bài viết</th>
                                <th>Mô tả</th>
                                <th>Danh mục</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Lượt xem</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $post->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->title }}</td>
                               
                                
                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-chip {{ $post->approved ? 'status-chip--approved' : 'status-chip--pending' }}">
                                        {{ $post->approved ? 'Đã phê duyệt' : 'Chờ phê duyệt' }}
                                    </span>
                                </td>
                                <td>{{ $post->views }}</td>
                               
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.posts.edit', $post)}}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.querySelector('#delete_form_{{ $post->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method="post" action="{{ route('admin.posts.destroy', $post) }}" id="delete_form_{{ $post->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Không tìm thấy bài viết phù hợp với từ khóa.
                                </td>
                            </tr>
                            @endforelse
                          
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">{{ $posts->links() }}</div>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
	<script>
		$(document).ready(function () {
		setTimeout(()=>{
				$(".general-message").fadeOut();
		},5000);

		});
	</script>

@endsection
