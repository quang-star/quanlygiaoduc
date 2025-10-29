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
                        <h4><i class="fa-solid fa-table"></i> Danh sách khóa học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <input id="searchInput" type="text" class="form-control" placeholder="Tìm nhanh..."
                                style="width: 200px; margin-right: 10px;" onkeyup="searchTable()">

                            {{-- <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button> --}}
                            <button class="btn btn-secondary" id="toggleSearchBtn" style="margin-right: 10px;">
                                <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                            </button>
                            {{-- 
                            <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button> --}}
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('admin/courses/add') }}" class="btn btn-primary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/courses/index') }}">
                    <div class="row">





                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="course" class="form-control" placeholder="Nhập tên khóa học">
                        </div> --}}
                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngôn ngữ</label>
                            <select id="language" class="form-select" name="language_id">
                                {{-- <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach 
                            </select>
                        </div> --}}
                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Chọn chứng chỉ</label>
                            <select id="certificate" class="form-select" name="certificate_id">
                                <option value="">-- Chọn chứng chỉ --</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}" data-lang="{{ $certificate->language_id }}"
                                        {{ isset($datas['certificate_id']) && $datas['certificate_id'] == $certificate->id ? 'selected' : '' }}>
                                        {{ $certificate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- khóa học -->
                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Chọn khóa học</label>
                            <select name="course_id" id="courses" class="form-select">
                                <option value="">-- Chọn khóa học --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngày ký</label>
                            <input type="date" name="date" class="form-control">
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1" selected>Thanh toán đủ</option>
                                <option value="0">Đang thanh toán</option>


                            </select>

                        </div>

                        <div class="col-md-3 mb-3">
                            <!-- sort theo lâu nhất với nhanh nhất -->
                            <label for="" class="form-label">Sắp xếp</label>
                            <select name="sort" class="form-select">
                                <option value="">-- Chọn sắp xếp --</option>
                                <option value="asc">Lâu nhất</option>
                                <option value="desc">Gần nhất</option>
                            </select>
                        </div> --}}


                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            <a href="{{ url('admin/courses/index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Mã khóa học</th>
                        <th>Tên khóa học</th>
                        <th>Chứng chỉ</th>
                        <th>Level tương ứng</th>
                        <th>Sĩ số tối đa</th>
                        <th>Sĩ số tối thiểu</th>
                        <th>Học phí</th>
                        <th>Thời lượng</th>
                        <th>Số buổi học /tuần</th>
                        {{-- <th>Trạng thái</th> --}}
                        <th>Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->certificate->name ?? '-' }}</td>
                            <td>Level {{ $course->level->name ?? '-' }}</td>
                            <td>{{ $course->min_student }} hv</td>
                            <td>{{ $course->max_student }} hv</td>
                            <td>{{ number_format($course->price, 0, ',', '.') }} ₫</td>
                            <td>{{ $course->total_lesson }} buổi</td>
                            <td>{{ $course->lesson_per_week }} buổi</td>
                            {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                            <td>
                                <a class="btn btn-sm btn-success"
                                    href="{{ url('admin/classes/add-class?course_id=' . $course->id) }}">
                                    <i class="fa-solid fa-plus"></i> Tạo lớp học
                                </a>
                                <a href="{{ url('admin/courses/edit/' . $course->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ url('admin/courses/delete/' . $course->id) }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này không?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Lưu trạng thái form vào sessionStorage (chỉ lưu tạm trong tab trình duyệt)
        document.getElementById('toggleSearchBtn').addEventListener('click', function() {
            const form = document.getElementById('form-search');
            const isVisible = form.style.display === 'block';
            form.style.display = isVisible ? 'none' : 'block';
            sessionStorage.setItem('formVisible', !isVisible);
        });

        // Giữ trạng thái mở/đóng khi F5
        window.addEventListener('DOMContentLoaded', function() {
            const savedState = sessionStorage.getItem('formVisible') === 'true';
            document.getElementById('form-search').style.display = savedState ? 'block' : 'none';
        });
    </script>
    <script>
        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("contractTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
