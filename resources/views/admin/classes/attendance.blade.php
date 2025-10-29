@extends('admin.index')
@section('header-content')

        Lớp học

@endsection
@section('content')
{{-- Hiển thị message lỗi hoặc success --}}
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa-solid fa-table"></i> Điểm danh lớp học</h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end">
                        <input type="text" class="form-control" placeholder="Tìm kiếm..."
                            style="width: 200px; margin-right: 10px;">

                        <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                class="fa-solid fa-file-export"></i> Xuất file</button>
                        {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                        <button class="btn btn-primary" style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                            Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="col-md-12  d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
        <form action="{{ url('admin/classes/attendance/save/' . $class->id) }}" method="POST">
            @csrf
            <label for="chon_diem_danh" class="form-label">Lớp học</label>
            <select class="form-select mb-3" id="chon_diem_danh" disabled>
                <option selected value="{{ $class->id }}">{{ $class->class_name }}</option>
            </select>

            {{-- === Giáo viên === --}}
            <label for="_giao_vien" class="form-label">Giáo viên</label>
            <select class="form-select mb-3" id="_giao_vien" disabled>
                <option selected>{{ $teacherName ?? 'Chưa có giáo viên' }}</option>
            </select>

            {{-- === Trợ giảng === --}}
            <label for="trong_giang" class="form-label">Trợ giảng</label>
            <select class="form-select mb-3" id="trong_giang" disabled>
                <option selected>{{ $supporterName ?? 'Chưa có trợ giảng' }}</option>
            </select>

            {{-- === Danh sách học viên === --}}
            <h5 class="mt-4">Danh sách học viên</h5>
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">STT</th>
                        <th>Học viên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th style="width: 150px;">Số buổi vắng</th>
                        <th style="width: 150px;" class="text-center">Điểm danh</th>
                        <th style="width: 150px;" class="text-center">Bài tập</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->phone_number }}</td>
                        <td>{{ $student->email }}</td>
                        <!-- <td>0 buổi</td> {{-- placeholder, sau này có thể load từ bảng điểm danh --}} -->
                        <td>{{ $absentCounts[$student->id] ?? 0 }} buổi vắng</td>
                        <td class="text-center">
                            <div class="form-check d-inline-flex align-items-center justify-content-center">
                                <input class="form-check-input me-2"
                                    type="checkbox"
                                    name="attendance[{{ $student->id }}]"
                                    value="1"
                                    id="att_{{ $student->id }}"
                                    {{ in_array($student->id, $attendedStudents ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="att_{{ $student->id }}">
                                    Có mặt
                                </label>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="form-check d-inline-flex align-items-center justify-content-center">
                                <input class="form-check-input me-2"
                                    type="checkbox"
                                    name="exercise[{{ $student->id }}]"
                                    value="1"
                                    id="ex_{{ $student->id }}"
                                    {{ in_array($student->id, $checkedExercises ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ex_{{ $student->id }}">
                                    Hoàn thành
                                </label>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Chưa có học viên nào trong lớp này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <h5 class="mt-4">Ngày điểm danh</h5>
            <input type="date" name="date_implementation" id="date"
                class="form-control custom-date mb-3"
                value="{{ $attendanceDate }}">

            {{-- -button xác nhận điểm danh --}}
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Xác nhận điểm danh</button>
            </div>
        </form>
    </div>
</div>
@endsection