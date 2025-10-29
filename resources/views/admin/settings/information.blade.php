@extends('admin.index')

@section('header-content')
    Cài đặt
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90 bg-white p-3 rounded shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h4><i class="fa-solid fa-gear"></i> Cài đặt chung</h4>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <a id="backBtn" href="{{ url()->previous() }}" class="btn btn-light">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 d-flex justify-content-center mt-4">
        <div class="w-90 bg-white p-4 rounded shadow-sm">

            <form action="{{ url('admin/settings/informations/update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Tên trung tâm --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <strong>Tên trung tâm / website <span style="color: red">*</span></strong>
                        </label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                            class="form-control" placeholder="Nhập tên trung tâm" required>
                    </div>

                    {{-- Màu sidebar --}}
                    <div class="col-md-6 mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">
                                        <strong>Chọn màu sidebar <span style="color: red">*</span></strong>
                                    </label>
                                    <input type="color" id="colorSidebarPicker"
                                        value="{{ old('color_sidebar', $settings['color_sidebar'] ?? '#ffffff') }}"
                                        class="form-control" style="height: 40px; width: 100%;" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        <strong>Mã màu <span style="color: red">*</span></strong>
                                    </label>
                                    <input type="text" id="colorSidebarCode" name="color_sidebar"
                                        value="{{ old('color_sidebar', $settings['color_sidebar'] ?? '#ffffff') }}"
                                        class="form-control" style="height: 40px;" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label"><strong>Xem trước</strong></label>
                                    <div id="colorSidebarPreview"
                                        style="height: 40px; width: 100%; border: 1px solid #ccc; background-color: {{ old('color_sidebar', $settings['color_sidebar'] ?? '#ffffff') }};">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Script đổi màu --}}
                    <script>
                        const picker = document.getElementById('colorSidebarPicker');
                        const code = document.getElementById('colorSidebarCode');
                        const preview = document.getElementById('colorSidebarPreview');

                        picker.addEventListener('input', function() {
                            code.value = this.value;
                            preview.style.backgroundColor = this.value;
                        });

                        code.addEventListener('input', function() {
                            const val = this.value;
                            if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                                picker.value = val;
                                preview.style.backgroundColor = val;
                            }
                        });
                    </script>
                </div>

                <div class="row">
                    {{-- Logo --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <strong>Logo <span style="color: red">*</span></strong>
                        </label>
                        <div class="d-flex flex-column">
                            <input type="file" name="logo" class="form-control mb-2" accept="image/*"
                                onchange="previewImage(this, 'logoPreview')" >
                            <img id="logoPreview" src="{{ asset($settings['logo'] ?? 'images/default-logo.png') }}"
                                height="120" class="border rounded mx-auto d-block">
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <strong>Favicon <span style="color: red">*</span></strong>
                        </label>
                        <div class="d-flex flex-column">
                            <input type="file" name="favicon" class="form-control mb-2" accept="image/*"
                                onchange="previewImage(this, 'faviconPreview')" >
                            <img id="faviconPreview" src="{{ asset($settings['favicon'] ?? 'images/default-favicon.png') }}"
                                height="80" class="border rounded mx-auto d-block">
                        </div>
                    </div>
                </div>

                {{-- Nút lưu --}}
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-check"></i> Lưu thay đổi
                    </button>
                </div>
            </form>

        </div>
    </div>

    <div class="col-md-12 d-flex justify-content-center mt-4">
        <div class="w-90 bg-white p-3 rounded shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Tài khoản nhận tiền</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Ngân hàng</th>
                                        <th>Số tài khoản</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bankAccounts as $key => $bankAccount)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $bankAccount->bank }}</td>
                                            <td>{{ $bankAccount->account_number }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editBankModal" data-id="{{ $bankAccount->id }}"
                                                    data-bank="{{ $bankAccount->bank }}"
                                                    data-account="{{ $bankAccount->account_number }}">
                                                    Sửa
                                                </button>
                                                <form action="{{ url('admin/settings/bank-accounts/delete') }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="bank_account_id"
                                                        value="{{ $bankAccount->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h4>Thêm mới tài khoản</h4>
                            <form action="{{ url('admin/settings/bank-accounts/add') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">
                                        Ngân hàng <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="bank" class="form-control" required
                                        placeholder="Nhập tên ngân hàng">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Số tài khoản <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="account_number" class="form-control" required
                                        placeholder="Nhập số tài khoản">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Lưu
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Sửa --}}
    <div class="modal fade" id="editBankModal" tabindex="-1" aria-labelledby="editBankModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBankForm" method="POST">
                    @csrf
                    <input type="hidden" name="bank_account_id" value="" id="bank_account_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editBankModalLabel">Sửa tài khoản ngân hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">
                                Ngân hàng <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="bank" id="editBank" class="form-control" required
                                placeholder="Nhập tên ngân hàng">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Số tài khoản <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="account_number" id="editAccount" class="form-control" required
                                placeholder="Nhập số tài khoản">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(previewId).src = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        // Khi modal mở lên, điền dữ liệu vào form
        var editBankModal = document.getElementById('editBankModal')
        editBankModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')
            var bank = button.getAttribute('data-bank')
            var account = button.getAttribute('data-account')

            var modal = this
            modal.querySelector('#editBank').value = bank
            modal.querySelector('#editAccount').value = account
            modal.querySelector('#bank_account_id').value = id
            // Update action của form
            modal.querySelector('#editBankForm').action = "{{ url('admin/settings/bank-accounts/update') }}";
        })
    </script>
@endsection
