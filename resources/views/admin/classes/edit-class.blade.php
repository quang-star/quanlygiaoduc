@extends('admin.index')
@section('header-content')
    lớp học

    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center" style="margin-bottom: 50px;">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Thông tin lớp học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="{{ url('/admin/classes') }}" class="btn btn-light"> <i
                                    class="fa-solid fa-arrow-left"></i>
                                Quay lại</a>

                            <button type="submit" form="form-edit-class" class="btn btn-primary"
                                style="margin-left: 10px;">
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

            <form id="form-edit-class" action="{{ url('admin/classes/update/' . $class->id) }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Cột trái --}}
                    <div class="col-md-8">
                        {{-- Lịch học --}}
                        <h5><i class="fa-solid fa-calendar-days"></i> Lịch học</h5>
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
                                <tbody id="scheduleBody">
                                    @forelse (json_decode($class->schedule, true) ?? [] as $item)
                                        <tr>
                                            <td>
                                                <select name="schedule[]" class="form-select">
                                                    @foreach (['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'] as $day)
                                                        <option value="{{ $day }}" @selected($item['day'] == $day)>
                                                            {{ $day }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="shift_id[]" class="form-select">
                                                    <option value="">-- Chọn ca học --</option>
                                                    @foreach ($shifts as $shift)
                                                        <option value="{{ $shift->id }}" @selected($item['shift'] == $shift->id)>
                                                            {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                                                            {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger btn-remove-row">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Chưa có lịch học</td>
                                        </tr>
                                    @endforelse
                                </tbody>


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
                            <tbody>
                                @foreach ($selectedStudents as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->phone_number }}</td>
                                        <td><button type="button" class="btn btn-danger btn-sm remove-student"><i
                                                    class="fa fa-trash"></i></button></td>
                                        @if (isset($student->id))
                                            <input type="hidden" name="students[]" value="{{ $student->id }}">
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Ghi chú --}}
                        <h5>Ghi chú</h5>
                        <textarea name="note" rows="3" class="form-control">{{ $class->note }}</textarea>
                    </div>

                    {{-- Cột phải --}}
                    <div class="col-md-4">
                        <h5 class="mt-3">Tên lớp</h5>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $class->name ?? '') }}" required>

                        <h5 class="mt-3">Ngày khai giảng</h5>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', \Carbon\Carbon::parse($class->start_date)->format('Y-m-d')) }}"
                            required>

                        <h5 class="mt-3">Ngày kết thúc</h5>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', $class->end_date ? \Carbon\Carbon::parse($class->end_date)->format('Y-m-d') : '') }}">

                        <h5 class="mt-3">Khóa học</h5>
                        <select name="course_id" id="courseSelect" class="form-select" required>
                            <option value="">-- Chọn khóa học --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ $class->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>

                        <h5 class="mt-3">Giáo viên</h5>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- Chọn giáo viên --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>

                        <h5 class="mt-3">Tổng số buổi học</h5>
                        <input type="number" name="total_lesson" class="form-control"
                            value="{{ old('total_lesson', $class->total_lesson ?? '') }}">

                        <h5 class="mt-3">Số buổi học/tuần</h5>
                        <input type="number" name="lesson_per_week" class="form-control"
                            value="{{ old('lesson_per_week', $class->lesson_per_week ?? '') }}">

                        <h5 class="mt-3">Sĩ số tối thiểu</h5>
                        <input type="number" name="min_student" class="form-control"
                            value="{{ old('min_student', $class->min_student ?? '') }}">

                        <h5 class="mt-3">Sĩ số tối đa</h5>
                        <input type="number" name="max_student" class="form-control"
                            value="{{ old('max_student', $class->max_student ?? '') }}">


                        <h5 class="mt-3">Tình trạng</h5>
                        <select name="status" class="form-select">
                            <option value="{{ \App\Models\ClassModel::SCHEDULED }}"
                                @if ($class->status == \App\Models\ClassModel::SCHEDULED) selected @endif>Chưa khai giảng</option>
                            <option value="{{ \App\Models\ClassModel::RUNNING }}"
                                @if ($class->status == \App\Models\ClassModel::RUNNING) selected @endif>Đang học</option>
                            <option value="{{ \App\Models\ClassModel::COMPLETED }}"
                                @if ($class->status == \App\Models\ClassModel::COMPLETED) selected @endif>Đã hoàn thành</option>
                            <option value="{{ \App\Models\ClassModel::CANCELLED }}"
                                @if ($class->status == \App\Models\ClassModel::CANCELLED) selected @endif>Đã hủy</option>
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
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="student-checkbox" value="{{ $student->id }}"
                                            data-name="{{ $student->name }}" data-phone="{{ $student->phone_number }}"
                                            {{ in_array($student->id, $studentIdsInClass) ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveStudents">Lưu học viên</button>
                </div>
            </div>
        </div>
    </div>
    <!-- script chọn học viên -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentsTableBody = document.querySelector('#studentsTable tbody');
            const selectedTableBody = document.querySelector('#selectedStudentsTable tbody');
            const saveBtn = document.getElementById('saveStudents');
            const selectAll = document.getElementById('selectAll');
            const studentModal = document.getElementById('studentModal');

            const allStudents = [
                ...@json($students),
                ...@json($selectedStudents)
            ];

            let selectedIds = @json($selectedStudents->pluck('id'));

            /** ==========================
             *  HÀM GẮN SỰ KIỆN CHO CHECKBOX
             *  ========================== */
            function initCheckboxEvents() {
                studentsTableBody.querySelectorAll('.student-checkbox').forEach(cb => {
                    const tr = cb.closest('tr');
                    tr.style.opacity = '1';
                    tr.style.pointerEvents = 'auto';

                    if (cb.checked) tr.classList.add('table-success');
                    else tr.classList.remove('table-success');

                    // 🔹 Khi checkbox thay đổi
                   // cb.addEventListener('change', function() {
                        const existingInput = document.querySelector(
                            `input[name="students[]"][value="${cb.value}"]`
                        );

                        if (cb.checked) {
                            tr.classList.add('table-success');
                            // Nếu chưa có input ẩn cho học viên này → thêm vào form
                            if (!existingInput) {
                                const hidden = document.createElement('input');
                                hidden.type = 'hidden';
                                hidden.name = 'students[]';
                                hidden.value = cb.value;
                                document.getElementById('form-edit-class').appendChild(hidden);
                            }
                        } else {
                            tr.classList.remove('table-success');
                            // Nếu bỏ chọn → xóa input ẩn tương ứng
                            if (existingInput) existingInput.remove();
                        }
                    //});
                });
            }


            /** ✅ Khi mở modal lại → gắn lại event cho checkbox */
            studentModal.addEventListener('show.bs.modal', function() {
                setTimeout(initCheckboxEvents, 50);
            });

            /** ✅ Chọn tất cả */
            selectAll.addEventListener('change', function() {
                const checkboxes = studentsTableBody.querySelectorAll('.student-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    cb.dispatchEvent(new Event('change'));
                });
            });

            /** ✅ Lưu học viên */
            saveBtn.addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
                const newSelectedIds = Array.from(checkedBoxes).map(cb => Number(cb.value));

                const existingIds = Array.from(selectedTableBody.querySelectorAll(
                        'input[name="students[]"]'))
                    .map(input => Number(input.value));

                const toAdd = newSelectedIds.filter(id => !existingIds.includes(id));
                const selectedStudents = allStudents.filter(s => toAdd.includes(Number(s.id)));

                // 🔸 Lấy max_student từ input
                const maxStudentInput = document.querySelector('input[name="max_student"]');
                const maxStudent = parseInt(maxStudentInput?.value || 0);

                // 🔸 Kiểm tra chưa nhập max_student
                if (!maxStudent) {
                    alert('Vui lòng nhập thông tin lớp học (sĩ số tối đa) trước khi chọn học viên!');
                    return;
                }

                // 🔸 Kiểm tra vượt quá số lượng tối đa
                const currentSelectedCount = selectedTableBody.querySelectorAll('tr').length;
                const totalAfterAdd = currentSelectedCount + toAdd.length;

                if (totalAfterAdd > maxStudent) {
                    const canAdd = maxStudent - currentSelectedCount;
                    alert(`❌ Số học viên vượt quá giới hạn (${maxStudent}).
Hiện đã có ${currentSelectedCount}, bạn chỉ có thể thêm tối đa ${canAdd > 0 ? canAdd : 0} học viên nữa.`);
                    return;
                }

                // Nếu có chọn thì mới xóa và thêm lại
                selectedTableBody.innerHTML = '';

                // 🔸 Thêm vào bảng chính
                selectedStudents.forEach(student => {
                    const tr = document.createElement('tr');
                    const newIndex = selectedTableBody.querySelectorAll('tr').length + 1;
                    tr.innerHTML = `
                    <td>${newIndex}</td>
                    <td>${student.name}</td>
                    <td>${student.phone_number}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-student"><i class="fa fa-trash"></i></button></td>
                    <input type="hidden" name="students[]" value="${student.id}">
                `;
                    selectedTableBody.appendChild(tr);
                });

                // Ẩn modal
                const modal = bootstrap.Modal.getInstance(studentModal) || new bootstrap.Modal(
                    studentModal);
                modal.hide();

                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                }, 200);
            });

            /** ✅ Xóa học viên khỏi bảng chính */
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-student')) {
                    const tr = e.target.closest('tr');
                    const id = Number(tr.querySelector('input[name="students[]"]').value);
                    selectedIds = selectedIds.filter(i => i !== id);
                    tr.remove();

                    Array.from(selectedTableBody.querySelectorAll('tr')).forEach((row, idx) => {
                        row.querySelector('td:first-child').textContent = idx + 1;
                    });

                    const cb = studentsTableBody.querySelector(`.student-checkbox[value="${id}"]`);
                    if (cb) {
                        cb.checked = false;
                        cb.dispatchEvent(new Event('change'));
                    }
                }
            });

            /** ✅ CSS fix chắc chắn lỗi mờ (chèn vào runtime luôn) */
            const style = document.createElement('style');
            style.textContent = `
            #studentsTable tr.table-success {
                background-color: #d4edda !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }
            #studentsTable td, #studentsTable input {
                pointer-events: auto !important;
            }
        `;
            document.head.appendChild(style);

            // ✅ Khởi tạo lần đầu
            initCheckboxEvents();
        });
    </script>

    <!-- script lịch học -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addRow');
            const tbody = document.getElementById('scheduleBody');
            const lessonPerWeekInput = document.querySelector('input[name="lesson_per_week"]');

            if (!addBtn) return;

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
                        {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
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

                newRow.querySelector('.btn-remove-row').addEventListener('click', () => newRow.remove());
            });
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
