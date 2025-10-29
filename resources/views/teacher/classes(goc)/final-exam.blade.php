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

                        <!-- Tìm kiếm sinh viên -->
                        <input type="text" id="searchStudent" class="form-control" placeholder="Tìm kiếm..."
                            style="width: 200px; margin-left: 10px; margin-right: 10px;">

                        <form action="{{ url('teacher/final-exam/import') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $class->id }}">
                            <input type="file" name="file" class="form-control"
                                style="width: 200px; margin-right: 10px;" required>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-file-import"></i>
                                Import</button>
                        </form>

                        <a href="{{ url('teacher/final-exam/export/' . $class->id) }}" class="btn btn-secondary ms-2">
                            <i class="fa-solid fa-file-export"></i> Export
                        </a>


                        <a href="{{ url('teacher/classes/add-class') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Thêm mới
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bảng danh sách sinh viên -->
            <div class="table-responsive">
                <form id="attendanceForm" method="POST" action="{{ url('teacher/final-exam/update') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">


                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Mã sinh viên</th>
                                <th>Điểm đầu vào</th>
                                <th>Điểm đầu ra</th>
                            </tr>
                        </thead>
                        <tbody id="studentList">
                            @foreach ($class->studentProfiles as $index => $profile)
                                @php
                                    $student = $profile->student;
                                    $firstExam = $profile->testResults->firstWhere('result_status', 0);
                                    $lastExam = $profile->testResults->firstWhere('result_status', 1);
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->id }}</td>
                                    <td>
                                        <input type="text" name="exam-first[{{ $profile->id }}]"
                                            value="{{ $firstExam->total_score ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="exam-last[{{ $profile->id }}]"
                                            value="{{ $lastExam->total_score ?? '' }}">
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
@endsection
