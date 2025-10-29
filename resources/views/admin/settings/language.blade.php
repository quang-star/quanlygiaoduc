@extends('admin.index')
@section('header-content')
    Ngôn ngữ
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Ngôn ngữ</h4>
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
                        <h5>thông tin ngôn ngữ</h5>
                        <div class="col-md-12">
                            {{-- -table ngon_ngu --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã</th>
                                        <th>Tên ngôn ngữ</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $stt = 1; ?>
                                    @foreach ($languages as $language)
                                        <tr>
                                            <td>{{ $stt++ }}</td>
                                            <td>{{ $language->code }}</td>
                                            <td>{{ $language->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning btn-edit-language"
                                                    data-id="{{ $language->id }}" data-code="{{ $language->code }}"
                                                    data-name="{{ $language->name }}" data-bs-toggle="modal"
                                                    data-bs-target="#editLanguageModal">
                                                    <i class="fa-solid fa-pen"></i> Sửa
                                                </button>

                                                <form action="{{ url('/admin/settings/languages/delete/') }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="language_id" value="{{ $language->id }}">
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa ngôn ngữ này?')">
                                                        <i class="fa-solid fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <form action="{{ url('/admin/settings/languages/add') }}" method="POST">
                                        @csrf

                                        {{-- Mã ngôn ngữ --}}
                                        <label for="ma_ngon_ngu" class="form-label">
                                            Mã ngôn ngữ <span class="text-danger">*</span>
                                        </label>
                                        <input name="language_code" type="text" class="form-control mb-3"
                                            id="ma_ngon_ngu" required placeholder="Nhập mã ngôn ngữ (ví dụ: en, vi, jp)">

                                        {{-- Tên ngôn ngữ --}}
                                        <label for="them_ngon_ngu" class="form-label">
                                            Tên ngôn ngữ <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control mb-3" name="language_name"
                                            id="them_ngon_ngu" required
                                            placeholder="Nhập tên ngôn ngữ (ví dụ: Tiếng Việt, English)">

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

    <!-- Modal chỉnh sửa ngôn ngữ -->
    <div class="modal fade" id="editLanguageModal" tabindex="-1" aria-labelledby="editLanguageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editLanguageForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="language_id" id="language_id" value="">

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="editLanguageLabel">
                            <i class="fa-solid fa-pen"></i> Chỉnh sửa ngôn ngữ
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_language_code" class="form-label">
                                Mã ngôn ngữ <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="edit_language_code" name="language_code" class="form-control" required
                                placeholder="Nhập mã ngôn ngữ (ví dụ: en, vi, jp)">
                        </div>

                        <div class="mb-3">
                            <label for="edit_language_name" class="form-label">
                                Tên ngôn ngữ <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="edit_language_name" name="language_name" class="form-control"
                                required placeholder="Nhập tên ngôn ngữ (ví dụ: Tiếng Việt, English)">
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
            const editButtons = document.querySelectorAll('.btn-edit-language');
            const form = document.getElementById('editLanguageForm');
            const codeInput = document.getElementById('edit_language_code');
            const nameInput = document.getElementById('edit_language_name');
            const idInput = document.getElementById('language_id');
            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const code = this.getAttribute('data-code');
                    const name = this.getAttribute('data-name');

                    // Gán dữ liệu vào input
                    codeInput.value = code;
                    nameInput.value = name;
                    idInput.value = id;
                    // Gán action động cho form
                    form.action = "{{ url('/admin/settings/languages/update') }}";
                });
            });
        });
    </script>
@endsection
