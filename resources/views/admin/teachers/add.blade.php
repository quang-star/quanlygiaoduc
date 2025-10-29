@extends('admin.index')
@section('header-content')
    Giảng viên
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Thêm giảng viên</h4>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="#" id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>

                            <button class="btn btn-primary" id="saveBtn">
                                <i class="fa-solid fa-check"></i> Lưu
                            </button>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">

            <!-- Form tạo mới khóa học -->
            <div class="col-md-12">
                <div class="row">

                    <form id="teacherForm" action="{{ url('/admin/teachers/add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Họ tên <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Email <span style="color: red;">*</span></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Số điện thoại <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Ngày sinh <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" name="birthday" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Lương cơ sở (VNĐ / buổi dạy) <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" name="base_salary" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Ngân hàng <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Tên ngân hàng"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Số tài khoản <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="bank_account" placeholder="Số tài khoản"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Trạng thái <span style="color: red;">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="0">Hoạt động</option>
                                    <option value="1">Ngưng hoạt động</option>
                                </select>
                            </div>
                        </div>
                    </form>




                </div>

            </div>
        </div>
    </div>
    <script>
        document.getElementById('saveBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('teacherForm');
             const btn = document.getElementById('saveBtn');
            if (form.checkValidity()) {
                btn.disabled = true; // chặn bấm lại
                btn.innerHTML = 'Đang xử lý... ⏳'; // đổi text cho người dùng biết
                form.submit();

            } else {
                form.reportValidity(); // Hiện thông báo lỗi HTML5
            }
        });
    </script>
@endsection
