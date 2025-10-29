@extends('admin.index')
@section('header-content')
    Chứng chỉ
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Tạo mới khóa học</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a id="backBtn" class="btn btn-light"> <i class="fa-solid fa-arrow-left"></i>
                                Quay lại</a>

                            {{-- <a href="#" class="btn btn-primary"><i class="fa-solid fa-check"></i> Lưu</a> --}}
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
                    <div class="col-md-8">
                        <h5>Thông tin chứng chỉ</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Mã chứng chỉ</th>
                                    <th>Loại chứng chỉ</th>
                                    <th>File test đầu vào</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $stt = 1; @endphp
                                @foreach ($certificates as $certificate)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
                                        <td>{{ $certificate->language->name ?? '—' }}</td>
                                        <td>{{ $certificate->code }}</td>
                                        <td>{{ $certificate->name }}</td>

                                        {{-- Hiển thị file PDF --}}
                                        <td>
                                            @if ($certificate->entranceExams && $certificate->entranceExams->pdf_test_file)
                                                <a href="{{ asset($certificate->entranceExams->pdf_test_file) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-success">
                                                    <i class="fa-solid fa-file-pdf"></i> Xem file
                                                </a>
                                            @else
                                                <span class="text-muted">Chưa có file</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{-- Nút Sửa --}}
                                            <a href="#" class="btn btn-sm btn-primary edit-btn"
                                                data-id="{{ $certificate->id }}"
                                                data-language="{{ $certificate->language_id }}"
                                                data-code="{{ $certificate->code }}" data-name="{{ $certificate->name }}">
                                                <i class="fa-solid fa-pen-to-square"></i> Sửa
                                            </a>

                                            {{-- Nút Xóa --}}
                                            <form action="{{ url('/admin/settings/certificates/delete/') }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="certificate_id" value="{{ $certificate->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa chứng chỉ này?')">
                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1"></div>

                                <div class="col-md-11">
                                    <form action="{{ url('/admin/settings/certificates/add') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{-- -Thêm ngôn ngữ --}}
                                        <label for="chon_ngon_ngu" class="form-label">
                                            Chọn ngôn ngữ <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select mb-3" aria-label="Default select example"
                                            name="language_id" required>
                                            <option value="">Chọn ngôn ngữ</option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>

                                        {{-- -Thêm mã chứng chỉ --}}
                                        <label for="ma_chung_chi" class="form-label">
                                            Mã chứng chỉ <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control mb-3" name="certificate_code"
                                            id="ma_chung_chi" required>

                                        {{-- -Thêm loại chứng chỉ --}}
                                        <label for="loai_chung_chi" class="form-label">
                                            Loại chứng chỉ <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control mb-3" name="certificate_name"
                                            id="loai_chung_chi" required>

                                        {{-- -Thêm file test đầu vào --}}
                                        <label for="file_test" class="form-label">
                                            File test đầu vào (PDF) <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" class="form-control mb-3" name="entrance_exam" id="file_test"
                                            accept="application/pdf" required>

                                        {{-- -Nút thêm mới --}}
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-plus"></i> Thêm mới
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal chỉnh sửa chứng chỉ -->
    <div class="modal fade" id="editCertificateModal" tabindex="-1" aria-labelledby="editCertificateLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('admin/settings/certificates/update') }}" method="POST" id="editCertificateForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCertificateLabel">
                            <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa chứng chỉ
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="certificate_id" id="edit_certificate_id">

                        <!-- Ngôn ngữ -->
                        <div class="mb-3">
                            <label for="edit_language_id" class="form-label">
                                Ngôn ngữ <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="language_id" id="edit_language_id" required>
                                <option value="">Chọn ngôn ngữ</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mã chứng chỉ -->
                        <div class="mb-3">
                            <label for="edit_certificate_code" class="form-label">
                                Mã chứng chỉ <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_certificate_code"
                                name="certificate_code" required>
                        </div>

                        <!-- Tên chứng chỉ -->
                        <div class="mb-3">
                            <label for="edit_certificate_name" class="form-label">
                                Tên chứng chỉ <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_certificate_name"
                                name="certificate_name" required>
                        </div>

                        <!-- File test đầu vào -->
                        <div class="mb-3">
                            <label for="edit_entrance_exam" class="form-label">
                                Cập nhật file test đầu vào (PDF)
                            </label>
                            <input type="file" class="form-control" id="edit_entrance_exam" name="entrance_exam"
                                accept="application/pdf">
                            <small class="text-muted">Để trống nếu không muốn thay đổi file cũ</small>
                        </div>

                        <!-- Hiển thị file hiện tại -->
                        <div id="currentFilePreview" class="mt-2" style="display:none;">
                            <label class="form-label">File hiện tại:</label>
                            <a href="#" target="_blank" id="currentFileLink" class="d-block text-primary fw-bold">
                                Xem file cũ
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-btn");

            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.dataset.id;
                    const language = this.dataset.language;
                    const code = this.dataset.code;
                    const name = this.dataset.name;

                    document.getElementById("edit_certificate_id").value = id;
                    document.getElementById("edit_language_id").value = language;
                    document.getElementById("edit_certificate_code").value = code;
                    document.getElementById("edit_certificate_name").value = name;

                    const modal = new bootstrap.Modal(document.getElementById(
                        "editCertificateModal"));
                    modal.show();
                });
            });
        });
    </script>
@endsection
