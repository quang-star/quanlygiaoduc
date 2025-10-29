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
                        <h4><i class="fa-solid fa-table"></i> Học viên chờ xếp lớp</h4>
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
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('admin/students/create-wait-test') }}" class="btn btn-primary" style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
               <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/students/wait-class') }}">
                    <div class="row">





                        <div class="col-md-3 mb-3">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="course" class="form-control" placeholder="Nhập tên khóa học"
                                value="{{ $datas['course'] ?? '' }}">
                        </div>

                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Lớp học</label>
                            <input type="text" name="class" class="form-control" placeholder="Nhập tên lớp học">

                        </div> --}}


                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            <a href="{{ url('admin/students/wait-class') }}" class="btn btn-outline-secondary">
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
            <div class="col-md-12">
                <table class="table table-bordered" id="studentTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Khóa học</th>
                            <th>Level</th>
                            <th>Lớp học</th>

                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone_number }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->course_name }}</td>
                                <td>level {{ $student->level_name }}</td>
                                <form action="{{ url('admin/students/wait-class/save') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="student_profile_id"
                                        value="{{ $student->student_profile_id }}">
                                    <td>
                                        @php
                                            $courseClasses = $classes[$student->course_id] ?? [];
                                        @endphp

                                        @if (empty($courseClasses))
                                            <a href="{{ url('admin/classes/add-class?course_id=' . $student->course_id) }}"
                                                class=" btn btn-sm btn-primary">
                                                <i class="fa-solid fa-plus"></i> Tạo lớp học
                                            </a>
                                        @else
                                            <select name="class_id" class="form-select">
                                                @foreach ($courseClasses as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </td>

                                    {{-- <td>Lớp Toán 1</td>
                            <td><span class="badge bg-success">Đang học</span></td> --}}
                                    {{-- <td>
                                {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch
                                    học</a> 
                                <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                    Sửa</a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                            </td> --}}
                                    {{-- a href xếp lớp --}}
                                    <td>
                                        {{-- button lưu lớp --}}
                                        {{-- nếu contract_id chưa có thì tạo hợp đồng trước nếu có mới cho lưu lớp   --}}
                                        @if ($student->contract_id)
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                    class="fa-solid fa-floppy-disk"></i> Lưu
                                                lớp</button>
                                        @else
                                            <a href="{{ url('admin/contracts/add?student_profile_id=' . $student->student_profile_id . '&course_id=' . $student->course_id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa-solid fa-file-contract"></i> Tạo
                                                hợp đồng</a>
                                        @endif

                                    </td>
                                </form>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
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
            const table = document.getElementById("studentTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
