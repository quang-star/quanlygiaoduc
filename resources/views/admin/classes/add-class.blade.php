@extends('admin.index')
@section('header-content')
    Lớp học

    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center" style="margin-bottom: 50px;">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Tạo mới lớp học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="{{ url('/admin/classes') }}" class="btn btn-light"> <i
                                    class="fa-solid fa-arrow-left"></i>
                                Quay lại</a>

                            <button class="btn btn-primary" id="saveBtn">
                                <i class="fa-solid fa-check"></i> Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- Hiển thị message lỗi hoặc success --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

            <form id="form-create-class" action="{{ url('admin/classes/store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Cột trái --}}
                    <div class="col-md-8">

                        {{-- Lịch học --}}
                        <h5><i class="fa-solid fa-calendar-days"></i> Lịch học <span style="color: red">*</span></h5>
                        <div class="table-scroll-wrapper mb-4">
                            <table class="table table-bordered align-middle table-class-schedule">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">
                                            Thứ
                                            <button type="button" class="btn btn-outline-primary btn-circle-add-session"
                                                id="addRow" title="Thêm lịch học">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                        <th class="text-center">Ca học</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="scheduleBody"></tbody>
                            </table>
                        </div>

                        {{-- Danh sách học viên --}}
                        <h5><i class="fa fa-users"></i> Danh sách học viên</h5>
                        <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#studentModal">
                            <i class="fa fa-plus"></i> Chọn học viên
                        </button>

                        <table class="table table-striped" id="selectedStudentsTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Học viên</th>
                                    <th>Số điện thoại</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        {{-- Ghi chú --}}
                        <h5>Ghi chú</h5>
                        <textarea name="note" rows="3" class="form-control"></textarea>
                    </div>

                    {{-- Cột phải --}}
                    <div class="col-md-4">
                        <h5>Tên lớp <span style="color: red">*</span></h5>
                        <input type="text" name="name" class="form-control" required>

                        <h5 class="mt-3">Ngày khai giảng <span style="color: red">*</span></h5>
                        <input type="date" name="start_date" class="form-control" required>

                        <h5 class="mt-3">Ngày kết thúc</h5>
                        <input type="date" name="end_date" class="form-control">

                        <h5 class="mt-3">Khóa học <span style="color: red">*</span></h5>
                        <select name="course_id" id="courseSelect" class="form-select" required>
                            <option value="">-- Chọn khóa học --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>

                        <h5 class="mt-3">Giáo viên <span style="color: red">*</span></h5>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- Chọn giáo viên --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>

                        <h5 class="mt-3">Tổng số buổi học <span style="color: red">*</span></h5>
                        <input type="number" name="total_lesson" class="form-control" required>

                        <h5 class="mt-3">Số buổi học/tuần</h5>
                        <input type="number" name="lesson_per_week" class="form-control">

                        <h5 class="mt-3">Sĩ số tối thiểu</h5>
                        <input type="number" name="min_student" class="form-control">

                        <h5 class="mt-3">Sĩ số tối đa</h5>
                        <input type="number" name="max_student" class="form-control">

                        <h5 class="mt-3">Tình trạng <span style="color: red">*</span></h5>
                        <select name="status" class="form-select" required>
                            <option value="{{ \App\Models\ClassModel::SCHEDULED }}">Đang tuyển sinh</option>
                            <option value="{{ \App\Models\ClassModel::RUNNING }}">Đang học</option>
                            <option value="{{ \App\Models\ClassModel::COMPLETED }}">Đã hoàn thành</option>
                            <option value="{{ \App\Models\ClassModel::CANCELLED }}">Đã hủy</option>
                        </select>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- Modal chọn học viên --}}
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Danh sách học viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="studentsTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Tên</th>
                                <th>SĐT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- @foreach ($students as $student)
    <tr>
                                <td><input type="checkbox" class="student-checkbox" value="{{ $student->id }}"
                                        data-name="{{ $student->name }}" data-phone="{{ $student->phone_number }}">
                                </td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone_number }}</td>
                            </tr>
    @endforeach -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveStudents">Lưu học viên</button>
                </div>
            </div>
        </div>
    </div>
        <script>
        document.getElementById('saveBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('form-create-class');
            if (form.checkValidity()) {
                form.submit();
            } else {
                form.reportValidity(); // Hiện thông báo lỗi HTML5
            }
        });
    </script>
    <!-- script chọn học viên -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentsTableBody = document.querySelector('#studentsTable tbody');
            const selectedTableBody = document.querySelector('#selectedStudentsTable tbody');
            const saveBtn = document.getElementById('saveStudents');
            const selectAll = document.getElementById('selectAll');
            const courseSelect = document.getElementById('courseSelect');

            const allStudents = @json($students);

            // Giữ danh sách id đã chọn
            let selectedIds = [];

            // Hàm render danh sách học viên trong modal dựa trên course
            function renderStudents() {
                const selectedCourseId = parseInt(courseSelect.value);
                studentsTableBody.innerHTML = '';

                if (!selectedCourseId) return;

                const filtered = allStudents.filter(s => s.course_id === selectedCourseId);
                // console.log('Học viên thuộc khóa học', selectedCourseId, filtered);


                filtered.forEach(student => {
                    const tr = document.createElement('tr');
                    const isChecked = selectedIds.includes(student.id) ? 'checked' : '';
                    tr.innerHTML = `
                <td><input type="checkbox" class="student-checkbox" value="${student.id}" data-name="${student.name}" data-phone="${student.phone_number}" ${isChecked}></td>
                <td>${student.name}</td>
                <td>${student.phone_number}</td>
            `;
                    studentsTableBody.appendChild(tr);
                });
            }

            // Khi đổi khóa học, render lại danh sách
            courseSelect.addEventListener('change', renderStudents);

            // Chọn tất cả checkbox
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.student-checkbox');
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            // Lưu học viên đã chọn
            saveBtn.addEventListener('click', function() {
                const checkboxes = studentsTableBody.querySelectorAll('.student-checkbox');
                const selectedInModal = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => parseInt(cb.value));

                const maxStudentInput = document.querySelector('input[name="max_student"]');
                const maxStudent = parseInt(maxStudentInput?.value || 0);

                // Số lượng hiện tại đã có trong bảng chính
                const currentSelectedCount = selectedTableBody.querySelectorAll('tr').length;
                const totalAfterAdd = currentSelectedCount + selectedInModal.length;

                // Kiểm tra chưa nhập max_student
                if (!maxStudent) {
                    alert('Vui lòng nhập thông tin lớp học trước khi chọn học viên!');
                    return;
                }

                // Nếu vượt quá sĩ số
                if (totalAfterAdd > maxStudent) {
                    //                 alert(`Số học viên vượt quá giới hạn (${maxStudent}). 
                // Hiện có ${currentSelectedCount}, bạn chỉ có thể thêm tối đa ${maxStudent - currentSelectedCount} học viên nữa.`);
                    alert('Số học viên vượt quá giới hạn (${maxStudent}');
                    return;
                }

                // Ghi đè danh sách id đã chọn
                selectedIds = selectedInModal;

                // Render lại bảng học viên chính
                selectedTableBody.innerHTML = '';
                let index = 1;

                selectedIds.forEach(id => {
                    const student = allStudents.find(s => s.id === id);
                    if (!student) return;

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
            <td>${index++}</td>
            <td>${student.name}</td>
            <td>${student.phone_number}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-student">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            <input type="hidden" name="students[]" value="${student.id}">
        `;
                    selectedTableBody.appendChild(tr);
                });

                // Đóng modal
                const modalElement = document.getElementById('studentModal');
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                modalElement);
                modal.hide();

                // Xóa backdrop bị kẹt nếu có
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = ''; // phục hồi scroll
            });



            // Xóa học viên đã chọn trong bảng chính
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-student')) {
                    const tr = e.target.closest('tr');
                    const hiddenInput = tr.querySelector('input[name="students[]"]');
                    const id = parseInt(hiddenInput.value);
                    selectedIds = selectedIds.filter(i => i !== id);
                    tr.remove();
                }
            });

        });
    </script>

    <!-- script chọn lịch học -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addRow');
            const tbody = document.getElementById('scheduleBody');
            const lessonPerWeekInput = document.querySelector('input[name="lesson_per_week"]');

            if (!addBtn) return; // nếu không có nút thì thoát

            addBtn.addEventListener('click', function() {
                const currentRows = tbody.querySelectorAll('tr').length;
                const maxLessonsPerWeek = parseInt(lessonPerWeekInput?.value) || 0;

                if (maxLessonsPerWeek > 0 && currentRows >= maxLessonsPerWeek) {
                    alert(`Không thể thêm quá ${maxLessonsPerWeek} ca học trong một tuần!`);
                    return;
                }
                const shiftOptions = `
                <option value="">-- Chọn ca học --</option>
                @foreach ($shifts as $shift)
                    <option value="{{ $shift->id }}">
                        {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                    </option>
                @endforeach
            `;
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td>
                    <select name="schedule[]" class="form-select">
                        <option value="Thứ 2">Thứ 2</option>
                        <option value="Thứ 3">Thứ 3</option>
                        <option value="Thứ 4">Thứ 4</option>
                        <option value="Thứ 5">Thứ 5</option>
                        <option value="Thứ 6">Thứ 6</option>
                        <option value="Thứ 7">Thứ 7</option>
                        <option value="Chủ nhật">Chủ nhật</option>
                    </select>
                </td>
                <td>
                    <select name="shift_id[]" class="form-select">
                        ${shiftOptions}
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-link text-danger btn-remove-row">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            `;
                tbody.appendChild(newRow);

                newRow.querySelector('.btn-remove-row').addEventListener('click', function() {
                    newRow.remove();
                });
            });
        });
    </script>


    <!-- Script render thông tin khóa học -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseSelect = document.getElementById('courseSelect');
            const totalLessonInput = document.querySelector('input[name="total_lesson"]');
            const lessonPerWeekInput = document.querySelector('input[name="lesson_per_week"]');
            const minStudentInput = document.querySelector('input[name="min_student"]');
            const maxStudentInput = document.querySelector('input[name="max_student"]');

            // Truyền toàn bộ courses từ PHP sang JS
            const coursesData = @json($courses);

            courseSelect.addEventListener('change', function() {
                const courseId = parseInt(this.value);
                const course = coursesData.find(c => c.id === courseId);

                if (course) {
                    totalLessonInput.value = course.total_lesson || '';
                    lessonPerWeekInput.value = course.lesson_per_week || '';
                    minStudentInput.value = course.min_student || '';
                    maxStudentInput.value = course.max_student || '';
                } else {
                    totalLessonInput.value = '';
                    lessonPerWeekInput.value = '';
                    minStudentInput.value = '';
                    maxStudentInput.value = '';
                }
            });
        });
    </script>
    <!-- Script lấy thông tin khóa học khi bấm nút Tạo lớp -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (isset($selectedCourse))
                // Gán khóa học được chọn
                document.querySelector("select[name='course_id']").value = "{{ $selectedCourse->id }}";

                // Tự động điền các thông tin
                document.querySelector("input[name='total_lesson']").value = "{{ $selectedCourse->total_lesson }}";
                document.querySelector("input[name='lesson_per_week']").value =
                    "{{ $selectedCourse->lesson_per_week }}";
                document.querySelector("input[name='min_student']").value = "{{ $selectedCourse->min_student }}";
                document.querySelector("input[name='max_student']").value = "{{ $selectedCourse->max_student }}";
            @endif
        });
    </script>


    <!-- <pre>{{ json_encode($students, JSON_PRETTY_PRINT) }}</pre> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .btn-circle-add-session {
            width: 28px;
            height: 28px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }

        .table-class-schedule select {
            min-width: 180px;
        }

        .table-scroll-wrapper {
            overflow-x: auto;
        }

        .table-class-schedule th,
        .table-class-schedule td {
            vertical-align: middle !important;
        }
    </style>
@endsection
