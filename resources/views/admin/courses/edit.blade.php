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
                        <h4><i class="fa-solid fa-table"></i> Chỉnh sửa khóa học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="#" id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>

                            <button type="submit" form="form-update-course" class="btn btn-primary"><i
                                    class="fa-solid fa-check"></i> Lưu</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <h3>Thông tin khóa học</h3>
            <!-- Form chỉnh sửa khóa học -->
            <form id="form-update-course" action="{{ url('admin/courses/update/' . $course->id) }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="ma_khoa_hoc">Mã khóa học</label>
                                        <input type="text" class="form-control" id="ma_khoa_hoc" name="code"
                                            value="{{ $course->code }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="ten_khoa_hoc">Tên khóa học</label>
                                        <input type="text" class="form-control" id="ten_khoa_hoc" name="name"
                                            value="{{ $course->name }}">
                                    </div>

                                    {{-- Ngôn ngữ --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="ngon_ngu">Ngôn ngữ</label>
                                        <select class="form-control" id="ngon_ngu" name="language_id" required disabled>
                                            <option value="">-- Chọn ngôn ngữ --</option>
                                            @foreach ($languages as $lang)
                                                <option value="{{ $lang->id }}"
                                                    {{ $course->language_id == $lang->id ? 'selected' : '' }}>
                                                    {{ $lang->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Chứng chỉ --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="chung_chi">Chứng chỉ</label>
                                        <select name="certificate_id" id="chung_chi" class="form-control" required disabled>
                                            @foreach ($certificates as $cert)
                                                <option value="{{ $cert->id }}"
                                                    {{ $course->certificate_id == $cert->id ? 'selected' : '' }}>
                                                    {{ $cert->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Level --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="level">Level</label>
                                        <select name="level_id" id="level" class="form-control" required >
                                            @foreach ($levels as $lv)
                                                <option value="{{ $lv->id }}"
                                                    {{ $course->level_id == $lv->id ? 'selected' : '' }}>
                                                    {{ $lv->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="gia_khoa_hoc">Giá khóa học</label>
                                        <input type="number" class="form-control" id="gia_khoa_hoc" name="price"
                                            value="{{ $course->price }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="thoi_luong_hoc">Thời lượng học</label>
                                        <input type="text" class="form-control" id="thoi_luong_hoc" name="total_lesson"
                                            value="{{ $course->total_lesson }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="so_buoi_hoc">Số buổi học</label>
                                        <input type="number" class="form-control" id="so_buoi_hoc" name="lesson_per_week"
                                            value="{{ $course->lesson_per_week }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="si_so_toi_da">Sĩ số tối đa</label>
                                        <input type="number" class="form-control" id="si_so_toi_da" name="max_student"
                                            value="{{ $course->max_student }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="si_so_toi_thieu">Sĩ số tối thiểu</label>
                                        <input type="number" class="form-control" id="si_so_toi_thieu" name="min_student"
                                            value="{{ $course->min_student }}">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="mo_ta">Mô tả</label>
                                        <textarea rows="4" class="form-control" id="mo_ta" name="description">{{ $course->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const certificateSelect = document.getElementById('chung_chi');
            const levelSelect = document.getElementById('level');

            // Lấy toàn bộ danh sách level từ Blade (Laravel sẽ render thành JSON)
            const allLevels = @json($levels);

            // Lưu lại level hiện tại (khi load trang để không bị mất)
            const currentLevelId = '{{ $course->level_id }}';

            // Hàm hiển thị level theo chứng chỉ được chọn
            function filterLevelsByCertificate(certId) {
                levelSelect.innerHTML = '<option value="">-- Chọn level --</option>';
                allLevels.forEach(level => {
                    if (level.certificate_id == certId) {
                        const option = document.createElement('option');
                        option.value = level.id;
                        option.textContent = level.name;
                        if (level.id == currentLevelId) {
                            option.selected = true; // giữ lại level đang chọn
                        }
                        levelSelect.appendChild(option);
                    }
                });
            }

            // Khi thay đổi chứng chỉ → lọc lại level
            certificateSelect.addEventListener('change', function() {
                filterLevelsByCertificate(this.value);
            });

            // Lọc level tương ứng khi trang vừa load (theo chứng chỉ hiện tại)
            filterLevelsByCertificate(certificateSelect.value);
        });
    </script>
@endsection
