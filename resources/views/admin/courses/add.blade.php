@extends('admin.index')
@section('header-content')
    Khóa học
{{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa-solid fa-table"></i> Tạo mới khóa học</h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('/admin/courses/index') }}" id="backBtn" class="btn btn-light">
                            <i class="fa-solid fa-arrow-left"></i> Quay lại
                        </a>

                        <button type="submit" form="form-create-course" class="btn btn-primary" style="margin-left: 10px;">
                            <i class="fa-solid fa-check"></i> Lưu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
        <h3>Thông tin khóa học</h3>

        {{-- Form tạo mới khóa học --}}
        <form id="form-create-course" action="{{ url('admin/courses/store') }}" method="POST">
            @csrf
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="row">
                                {{-- Mã khóa học (readonly) --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ma_khoa_hoc" class="form-label">Mã khóa học</label>
                                    <input type="text" class="form-control" id="ma_khoa_hoc" name="code" placeholder="Tự động tạo" readonly>
                                </div>


                                {{-- Tên khóa học --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ten_khoa_hoc" class="form-label">Tên khóa học <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="ten_khoa_hoc" name="name"
                                        placeholder="Nhập tên khóa học" required>
                                </div>

                                {{-- Ngôn ngữ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ <span style="color:red">*</span></label>
                                    <select class="form-control" id="ngon_ngu" name="language_id" required>
                                        <option value="">-- Chọn ngôn ngữ --</option>
                                        @foreach($languages as $lang)
                                        <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Chứng chỉ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ <span style="color:red">*</span></label>
                                    <select name="certificate_id" id="chung_chi" class="form-control" required>
                                        <option value="">-- Chọn chứng chỉ --</option>
                                        @foreach($certificates as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Level --}}
                                <div class="col-md-6 mb-3">
                                    <label for="level" class="form-label">Level <span style="color:red">*</span></label>
                                    <select name="level_id" id="level" class="form-control" required>
                                        <option value="">-- Chọn level --</option>
                                        @foreach($levels as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Giá khóa học --}}
                                <div class="col-md-6 mb-3">
                                    <label for="gia_khoa_hoc" class="form-label">Giá khóa học (VNĐ) <span style="color:red">*</span></label>
                                    <input type="number" class="form-control" id="gia_khoa_hoc" name="price"
                                        placeholder="Nhập giá khóa học" required>
                                </div>

                                {{-- Tổng số buổi học --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tong_so_buoi" class="form-label">Tổng số buổi học <span style="color:red">*</span></label>
                                    <input type="number" class="form-control" id="tong_so_buoi" name="total_lesson"
                                        placeholder="Nhập tổng số buổi học" required>
                                </div>

                                {{-- Số buổi học / tuần --}}
                                <div class="col-md-6 mb-3">
                                    <label for="so_buoi_hoc" class="form-label">Số buổi học / tuần <span style="color:red">*</span></label>
                                    <input type="number" class="form-control" id="so_buoi_hoc" name="lesson_per_week"
                                        placeholder="Nhập số buổi học mỗi tuần" required>
                                </div>

                                {{-- Sĩ số tối đa --}}
                                <div class="col-md-6 mb-3">
                                    <label for="si_so_toi_da" class="form-label">Sĩ số tối đa <span style="color:red">*</span></label>
                                    <input type="number" class="form-control" id="si_so_toi_da" name="max_student"
                                        placeholder="Nhập sĩ số tối đa" required>
                                </div>

                                {{-- Sĩ số tối thiểu --}}
                                <div class="col-md-6 mb-3">
                                    <label for="si_so_toi_thieu" class="form-label">Sĩ số tối thiểu <span style="color:red">*</span></label>
                                    <input type="number" class="form-control" id="si_so_toi_thieu" name="min_student"
                                        placeholder="Nhập sĩ số tối thiểu" required>
                                </div>

                                {{-- Mô tả --}}
                                <div class="col-md-12 mb-3">
                                    <label for="mo_ta" class="form-label">Mô tả</label>
                                    <textarea rows="4" class="form-control" id="mo_ta" name="description"
                                        placeholder="Nhập mô tả khóa học"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Script render mã khóa học = tên chứng chỉ + level -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const certificateSelect = document.getElementById('chung_chi');
        const levelSelect = document.getElementById('level');
        const codeInput = document.getElementById('ma_khoa_hoc');

        function updateCourseCode() {
            const certificate = certificateSelect.options[certificateSelect.selectedIndex]?.text || '';
            const level = levelSelect.options[levelSelect.selectedIndex]?.text || '';

            if (certificate && level) {
                codeInput.value = (certificate + '-' + level).toUpperCase();
            } else {
                codeInput.value = '';
            }
        }

        certificateSelect.addEventListener('change', updateCourseCode);
        levelSelect.addEventListener('change', updateCourseCode);
    });
</script>
<!-- Script liên kết ngôn ngữ + chứng chỉ + level -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const languageSelect = document.getElementById('ngon_ngu');
        const certificateSelect = document.getElementById('chung_chi');
        const levelSelect = document.getElementById('level');

        // 🔹 Lấy danh sách dữ liệu đã render sẵn từ Blade
        const allCertificates = @json($certificates);
        const allLevels = @json($levels);

        // 🟦 Khi chọn ngôn ngữ → lọc chứng chỉ theo language_id
        languageSelect.addEventListener('change', function() {
            const langId = this.value;
            certificateSelect.innerHTML = '<option value="">-- Chọn chứng chỉ --</option>';
            levelSelect.innerHTML = '<option value="">-- Chọn level --</option>';

            if (!langId) return;

            const filteredCertificates = allCertificates.filter(c => c.language_id == langId);
            filteredCertificates.forEach(c => {
                const option = document.createElement('option');
                option.value = c.id;
                option.textContent = c.name;
                certificateSelect.appendChild(option);
            });
        });

        // 🟩 Khi chọn chứng chỉ → lọc level theo certificate_id
        certificateSelect.addEventListener('change', function() {
            const certId = this.value;
            levelSelect.innerHTML = '<option value="">-- Chọn level --</option>';
            if (!certId) return;

            const filteredLevels = allLevels.filter(l => l.certificate_id == certId);
            filteredLevels.forEach(l => {
                const option = document.createElement('option');
                option.value = l.id;
                option.textContent = l.name;
                levelSelect.appendChild(option);
            });

            // Đồng bộ ngôn ngữ nếu chứng chỉ có language_id
            const selectedCert = allCertificates.find(c => c.id == certId);
            if (selectedCert) {
                languageSelect.value = selectedCert.language_id;
            }
        });
    });
</script>




@endsection