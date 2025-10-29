@extends('teacher.index')
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
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            {{-- <a href="{{ url('teacher/classes/add-class') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <table class="table table-bordered" id="teacherTable">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Mã lớp học</th>
                        <th>Tên lớp học</th>
                        <th>Khóa học</th>
                        
                        <th>Thời gian dạy</th>
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
                            {{-- <td>{{ $class->teacher->name ?? '' }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($class->start_date)->format('d/m/Y') . '-' . \Carbon\Carbon::parse($class->end_date)->format('d/m/Y') }}</td>
                            <td>
                        @php
                        $schedule = json_decode($class->schedule, true);
                        @endphp

                        @if(!empty($schedule))
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
                             
                                <a href="{{ url('teacher/class-details/' . $class->id) }}"
                                    class="btn btn-sm btn-success">
                                    <i class="fa-solid fa-check"></i> Điểm danh
                                </a>
                                <a href="{{ url('teacher/final-exam/index/' . $class->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i> Nhập điểm
                                </a>








                            </td>
                        </tr>
                    @endforeach
                    <!-- Thêm các dòng dữ liệu khác tại đây -->

            </table>
        </div>
    </div>


     <script>
      

        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("teacherTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
