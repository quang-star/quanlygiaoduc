@extends('admin.index')
@section('header-content')
    Quản lý ca học
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Quản lý ca học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a id="backBtn" class="btn btn-light">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <div class="col-md-12">
                <div class="row">
                    <!-- Bảng danh sách ca học -->
                    <div class="col-md-8">
                        <h5>Danh sách ca học</h5>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    {{-- <th>Tên ca học</th> --}}
                                    <th>Giờ bắt đầu</th>
                                    <th>Giờ kết thúc</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $stt = 1; @endphp
                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
                                        {{-- <td>{{ $shift->name }}</td> --}}
                                        <td>{{ $shift->start_time }}</td>
                                        <td>{{ $shift->end_time }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-shift"
                                                data-id="{{ $shift->id }}" data-name="{{ $shift->name }}"
                                                data-start="{{ $shift->start_time }}" data-end="{{ $shift->end_time }}"
                                                data-bs-toggle="modal" data-bs-target="#editShiftModal">
                                                <i class="fa-solid fa-pen"></i> Sửa
                                            </button>

                                            <form action="{{ url('/admin/settings/shifts/delete') }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc muốn xóa ca học này?')">
                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Form thêm ca học -->
                    <div class="col-md-4">
                        <h5>Thêm mới ca học</h5>
                        <form action="{{ url('/admin/settings/shifts/add') }}" method="POST">
                            @csrf
                            {{-- <div class="mb-3">
                                <label for="name" class="form-label">Tên ca học</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div> --}}

                            <div class="mb-3">
                                <label for="start_time" class="form-label">Giờ bắt đầu</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>

                            <div class="mb-3">
                                <label for="end_time" class="form-label">Giờ kết thúc</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="fa-solid fa-plus"></i> Thêm mới
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa ca học -->
    <div class="modal fade" id="editShiftModal" tabindex="-1" aria-labelledby="editShiftLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editShiftForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="shift_id" id="shift_id" value="">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="editShiftLabel">
                            <i class="fa-solid fa-pen"></i> Chỉnh sửa ca học
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="mb-3">
            <label for="edit_shift_name" class="form-label">Tên ca học <span class="text-danger">*</span></label>
            <input type="text" id="edit_shift_name" name="name" class="form-control" required>
        </div> --}}
                        <div class="mb-3">
                            <label for="edit_start_time" class="form-label">Giờ bắt đầu <span
                                    class="text-danger">*</span></label>
                            <input type="time" id="edit_start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_time" class="form-label">Giờ kết thúc <span
                                    class="text-danger">*</span></label>
                            <input type="time" id="edit_end_time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fa-solid fa-check"></i> Cập nhật
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit-shift');
            const form = document.getElementById('editShiftForm');
            const idInput = document.getElementById('shift_id');
            //const nameInput = document.getElementById('edit_shift_name');
            const startInput = document.getElementById('edit_start_time');
            const endInput = document.getElementById('edit_end_time');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    idInput.value = this.dataset.id;
                    // nameInput.value = this.dataset.name;
                    startInput.value = this.dataset.start;
                    endInput.value = this.dataset.end;
                    form.action = "{{ url('/admin/settings/shifts/update') }}";
                });
            });
        });
    </script>
@endsection
