@extends('student.index')
@section('header-content')
    Lớp học
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
                            {{-- <form action="{{ url('student/class-learned/search') }}" method="GET" class="d-flex justify-content-end">
                            <input type="text" name="key_search" class="form-control" placeholder="Tìm kiếm..."
                                style="width: 200px; margin-right: 10px;"
                                value="{{ request('key_search') }}">
                        </form> --}}
                            <input id="searchInput" type="text" class="form-control" placeholder="Tìm nhanh..."
                                style="width: 200px; margin-right: 10px;" onkeyup="searchTable()">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <table class="table table-bordered" id="studentTable">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Tên lớp học</th>
                        <th>Khóa học</th>
                        <th>Giáo viên</th>
                        <th>Ngày khai giảng</th>
                        <th>Lịch học</th>
                        <th>Số buổi học</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $class)
                        <tr>
                            <td><input type="checkbox"></td>
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
                                <a href="{{ url('student/student-schedule/' . $class->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i> Lịch học
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

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
