
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
                              <a id="backBtn" class="btn btn-light"> <i class="fa-solid fa-arrow-left"></i>
                                  Quay lại</a>
                              <a class="btn btn-primary" onclick="document.getElementById('profileForm').submit();">
                                  <i class="fa-solid fa-check"></i> Lưu
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
                          <a href="#" class="btn btn-outline-primary w-75 mb-2">
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
                              <div class="col-md-1">

                              </div>
                              <div class="col-md-10">
                                  <form id="profileForm" method="POST" enctype="multipart/form-data"
                                      class="p-3 border rounded shadow-sm bg-white">
                                      @csrf
                                      <h5 class="mb-4 fw-bold text-primary">Thông tin cơ bản</h5>

                                      <!-- Ảnh đại diện -->
                                      <div class="row mb-4 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">Ảnh đại diện</label>
                                          <div class="col-md-9">
                                              <div class="position-relative d-inline-block">
                                                  <img id="preview"
                                                      src="{{ asset($user->avatar ? $user->avatar : 'images/kirito.jpg') }}"
                                                      alt="Avatar" class="rounded-circle border shadow-sm"
                                                      style="width: 120px; height: 120px; object-fit: cover;">
                                                  <label for="avatar"
                                                      class="btn btn-light position-absolute top-0 end-0 translate-middle p-2 shadow-sm"
                                                      style="border-radius: 50%; background-color: white;">
                                                      <i class="fa-solid fa-pen text-primary"></i>
                                                  </label>
                                                  <input type="file" id="avatar" name="avatar" accept="image/*"
                                                      class="d-none" onchange="previewImage(event)">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Họ & Tên -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">Họ & tên</label>
                                          <div class="col-md-9">
                                              <input type="text" name="name" class="form-control"
                                                  value="{{ $user->name }}">
                                          </div>
                                      </div>

                                      <!-- SĐT -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">SĐT</label>
                                          <div class="col-md-9">
                                              <div class="input-group">
                                                  <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                                  <input type="text" name="phone" class="form-control"
                                                      value="{{ $user->phone_number }}">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Email -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">Email</label>
                                          <div class="col-md-9">
                                              <div class="input-group">
                                                  <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                                                  <input type="email" name="email" class="form-control"
                                                      value="{{ $user->email }}">
                                              </div>
                                          </div>
                                      </div>

                                      <!-- ngày sinh -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">Ngày sinh</label>
                                          <div class="col-md-9">
                                              <input type="date" name="birthday" class="form-control"
                                                  value="{{ $user->birthday ?? '' }}">
                                          </div>
                                      </div>

                                      <!-- Phân quyền -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">Phân quyền</label>
                                          <div class="col-md-9">
                                              @if ($user->role == App\Models\User::ROLE_ADMIN)
                                                  <input type="text" class="form-control-plaintext text-secondary ps-2"
                                                      readonly value="Quản lý">
                                              @elseif ($user->role == App\Models\User::ROLE_STUDENT)
                                                  <input type="text" class="form-control-plaintext text-secondary ps-2"
                                                      readonly value="Học viên">
                                              @elseif ($user->role == App\Models\User::ROLE_TEACHER)
                                                  <input type="text" class="form-control-plaintext text-secondary ps-2"
                                                      readonly value="Giảng viên">
                                              @endif

                                          </div>
                                      </div>

                                      <!-- Giới thiệu -->
                                      <div class="row mb-3 align-items-center">
                                          <label class="col-md-3 col-form-label fw-semibold">trạng thái tài khoản</label>
                                          <div class="col-md-9">
                                              @if ($user->active == App\Models\User::ACTIVE)
                                                  <input type="text" class="form-control-plaintext text-success ps-2"
                                                      readonly value="Hoạt động">
                                              @else
                                                  <input type="text" class="form-control-plaintext text-danger ps-2"
                                                      readonly value="Khoa">
                                              @endif
                                          </div>
                                      </div>
                                  </form>
                              </div>
                              <div class="col-md-1">

                              </div>
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </div>

      {{-- Script xem trước ảnh --}}
      <script>
          function previewImage(event) {
              const reader = new FileReader();
              reader.onload = function() {
                  const output = document.getElementById('preview');
                  output.src = reader.result;
              };
              reader.readAsDataURL(event.target.files[0]);
          }

          // xử lý url cho changePasswordBtn
          const baseUrl = "{{ url('/') }}"; // ví dụ: http://localhost:8000
          const user = @json($user);

          const changePasswordBtn = document.getElementById('changePasswordBtn');

          // Nối chuỗi URL dựa vào role
          let changePasswordUrl = '';
          let updateUrl = '';
          if (user.role === {{ App\Models\User::ROLE_ADMIN }}) {
              changePasswordUrl = `${baseUrl}/admin/profile/change-password`;
              updateUrl = `${baseUrl}/admin/profile/update`;

          } else if (user.role === {{ App\Models\User::ROLE_TEACHER }}) {
              changePasswordUrl = `${baseUrl}/teacher/profile/change-password`;

              updateUrl += baseUrl + '/teacher/profile/update';
          } else if (user.role === {{ App\Models\User::ROLE_STUDENT }}) {
              changePasswordUrl = `${baseUrl}/student/profile/change-password`;

              updateUrl = `${baseUrl}/student/profile/update`;
          }

          // Gán URL cho nút
          changePasswordBtn.href = changePasswordUrl;
          document.getElementById('profileForm').action = updateUrl;
          // Điều hướng khi click
          changePasswordBtn.addEventListener('click', function(event) {
              event.preventDefault();
              window.location.href = changePasswordUrl;
          });
      </script>
  @endsection
