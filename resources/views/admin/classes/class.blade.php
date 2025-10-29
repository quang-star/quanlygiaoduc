@extends('admin.index')
@section('header-content')
    Lớp học


    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Danh sách lớp học</h4>
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

                            {{-- <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                class="fa-solid fa-file-export"></i> Xuất file</button> --}}
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('admin/classes/add-class') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/classes/class') }}">
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
                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Chọn chứng chỉ</label>
                            <select id="certificate" class="form-select" name="certificate_id">
                                <option value="">-- Chọn chứng chỉ --</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}" data-lang="{{ $certificate->language_id }}">
                                        {{ $certificate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <!-- khóa học -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Chọn khóa học</label>
                            <select name="course_id" id="courses" class="form-select">
                                <option value="">-- Chọn khóa học --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ isset($datas['course_id']) && $datas['course_id'] == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- giáo viên -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Chọn giáo viên</label>
                            <select name="teacher_id" id="teachers" class="form-select">
                                <option value="">-- Chọn giáo viên --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ isset($datas['teacher_id']) && $datas['teacher_id'] == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="scheduled" {{ ($datas['status'] ?? '') == 'scheduled' ? 'selected' : '' }}>
                                    Đang tuyển sinh</option>
                                <option value="running" {{ ($datas['status'] ?? '') == 'running' ? 'selected' : '' }}>Đang
                                    học</option>
                                <option value="completed" {{ ($datas['status'] ?? '') == 'completed' ? 'selected' : '' }}>
                                    Đã hoàn thành</option>
                                <option value="cancelled" {{ ($datas['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>
                                    Đã hủy</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngày ký</label>
                            <input type="date" name="date" class="form-control">
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
                            <a href="{{ url('admin/classes/class') }}" class="btn btn-outline-secondary">
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
            <table class="table table-bordered" id="classTable">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Mã lớp học</th>
                        <th>Tên lớp học</th>
                        <th>Khóa học</th>
                        <th>Giáo viên</th>
                        <th>Ngày khai giảng</th>
                        <th>Lịch học</th>
                        <th>Học viên</th>

                        <th>Số buổi học</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>{{ $class->id }}</td>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->course->name ?? '' }}</td>
                            <td>{{ $class->teacher->name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($class->start_date)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $schedule = json_decode($class->schedule, true);
                                @endphp

                                @if (!empty($schedule))
                                    {{ implode(', ', array_column($schedule, 'day')) }}
                                @else
                                    Không có lịch
                                @endif

                            </td>


                            <td>{{ $class->contracts_count }} / {{ $class->max_student }} hv</td>

                            <td>{{ $class->total_lesson }} buổi</td>
                            <td>
                                @if ($class->status == \App\Models\ClassModel::SCHEDULED)
                                    <span class="badge bg-warning">Chưa bắt đầu</span>
                                @elseif ($class->status == \App\Models\ClassModel::RUNNING)
                                    <span class="badge bg-success">Đang học</span>
                                @elseif ($class->status == \App\Models\ClassModel::COMPLETED)
                                    <span class="badge bg-primary">Đã hoàn thành</span>
                                @elseif ($class->status == \App\Models\ClassModel::CANCELLED)
                                    <span class="badge bg-danger">Tạm hoãn</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ url('admin/classes/class-schedule/' . $class->id) }}"
                                    class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch học</a>
                                <a href="{{ url('admin/classes/edit/' . $class->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </a>
                                <form action="{{ url('admin/classes/delete/' . $class->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa lớp học này không?')">
                                        <i class="fa-solid fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Thêm các dòng dữ liệu khác tại đây -->

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
            const table = document.getElementById("classTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
