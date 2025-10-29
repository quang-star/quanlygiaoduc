
  @php
      $layoutindex = '';
      $role = Auth::user()->role;
      if ($role == App\Models\User::ROLE_STUDENT) {
          $layoutindex = 'student.index';
      } elseif ($role == App\Models\User::ROLE_ADMIN) {
          $layoutindex = 'admin.index';
      } elseif ($role == App\Models\User::ROLE_TEACHER) {
          $layoutindex = 'teacher.index';
      }
  @endphp
    @extends($layoutindex)
  @section('header-content')
      Thông tin
  @endsection


@section('header-content')
   Thông tin
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Chỉnh sửa thông tin cá nhân</h4>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form chỉnh sửa học viên --}}
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">

            <div class="row">
                {{-- Cột bên trái --}}
                <div class="col-md-4 text-center border-end">
                    <img src="{{ asset($user->avatar ? $user->avatar : 'images/kirito.jpg') }}" alt="Ảnh đại diện"
                        style="width: 120px; height: 120px; border-radius: 10px; object-fit: cover;">
                    <h5 class="mt-3">{{ $user->name }}</h5>

                    @if ($user->role == App\Models\User::ROLE_STUDENT)
                        <p class="text-muted mb-1">Học viên</p>
                    @elseif ($user->role == App\Models\User::ROLE_ADMIN)
                        <p class="text-muted mb-1">Quản lý</p>
                    @elseif ($user->role == App\Models\User::ROLE_TEACHER)
                        <p class="text-muted mb-1">Giảng viên</p>
                    @endif

                    <div class="mt-3 text-start" style="margin-left: 40px;">
                        <p><strong>Mã thành viên:</strong> {{ $user->id }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>SĐT:</strong> {{ $user->phone_number }}</p>
                    </div>

                    <div class="mt-4">
                        <a href="#" class="btn btn-outline-primary w-75 mb-2" id="profileIndex">
                            <i class="fa-solid fa-user"></i> Thông tin chính
                        </a>

                        <a href="#" class="btn btn-outline-secondary w-75" id="changePasswordBtn">
                            <i class="fa-solid fa-lock"></i> Đổi mật khẩu
                        </a>
                    </div>
                </div>

                {{-- Cột bên phải --}}
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1"></div>

                            <div class="col-md-10">
                                <form id="changePasswordForm" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control" required minlength="6">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Xác nhận mật khẩu mới</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation" class="form-control" required minlength="6">
                                        <small id="passwordError" class="text-danger d-none">
                                            ⚠️ Mật khẩu xác nhận không khớp!
                                        </small>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check"></i> Cập nhật
                                        </button>
                                        <a href="javascript:history.back()" class="btn btn-secondary ms-2">Hủy</a>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script xử lý --}}
    <script>
        // Xem trước ảnh (nếu có input file)
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Xử lý URL cho nút và form đổi mật khẩu
        const baseUrl = "{{ url('/') }}";
        const user = @json($user);
        const changePasswordBtn = document.getElementById('changePasswordBtn');

        let changePasswordUrl = '';
        let actionChangePasswordUrl = '';
        let profileIndexUrl = '';
        if (user.role === {{ App\Models\User::ROLE_ADMIN }}) {
            changePasswordUrl = `${baseUrl}/admin/profile/change-password`;
            actionChangePasswordUrl = `${baseUrl}/admin/profile/update-password`;
            profileIndexUrl = `${baseUrl}/admin/profile/index`;
        } else if (user.role === {{ App\Models\User::ROLE_TEACHER }}) {
            changePasswordUrl = `${baseUrl}/teacher/profile/change-password`;
            actionChangePasswordUrl = `${baseUrl}/teacher/profile/update-password`;
            profileIndexUrl = `${baseUrl}/teacher/profile/index`;
        } else if (user.role === {{ App\Models\User::ROLE_STUDENT }}) {
            changePasswordUrl = `${baseUrl}/student/profile/change-password`;
            actionChangePasswordUrl = `${baseUrl}/student/profile/update-password`;
            profileIndexUrl = `${baseUrl}/student/profile/index`;
        }

        // Gán URL cho nút và form
        if (changePasswordBtn) {
            changePasswordBtn.href = changePasswordUrl;
            changePasswordBtn.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = changePasswordUrl;
            });
        }
        if(profileIndex){
            profileIndex.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = profileIndexUrl;
            });
        }

        const form = document.getElementById("changePasswordForm");
        if (form) {
            form.action = actionChangePasswordUrl;

            const newPassword = document.getElementById("new_password");
            const confirmPassword = document.getElementById("new_password_confirmation");
            const errorText = document.getElementById("passwordError");

            form.addEventListener("submit", function(event) {
                if (newPassword.value !== confirmPassword.value) {
                    event.preventDefault();
                    errorText.classList.remove("d-none");
                    confirmPassword.classList.add("is-invalid");
                } else {
                    errorText.classList.add("d-none");
                    confirmPassword.classList.remove("is-invalid");
                }
            });
        }
    </script>
@endsection
