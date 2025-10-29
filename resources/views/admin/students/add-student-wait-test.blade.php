@extends('admin.index')
@section('header-content')
    Học viên
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Tạo học viên</h4>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="#" id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>

                            <button type="submit" class="btn btn-primary" id="saveBtn">
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

                    <form class="col-md-8" id="studentForm" action="{{ url('/admin/students/create-wait-test') }}"
                        method="post">

                        @csrf
                        <div class="col-md-12">
                            <div class="row">

                                <input type="hidden" name="student_id" value="">

                                <div class="col-md-6 mb-3">
                                    <label for="ho_ten" class="form-label">Họ tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="ho_ten"
                                        placeholder="Nhập họ tên" value="" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="so_dien_thoai" class="form-label">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="Nhập số điện thoại" value="" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" placeholder="Nhập email"
                                        name="email" value="" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ngay_sinh" class="form-label">Ngày sinh <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="birthday" placeholder="Nhập ngày sinh"
                                        name="birthday" value="" required>
                                </div>

                                {{-- Ngôn ngữ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" name="language" id="language" required>
                                        <option value="">-- Chọn ngôn ngữ --</option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Chứng chỉ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ <span
                                            class="text-danger">*</span></label>
                                    <select name="certificate" id="certificate" class="form-control" required>
                                        <option value="">-- Chọn chứng chỉ --</option>
                                        @foreach ($certificates as $cert)
                                            <option value="{{ $cert->id }}" data-language="{{ $cert->language_id }}">
                                                {{ $cert->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Thời gian test --}}
                                <div class="col-md-6 mb-3">
                                    <label for="time" class="form-label">Thời gian test <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="time"
                                        placeholder="Nhập thời gian test" name="time_test" value="" required>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const langSelect = document.getElementById('language');
            const certSelect = document.getElementById('certificate');
            const allCertOptions = Array.from(certSelect.options); // Lưu tất cả chứng chỉ ban đầu

            // Khi chọn ngôn ngữ → lọc chứng chỉ
            langSelect.addEventListener('change', function() {
                const langId = this.value;

                // Xóa hết options hiện tại
                certSelect.innerHTML = '<option value="">-- Chọn chứng chỉ --</option>';

                // Thêm lại những chứng chỉ thuộc ngôn ngữ đã chọn
                allCertOptions.forEach(opt => {
                    if (opt.dataset.language === langId) {
                        certSelect.appendChild(opt);
                    }
                });
            });

            // Nếu chọn chứng chỉ → tự động chọn ngôn ngữ tương ứng
            certSelect.addEventListener('change', function() {
                const selectedOption = this.selectedOptions[0];
                const langId = selectedOption ? selectedOption.dataset.language : null;
                if (langId) {
                    langSelect.value = langId;
                }
            });
        });
    </script>

    <script>
        document.getElementById('saveBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('studentForm');
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
