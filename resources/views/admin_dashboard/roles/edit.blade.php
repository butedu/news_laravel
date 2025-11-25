@extends("admin_dashboard.layouts.app")
@section("style")
	<style>
		.role-edit-card {
			border: 1px solid rgba(9, 89, 171, 0.08);
			box-shadow: 0 12px 32px -18px rgba(9, 89, 171, 0.35);
		}

		.role-edit-heading {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			gap: 1.5rem;
			flex-wrap: wrap;
		}

		.role-meta {
			background: rgba(9, 89, 171, 0.08);
			color: #0959AB;
			border-radius: 999px;
			padding: 0.35rem 0.95rem;
			font-weight: 600;
		}

		.permission-grid {
			display: grid;
			gap: 1.5rem;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
		}

		.permission-card {
			background: #f8fbff;
			border-radius: 18px;
			padding: 1.25rem 1.4rem;
			border: 1px solid rgba(9, 89, 171, 0.1);
			box-shadow: 0 20px 40px -24px rgba(9, 89, 171, 0.45);
			transition: transform 0.25s ease, box-shadow 0.25s ease;
		}

		.permission-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 24px 46px -22px rgba(9, 89, 171, 0.55);
		}

		.permission-card__title {
			display: inline-flex;
			align-items: center;
			gap: 0.45rem;
			font-weight: 700;
			font-size: 0.85rem;
			text-transform: uppercase;
			color: #0c4f8d;
			margin-bottom: 0.85rem;
		}

		.permission-card__title i {
			font-size: 1rem;
		}

		.permission-list {
			display: flex;
			flex-direction: column;
			gap: 0.6rem;
			max-height: 260px;
			overflow-y: auto;
			scrollbar-width: thin;
		}

		.permission-list::-webkit-scrollbar {
			width: 6px;
		}

		.permission-list::-webkit-scrollbar-thumb {
			background: rgba(9, 89, 171, 0.2);
			border-radius: 999px;
		}

		.permission-item {
			display: flex;
			align-items: center;
			gap: 0.65rem;
			padding: 0.55rem 0.75rem;
			border-radius: 12px;
			background: rgba(255, 255, 255, 0.9);
			border: 1px solid rgba(9, 89, 171, 0.1);
			transition: background 0.2s ease, box-shadow 0.2s ease;
		}

		.permission-item:hover {
			background: rgba(9, 89, 171, 0.08);
			box-shadow: inset 0 0 0 1px rgba(9, 89, 171, 0.1);
		}

		.permission-label {
			flex: 1;
			font-weight: 500;
			color: #093b6b;
		}

		.permission-helper {
			font-size: 0.8rem;
			color: #6c757d;
		}

		.action-bar {
			display: flex;
			flex-wrap: wrap;
			gap: 0.75rem;
			align-items: center;
		}
	</style>
@endsection

@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Phân quyền</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Sửa quyền</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
			  
				<div class="card role-edit-card border-0">
				  <div class="card-body p-4 p-lg-5">
					  <div class="role-edit-heading">
						  <div>
							  <div class="d-flex align-items-center gap-2 mb-2">
								  <i class='bx bx-shield-quarter fs-4 text-primary'></i>
								  <h5 class="card-title mb-0">Sửa quyền</h5>
							  </div>
							  <p class="text-muted mb-0">Điều chỉnh tên quyền và gán các chức năng phù hợp cho người dùng thuộc quyền này.</p>
						  </div>
						  <span class="role-meta">Mã quyền #{{ $role->id }}</span>
					  </div>
					  <hr class="my-4"/>
					<form action="{{ route('admin.roles.update', $role) }}" method="POST">
						@csrf
						@method('PATCH')

						<div class="form-body mt-3">
							<div class="row g-4">
								<div class="col-12">
									<div class="mb-4">
										<label for="roleName" class="form-label text-uppercase fw-semibold small text-muted">Tên quyền</label>
										<div class="input-group input-group-lg">
											<span class="input-group-text bg-white text-primary"><i class='bx bx-id-card'></i></span>
											<input type="text" id="roleName" name="name" value="{{ old('name', $role->name) }}" class="form-control form-control-lg" placeholder="Nhập tên quyền" required>
										</div>
										<div class="permission-helper mt-2">Tên quyền sẽ hiển thị trong danh sách phân quyền và trang quản lý người dùng.</div>
										@error('name')
											<p class="text-danger fw-semibold mb-0 mt-2">{{ $message }}</p>
										@enderror
									</div>
								</div>
								<div class="col-12">
									<div class="mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
										<label class="form-label text-uppercase fw-semibold small text-muted mb-0">Chức năng cho phép</label>
										<span class="permission-helper">Đánh dấu những chức năng mà quyền <strong>{{ $role->name }}</strong> được truy cập.</span>
									</div>
									@if($permissionGroups->isEmpty())
										<div class="alert alert-info mb-0">Chưa có chức năng nào được cấu hình cho quyền này.</div>
									@else
										<div class="permission-grid">
											@foreach($permissionGroups as $group)
												<div class="permission-card">
													<span class="permission-card__title">
														<i class="{{ $group['icon'] ?? 'bx bx-category' }}"></i>
														{{ $group['label'] ?? 'Nhóm chức năng' }}
													</span>
													<div class="permission-list">
														@forelse($group['permissions'] as $permission)
															<label class="permission-item form-check mb-0">
																<input class="form-check-input shadow-none" {{ $permission['checked'] ? 'checked' : '' }} type="checkbox" name="permissions[]" value="{{ $permission['id'] }}">
																<span class="permission-label">{{ $permission['label'] }}</span>
															</label>
														@empty
															<div class="text-muted small">Chưa có chức năng nào trong nhóm này.</div>
														@endforelse
													</div>
												</div>
											@endforeach
										</div>
									@endif
								</div>
							</div>
						</div>

						<div class="action-bar mt-4">
							<button class="btn btn-primary btn-lg px-4" type="submit">
								<i class='bx bx-save me-1'></i>Cập nhật quyền
							</button>
							<a class="btn btn-outline-danger btn-lg px-4" onclick="event.preventDefault(); document.getElementById('delete_role_{{ $role->id }}').submit();" href="#">
								<i class='bx bx-trash-alt me-1'></i>Xóa quyền
							</a>
							<a class="btn btn-light btn-lg px-4" href="{{ route('admin.roles.index') }}">
								<i class='bx bx-arrow-back me-1'></i>Quay lại danh sách
							</a>
						</div>

					</form>

					<form id="delete_role_{{ $role->id }}" action="{{ route('admin.roles.destroy', $role) }}"  method="post">
						@csrf
						@method('DELETE')
					</form>
					
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