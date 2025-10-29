@extends('teacher.index')

@section('header-content')
    Lớp học - {{ $class->name }}
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

            <div class="row mb-3">
                <div class="col-md-4">
                    <h4><i class="fa-solid fa-table"></i> Danh sách sinh viên</h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end">
                        <!-- Ngày học -->
                        <input type="date" value="{{ $date }}" min="{{ $days[0] }}" max="{{ end($days) }}"
                            onchange="checkDayLearn(this.value)">

                        <!-- Tìm kiếm sinh viên -->
                        <input type="text" id="searchStudent" class="form-control" placeholder="Tìm kiếm..."
                            style="width: 200px; margin-left: 10px; margin-right: 10px;">

                        <button class="btn btn-secondary" style="margin-right: 10px;">
                            <i class="fa-solid fa-file-export"></i> Xuất file
                        </button>

                        <a href="{{ url('teacher/classes/add-class') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Thêm mới
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bảng danh sách sinh viên -->
            <div class="table-responsive">
                <form id="attendanceForm" method="POST" action="{{ url('teacher/class-detail/update') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="date" value="{{ $date }}">


                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Mã sinh viên</th>
                                <th>Điểm danh</th>
                                <th>Bài tập</th>
                            </tr>
                        </thead>
                        <tbody id="studentList">
                            @foreach ($class->studentProfiles as $index => $profile)
                                @php $student = $profile->student; @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        <input type="checkbox" name="attendance[{{ $profile->id }}]" value="1"
                                            {{ in_array($profile->id, $attendanceRecords) ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="assignment[{{ $profile->id }}]" value="1"
                                            {{ in_array($profile->id, $assignmentRecords) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <button type="submit" class="btn btn-success">Cập nhật tất cả</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS tìm kiếm sinh viên -->
    <script>
        document.getElementById('searchStudent').addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll('#studentList tr');
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const code = row.cells[2].textContent.toLowerCase();
                row.style.display = (name.includes(keyword) || code.includes(keyword)) ? '' : 'none';
            });
        });
    </script>

    <!-- JS kiểm tra ngày học hợp lệ -->
    <script>
        const days = @json($days);

        function checkDayLearn(selectedDate) {
            if (!days.includes(selectedDate)) {
                alert('Ngày này không có lịch học!');
                document.querySelector('input[type=date]').value = '{{ $date }}';
            } else {
                window.location.href = '?date=' + selectedDate;
            }
        }
    </script>
@endsection
