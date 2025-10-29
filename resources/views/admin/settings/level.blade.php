@extends('admin.index')
@section('header-content')
    Level
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Danh sách level</h4>
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
                        <h5>Thông tin level</h5>
                        <label for="tim_kiem">Lọc</label>
                        <select name="filter_language" id="filter_language" class="form-control mb-2"
                            style="width: 200px; display: inline-block;">
                            <option value="">-- Tất cả ngôn ngữ --</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Loại chứng chỉ</th>
                                    <th>Level</th>
                                    <th>Điểm đầu vào</th>
                                    <th>Điểm đầu ra</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = 1; ?>
                                @foreach ($levels as $level)
                                    <tr>
                                        <td>{{ $stt++ }}</td>
                                        <td>{{ $level->certificate->language->name ?? '' }}</td>
                                        <td>{{ $level->certificate->code ?? '' }}</td>
                                        <td>{{ 'Level ' . $level->name }}</td>
                                        <td>{{ $level->min_score }}</td>
                                        <td>{{ $level->max_score }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="#" class="btn btn-warning btn-sm edit-btn mr-3"
                                                data-id="{{ $level->id }}"
                                                data-language="{{ $level->certificate->language->id ?? '' }}"
                                                data-certificate="{{ $level->certificate->id ?? '' }}"
                                                data-name="{{ $level->name }}" data-min="{{ $level->min_score }}"
                                                data-max="{{ $level->max_score }}">
                                                <i class="fa-solid fa-edit"></i> Sửa
                                            </a>

                                            <form action="{{ url('admin/settings/levels/delete') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="level_id" value="{{ $level->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa level này không?')">
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
                                    <div class="col-md-12">
                                        <form id="addLevelForm" action="{{ url('admin/settings/levels/add') }}"
                                            method="POST">
                                            @csrf

                                            {{-- Chọn ngôn ngữ --}}
                                            <div class="mb-3">
                                                <label for="chon_ngon_ngu" class="form-label">Ngôn ngữ <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="chon_ngon_ngu" name="language_id" required>
                                                    <option value="">-- Chọn ngôn ngữ --</option>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Chọn loại chứng chỉ --}}
                                            <div class="mb-3">
                                                <label for="loai_chung_chi" class="form-label">Loại chứng chỉ <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="loai_chung_chi" name="certificate_id"
                                                    required>
                                                    <option value="">-- Chọn loại chứng chỉ --</option>
                                                    @foreach ($certificates as $certificate)
                                                        <option value="{{ $certificate->id }}"
                                                            data-language="{{ $certificate->language_id }}">
                                                            {{ $certificate->code }} - {{ $certificate->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Level --}}
                                            <div class="mb-3">
                                                <label for="level_name" class="form-label">Tên Level <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="level_name" name="level_name"
                                                    required>
                                            </div>

                                            {{-- Điểm đầu vào / đầu ra --}}
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="diem_dau_vao" class="form-label">Điểm đầu vào <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="diem_dau_vao" name="min_score" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="diem_dau_ra" class="form-label">Điểm đầu ra <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="diem_dau_ra" name="max_score" required>
                                                </div>
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
                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- Modal chỉnh sửa Level -->
    <div class="modal fade" id="editLevelModal" tabindex="-1" aria-labelledby="editLevelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('admin/settings/levels/update') }}" method="POST" id="editLevelForm">
                    @csrf
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="editLevelLabel">
                            <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa Level
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="level_id" id="edit_level_id">

                        {{-- Ngôn ngữ --}}
                        <div class="mb-3">
                            <label for="edit_language_id" class="form-label">
                                Ngôn ngữ <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="language_id" id="edit_language_id" required>
                                <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Loại chứng chỉ --}}
                        <div class="mb-3">
                            <label for="edit_certificate_id" class="form-label">
                                Loại chứng chỉ <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="certificate_id" id="edit_certificate_id" required>
                                <option value="">-- Chọn loại chứng chỉ --</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}"
                                        data-language="{{ $certificate->language_id }}">
                                        {{ $certificate->code }} - {{ $certificate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tên Level --}}
                        <div class="mb-3">
                            <label for="edit_level_name" class="form-label">
                                Tên Level <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_level_name" name="level_name"
                                placeholder="Nhập tên Level (VD: Level 1, Beginner...)" required>
                        </div>

                        {{-- Điểm đầu vào / đầu ra --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_min_score" class="form-label">
                                    Điểm đầu vào <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="any" class="form-control" id="edit_min_score"
                                    name="min_score" placeholder="Nhập điểm đầu vào" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_max_score" class="form-label">
                                    Điểm đầu ra <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="any" class="form-control" id="edit_max_score"
                                    name="max_score" placeholder="Nhập điểm đầu ra" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Hủy
                        </button>
                        <button type="submit" class="btn btn-warning text-dark">
                            <i class="fa-solid fa-check"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        // ===== Modal Sửa Level =====
        const editButtons = document.querySelectorAll(".edit-btn");

        editButtons.forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const language = this.dataset.language;
                const certificate = this.dataset.certificate;
                const name = this.dataset.name;
                const min = this.dataset.min;
                const max = this.dataset.max;

                document.getElementById("edit_level_id").value = id;
                document.getElementById("edit_language_id").value = language;
                document.getElementById("edit_certificate_id").value = certificate;
                document.getElementById("edit_level_name").value = name;
                document.getElementById("edit_min_score").value = min;
                document.getElementById("edit_max_score").value = max;

                // Gọi lại lọc chứng chỉ theo ngôn ngữ trong modal
                const event = new Event("change");
                document.getElementById("edit_language_id").dispatchEvent(event);

                const modal = new bootstrap.Modal(document.getElementById("editLevelModal"));
                modal.show();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectLanguage = document.getElementById("chon_ngon_ngu");
            const selectCertificate = document.getElementById("loai_chung_chi");

            // ✅ Lưu toàn bộ option ban đầu của chứng chỉ
            const allCertificates = Array.from(selectCertificate.options);

            // Khi chọn ngôn ngữ
            selectLanguage.addEventListener("change", function() {
                const selectedLanguage = this.value;

                // Xóa hết option hiện có
                selectCertificate.innerHTML = "";

                // Thêm option mặc định
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "-- Chọn loại chứng chỉ --";
                selectCertificate.appendChild(defaultOption);

                // Nếu chưa chọn ngôn ngữ -> hiển thị tất cả
                if (selectedLanguage === "") {
                    allCertificates.forEach(opt => selectCertificate.appendChild(opt.cloneNode(true)));
                    return;
                }

                // Lọc theo ngôn ngữ
                allCertificates.forEach(opt => {
                    const lang = opt.getAttribute("data-language");
                    if (lang === selectedLanguage || opt.value === "") {
                        selectCertificate.appendChild(opt.cloneNode(true));
                    }
                });
            });

            // Khi chọn chứng chỉ trước
            selectCertificate.addEventListener("change", function() {
                const selectedCert = this.selectedOptions[0];
                const languageId = selectedCert ? selectedCert.getAttribute("data-language") : "";

                // Nếu chọn chứng chỉ có ngôn ngữ => tự động chọn ngôn ngữ tương ứng
                if (languageId) {
                    selectLanguage.value = languageId;

                    // Gọi lại sự kiện change để lọc chứng chỉ phù hợp
                    const event = new Event("change");
                    selectLanguage.dispatchEvent(event);

                    // Giữ nguyên chứng chỉ đã chọn
                    selectCertificate.value = selectedCert.value;
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===== Hàm kiểm tra điểm hợp lệ =====
            function validateScores(formId, minFieldId, maxFieldId) {
                const form = document.getElementById(formId);
                if (!form) return;

                form.addEventListener("submit", function(e) {
                    const minScore = parseFloat(document.getElementById(minFieldId).value);
                    const maxScore = parseFloat(document.getElementById(maxFieldId).value);

                    if (!isNaN(minScore) && !isNaN(maxScore) && minScore > maxScore) {
                        e.preventDefault();
                        alert("❌ Điểm đầu vào không được lớn hơn điểm đầu ra!");
                    }
                });
            }

            // Áp dụng cho cả form thêm mới và form chỉnh sửa
            validateScores("addLevelForm", "diem_dau_vao", "diem_dau_ra");
            validateScores("editLevelForm", "edit_min_score", "edit_max_score");
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterSelect = document.getElementById("filter_language");
            const tableRows = document.querySelectorAll("tbody tr");

            filterSelect.addEventListener("change", function() {
                const selectedLanguage = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const languageCell = row.querySelector("td:nth-child(2)"); // Cột ngôn ngữ
                    const languageText = languageCell ? languageCell.textContent.trim()
                    .toLowerCase() : "";

                    if (selectedLanguage === "" || languageText === selectedLanguage) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection
