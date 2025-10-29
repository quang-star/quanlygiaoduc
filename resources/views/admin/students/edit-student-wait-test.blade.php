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
                        <h4><i class="fa-solid fa-table"></i> Chỉnh sửa thông tin học viên</h4>
                    </div>

                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a  id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>

                            <a  class="btn btn-primary"
                                onclick="document.getElementById('studentForm').submit();">
                                <i class="fa-solid fa-check"></i> Lưu
                            </a>
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

                    <form class="col-md-8" id="studentForm" action="{{ url('/admin/students/wait-test/edit') }}"
                        accept="" method="post">


                        @csrf
                        <div class="col-md-12">
                            <div class="row">

                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <input type="hidden" name="student_profile_id" value="{{ $studentProfile->id }}">
                                <div class="col-md-6 mb-3">
                                    <label for="ho_ten" class="form-label">Họ tên</label>
                                    <input type="text" name="name" class="form-control" id="ho_ten"
                                        placeholder="Nhập họ tên" value="{{ $student->name ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="Nhập số điện thoại" value="{{ $student->phone_number }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Nhập email"
                                        name="email" value="{{ $student->email }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="birthday" placeholder="Nhập ngày sinh"
                                        name="birthday" value="{{ $student->birthday }}">
                                </div>
                                {{-- -ngôn ngữ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                    <select class="form-control" name="language" id="language" required>

                                        @foreach ($languages as $lang)
                                            @if ($studentProfile->language_id == $lang->id)
                                                <option value="{{ $lang->id }}" selected>{{ $lang->name }}</option>
                                            @else
                                                <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ</label>
                                    <select name="certificate" id="certificate" class="form-control" required>

                                        @foreach ($certificates as $cert)
                                            @if ($studentProfile->certificate_id == $cert->id)
                                                <option value="{{ $cert->id }}"
                                                    data-language="{{ $cert->language_id }}" selected>
                                                    {{ $cert->code }}
                                                </option>
                                            @else
                                                <option value="{{ $cert->id }}"
                                                    data-language="{{ $cert->language_id }}">
                                                    {{ $cert->code }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                {{-- -ô để nhập điểm --}}
                                <div class="col-md-6 mb-3">
                                    <label for="diem" class="form-label">Điểm</label>
                                    @php
                                        $totalScore = $testResult->total_score ?? 0;
                                        if ($totalScore < 0) {
                                            $totalScore = 0;
                                        }
                                    @endphp
                                    <input type="number" name="score" class="form-control" id="diem"
                                        placeholder="Nhập điểm" value="{{ $totalScore }}">
                                </div>


                            </div>

                        </div>


                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-11"></div>
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
@endsection
