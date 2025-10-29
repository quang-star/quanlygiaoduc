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
                            <a id="backBtn" class="btn btn-light"> <i class="fa-solid fa-arrow-left"></i>
                                Quay lại</a>
                            <a href="#" class="btn btn-primary"
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

                    <form class="col-md-8" id="studentForm" action="{{ url('/admin/students/edit') }}" accept=""
                        method="post">


                        @csrf
                        <div class="col-md-12">
                            <div class="row">

                                <input type="hidden" name="student_id" value="{{ $student->id ?? '' }}">
                                <div class="col-md-6 mb-3">
                                    <label for="ho_ten" class="form-label">Họ tên</label>
                                    <input type="text" name="ho_ten" class="form-control" id="ho_ten"
                                        placeholder="Nhập họ tên" value="{{ $student->name ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                        placeholder="Nhập số điện thoại" value="{{ $student->phone_number ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Nhập email"
                                        name="email" value="{{ $student->email ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                                    <input type="date" class="form-control" id="ngay_sinh" placeholder="Nhập ngày sinh"
                                        name="ngay_sinh" value="{{ $student->birthday ?? '' }}">
                                </div>
                                <div style="margin-top: 100px;"></div>
                                {{-- -ngôn ngữ --}}
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                    <select class="form-control" name="ngon_ngu" id="" required>
                                        <option value="1">Nhật</option>
                                        <option value="2">Trung</option>
                                    </select>
                                </div>
                                {{-- Chứng chỉ 
                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ</label>
                                    <select name="chung_chi" id="" class="form-control">
                                        <option value="1">TOEIC</option>
                                        <option value="2">ielts</option>
                                    </select>
                                </div> --}}
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
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <th>Khóa học</th>
                                    <th>Lớp học</th>
                                    <th>Thời gian học</th>
                                    <th>Điểm đầu vào</th>
                                    <th>Điểm đầu ra</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($students as $student)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $student->course_name }}</td>
                                        <td>{{ $student->class_name }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($student->start_date)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($student->end_date)->format('d/m/Y') }}
                                        </td>

                                        <td>{{ $student->entry_score ?? '' }}</td>
                                        <td>{{ $student->exit_score ?? '' }}</td>
                                        <td>
                                            @if ($student->status == 'active')
                                                <span class="badge bg-success">Đang tiến hành</span>
                                            @elseif ($student->status == 'completed')
                                                <span class="badge bg-primary">Hoàn thành</span>
                                            @else
                                                <span class="badge bg-secondary">Chưa bắt đầu</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#scoreModal" data-id="{{ $student->id }}"
                                                data-course="{{ $student->course_name }}"
                                                data-class="{{ $student->class_name }}"
                                                data-start="{{ $student->start_date }}"
                                                data-end="{{ $student->end_date }}"
                                                data-entry="{{ $student->entry_score ?? '' }}"
                                                data-exit="{{ $student->exit_score ?? '' }}"
                                                data-status="{{ $student->status }}"
                                                data-profile-id="{{ $student->student_profile_id }}">
                                                <i class="fa-solid fa-keyboard"></i> Nhập điểm
                                            </button>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- @foreach ($students as $student)
                            <div class="modal fade" id="scoreModal{{ $student->id }}" tabindex="-1"
                                aria-labelledby="scoreModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ url('admin/students/score/' . encrypt($student->id), $student->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="scoreModalLabel{{ $student->id }}">
                                                    Nhập điểm cho {{ $student->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Loại điểm</label>
                                                    <select class="form-select" name="role" required>
                                                        <option value="0">Điểm đầu vào</option>
                                                        <option value="1">Điểm đầu ra</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Điểm số</label>
                                                    <input type="number" name="total_score" class="form-control"
                                                        min="0" max="100" step="0.1"
                                                        placeholder="Nhập điểm..." required>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa-solid fa-floppy-disk"></i> Lưu điểm
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach --}}



                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="scoreModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="scoreForm" method="POST" action="{{ url('admin/students/update-score') }}">
                    @csrf
                    <input type="hidden" name="student_id" id="student_id">
                    <input type="hidden" name="student_profile_id" id="student_profile_id">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Cập nhật điểm học viên</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Khóa học</label>
                                    <input type="text" class="form-control" id="course_name" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Lớp học</label>
                                    <input type="text" class="form-control" id="class_name" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Thời gian học</label>
                                    <input type="text" class="form-control" id="time_range" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Trạng thái</label>
                                    <input type="text" class="form-control" id="status" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Điểm đầu vào</label>
                                    <input type="number" class="form-control" name="entry_score" id="entry_score"
                                        step="0.1" min="0">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Điểm đầu ra</label>
                                    <input type="number" class="form-control" name="exit_score" id="exit_score"
                                        step="0.1" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const scoreModal = document.getElementById('scoreModal');

                scoreModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;

                    document.getElementById('student_id').value = button.getAttribute('data-id');
                    document.getElementById('student_profile_id').value = button.getAttribute(
                        'data-profile-id');
                    document.getElementById('course_name').value = button.getAttribute('data-course');
                    document.getElementById('class_name').value = button.getAttribute('data-class');
                    document.getElementById('time_range').value =
                        button.getAttribute('data-start') + ' - ' + button.getAttribute('data-end');
                    document.getElementById('status').value = button.getAttribute('data-status');

                    document.getElementById('entry_score').value = button.getAttribute('data-entry');
                    document.getElementById('exit_score').value = button.getAttribute('data-exit');

                });
            });
        </script>
    @endsection
