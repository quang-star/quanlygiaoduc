@extends('admin.index')
@section('header-content')
    Hợp đồng
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Tạo mới hợp đồng</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a id="backBtn" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                            <button class="btn btn-primary" id="saveBtn">
                                <i class="fa-solid fa-check"></i> Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 d-flex justify-content-center">
        <form action="{{ url('/admin/contracts/add') }}" method="post" id="contractForm">
            @csrf
            <div class="w-90"
                style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top:20px;">
                <div class="col-md-12">
                    <div class="row">
                        {{-- ===== THÔNG TIN HÓA ĐƠN ===== --}}
                        <div class="col-md-8">
                            <h3>Thông tin hóa đơn</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_tao" class="form-label">Ngày tạo <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ngay_tao" name="ngay_tao" readonly
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="ngon_ngu" name="ngon_ngu" required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}"
                                                {{ $certificate->language_id == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="chung_chi" name="chung_chi" required>
                                        @foreach ($certificates as $certificateItem)
                                            <option value="{{ $certificateItem->id }}"
                                                data-language="{{ $certificateItem->language_id }}"
                                                {{ $certificate->id == $certificateItem->id ? 'selected' : '' }}>
                                                {{ $certificateItem->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="khoa_hoc" class="form-label">Khóa học <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="khoa_hoc" name="khoa_hoc" required>
                                        @foreach ($courses as $c)
                                            <option value="{{ $c->id }}" data-certificate="{{ $c->certificate_id }}"
                                                data-total="{{ $c->total_lesson }}" data-price="{{ $c->price }}"
                                                data-level="{{ $c->level_id }}"
                                                {{ $course->id == $c->id ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="thoi_luong_hoc" class="form-label">Thời lượng học</label>
                                    <input type="text" class="form-control" id="thoi_luong_hoc" readonly
                                        value="{{ $course->total_lesson }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tong_tien" class="form-label">Tổng tiền ($)</label>
                                    <input type="number" class="form-control" id="tong_tien" readonly
                                        value="{{ $course->price }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="khuyen_mai" class="form-label">Khuyến mại ($)</label>
                                    <input type="number" class="form-control" id="khuyen_mai" value="0">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hoc_phi_thuc_dong" class="form-label">Học phí thực đóng ($) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="hoc_phi_thuc_dong" name="total_value"
                                        value="{{ $course->price }}" readonly required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="level_hien_tai" class="form-label">Level</label>
                                    <input type="text" class="form-control" id="level_hien_tai" name="level_hien_tai"
                                        value="{{ $levels->firstWhere('id', $course->level_id)->name ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- ===== THÔNG TIN KHÁCH ===== --}}
                        <div class="col-md-4">
                            <h3>Thông tin khách</h3>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mb-3 position-relative">
                                        <label for="ho_ten" class="form-label">Họ tên <span
                                                class="text-danger">*</span></label>
                                        <input type="hidden" name="studentId" id="studentId"
                                            value="{{ $student->id }}">
                                        <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                                            placeholder="Nhập họ tên" value="{{ $student->name }}" required>
                                        <div id="suggestions" class="list-group position-absolute w-100"
                                            style="z-index:1000;display:none;max-height:200px;overflow-y:auto;"></div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="so_dien_thoai" class="form-label">Số điện thoại <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="so_dien_thoai"
                                            name="so_dien_thoai" value="{{ $student->phone_number }}" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $student->email }}" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>

    {{-- ================== SCRIPT ================== --}}
    <script>
        document.getElementById('saveBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('contractForm');
            const btn = document.getElementById('saveBtn');

            // Nếu form hợp lệ thì disable nút và gửi đi
            if (form.checkValidity()) {
                btn.disabled = true; // chặn bấm lại
                btn.innerHTML = 'Đang xử lý... ⏳'; // đổi text cho người dùng biết
                form.submit();
            } else {
                form.reportValidity(); // Hiện thông báo lỗi HTML5
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===== DỮ LIỆU TỪ SERVER =====
            const students = @json($students);
            const levels = @json($levels);

            // ===== FORMAT NGÀY =====
            const ngayTaoInput = document.getElementById("ngay_tao");
            const date = new Date();
            ngayTaoInput.value =
                `${String(date.getDate()).padStart(2,'0')}/${String(date.getMonth()+1).padStart(2,'0')}/${date.getFullYear()}`;
            ngayTaoInput.readOnly = true;

            // ===== HỌC VIÊN =====
            const inputName = document.getElementById("ho_ten");
            const inputPhone = document.getElementById("so_dien_thoai");
            const inputEmail = document.getElementById("email");
            const inputStudentId = document.getElementById("studentId");
            const suggestionBox = document.getElementById("suggestions");

            function searchStudents(query) {
                if (!query) return [];
                query = query.toLowerCase();
                return students.filter(stu =>
                    (stu.name && stu.name.toLowerCase().includes(query)) ||
                    (stu.phone_number && stu.phone_number.includes(query)) ||
                    (stu.email && stu.email.toLowerCase().includes(query))
                );
            }

            function showSuggestions(results) {
                suggestionBox.innerHTML = "";
                if (results.length === 0) {
                    suggestionBox.style.display = "none";
                    return;
                }
                results.forEach(stu => {
                    const item = document.createElement("a");
                    item.href = "#";
                    item.className = "list-group-item list-group-item-action";
                    item.innerHTML =
                        `<strong>${stu.name}</strong> - ${stu.phone_number ?? "N/A"}<br><small>${stu.email ?? ""}</small>`;
                    item.addEventListener("mousedown", e => {
                        e.preventDefault();
                        fillStudentInfo(stu);
                        suggestionBox.style.display = "none";
                    });
                    suggestionBox.appendChild(item);
                });
                suggestionBox.style.display = "block";
            }

            function fillStudentInfo(stu) {
                inputName.value = stu.name ?? "";
                inputPhone.value = stu.phone_number ?? "";
                inputEmail.value = stu.email ?? "";
                inputStudentId.value = stu.id ?? "";
            }

            [inputName, inputPhone, inputEmail].forEach(input => {
                input.addEventListener("input", e => {
                    const results = searchStudents(e.target.value.trim());
                    showSuggestions(results);
                });
            });

            document.addEventListener("click", e => {
                if (!suggestionBox.contains(e.target) &&
                    ![inputName, inputPhone, inputEmail].includes(e.target)) {
                    suggestionBox.style.display = "none";
                }
            });

            // ===== KHÓA HỌC – CHỨNG CHỈ – NGÔN NGỮ =====
            const langSelect = document.getElementById("ngon_ngu");
            const certSelect = document.getElementById("chung_chi");
            const courseSelect = document.getElementById("khoa_hoc");
            const thoiLuongInput = document.getElementById("thoi_luong_hoc");
            const tongTienInput = document.getElementById("tong_tien");
            const khuyenMaiInput = document.getElementById("khuyen_mai");
            const hocPhiThucDongInput = document.getElementById("hoc_phi_thuc_dong");
            const levelInput = document.getElementById("level_hien_tai");

            const allCertificates = Array.from(certSelect.options).map(opt => ({
                id: opt.value,
                text: opt.text,
                language: opt.dataset.language
            }));

            const allCourses = Array.from(courseSelect.options).map(opt => ({
                id: opt.value,
                text: opt.text,
                certificate: opt.dataset.certificate,
                total: opt.dataset.total,
                price: opt.dataset.price,
                level: opt.dataset.level
            }));

            function fillCertificates(languageId) {
                certSelect.innerHTML = "";
                allCertificates.forEach(c => {
                    const opt = document.createElement("option");
                    opt.value = c.id;
                    opt.text = c.text;
                    opt.dataset.language = c.language;
                    if (c.language === languageId || languageId === "") {
                        certSelect.appendChild(opt);
                    }
                });
            }

            function fillCourses(certificateId) {
                courseSelect.innerHTML = "";
                allCourses.forEach(c => {
                    const opt = document.createElement("option");
                    opt.value = c.id;
                    opt.text = c.text;
                    opt.dataset.certificate = c.certificate;
                    opt.dataset.total = c.total;
                    opt.dataset.price = c.price;
                    opt.dataset.level = c.level;
                    if (c.certificate === certificateId || certificateId === "") {
                        courseSelect.appendChild(opt);
                    }
                });
            }

            function updateCourseInfo(courseOpt) {
                if (!courseOpt) return;
                thoiLuongInput.value = courseOpt.dataset.total || 0;
                tongTienInput.value = courseOpt.dataset.price || 0;
                khuyenMaiInput.max = courseOpt.dataset.price || 0;
                hocPhiThucDongInput.value = parseFloat(courseOpt.dataset.price || 0) - (parseFloat(khuyenMaiInput
                    .value) || 0);
                const levelObj = levels.find(l => l.id == courseOpt.dataset.level);
                levelInput.value = levelObj ? levelObj.name : "";
            }

            langSelect.addEventListener("change", function() {
                const langId = this.value;
                fillCertificates(langId);
                const firstCert = certSelect.options[0]?.value || "";
                fillCourses(firstCert);
                updateCourseInfo(courseSelect.selectedOptions[0]);
                khuyenMaiInput.value = 0;
            });

            certSelect.addEventListener("change", function() {
                const certId = this.value;
                fillCourses(certId);
                updateCourseInfo(courseSelect.selectedOptions[0]);
            });

            courseSelect.addEventListener("change", function() {
                updateCourseInfo(this.selectedOptions[0]);
            });

            khuyenMaiInput.addEventListener("input", function() {
                let km = parseFloat(this.value) || 0;
                if (km < 0) km = 0;
                if (km > parseFloat(tongTienInput.value)) km = parseFloat(tongTienInput.value);
                this.value = km;
                hocPhiThucDongInput.value = parseFloat(tongTienInput.value) - km;
            });

            // ===== KHỞI TẠO BAN ĐẦU =====
            (function init() {
                const selectedCourse = courseSelect.selectedOptions[0];
                const certId = selectedCourse ? selectedCourse.dataset.certificate : "";
                const cert = allCertificates.find(c => c.id === certId);
                const langId = cert ? cert.language : "";

                if (langId) langSelect.value = langId;
                fillCertificates(langId);
                if (certId) certSelect.value = certId;
                fillCourses(certId);
                if (selectedCourse) courseSelect.value = selectedCourse.value;
                updateCourseInfo(selectedCourse);
            })();
        });
    </script>
@endsection
