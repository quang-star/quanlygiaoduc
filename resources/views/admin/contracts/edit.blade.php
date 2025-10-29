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
                        <h4><i class="fa-solid fa-table"></i> Chỉnh sửa hợp đồng</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a id="backBtn" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
                            <button type="submit" class="btn btn-primary"
                                onclick="document.getElementById('contractForm').submit();">
                                <i class="fa-solid fa-check"></i> Lưu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 d-flex justify-content-center">
        <form action="{{ url('/admin/contracts/update') }}" method="post" id="contractForm">
            @csrf
            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
            <div class="w-90"
                style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top:20px;">
                <div class="col-md-12">
                    <div class="row">

                        {{-- ===== THÔNG TIN HÓA ĐƠN ===== --}}
                        <div class="col-md-8">
                            <h3>Thông tin hóa đơn</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_tao" class="form-label">Ngày tạo</label>
                                    <input type="text" class="form-control" id="ngay_tao" name="ngay_tao" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                    <select class="form-select" id="ngon_ngu" name="ngon_ngu" disabled>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}"
                                                {{ $contract->course->certificate->language_id == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ</label>
                                    <select class="form-select" id="chung_chi" name="chung_chi" disabled>
                                        @foreach ($certificates as $certificateItem)
                                            <option value="{{ $certificateItem->id }}"
                                                {{ $contract->course->certificate->id == $certificateItem->id ? 'selected' : '' }}>
                                                {{ $certificateItem->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="khoa_hoc" class="form-label">Khóa học</label>
                                    <select class="form-select" id="khoa_hoc" name="khoa_hoc" disabled>

                                        @foreach ($courses as $c)
                                            <option value="{{ $c->id }}" data-certificate="{{ $c->certificate_id }}"
                                                data-total="{{ $c->total_lesson }}" data-price="{{ $c->price }}"
                                                {{ $contract->course->id == $c->id ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="thoi_luong_hoc" class="form-label">Thời lượng học</label>
                                    <input type="text" class="form-control" id="thoi_luong_hoc" readonly
                                        value="{{ $contract->course->total_lesson }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tong_tien" class="form-label">Tổng tiền ($)</label>
                                    <input type="number" class="form-control" id="tong_tien" readonly
                                        value="{{ $contract->course->price }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="khuyen_mai" class="form-label">Khuyến mại ($)</label>
                                    <input type="number" class="form-control" id="khuyen_mai" value="{{ $contract->course->price - $contract->total_value ?? 0 }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hoc_phi_thuc_dong" class="form-label">Học phí thực đóng ($)</label>
                                    <input type="number" class="form-control" id="hoc_phi_thuc_dong" name="total_value"
                                        value="{{ $contract->total_value }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- ===== THÔNG TIN KHÁCH ===== --}}
                        <div class="col-md-4">
                            <h3>Thông tin khách</h3>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mb-3 position-relative">
                                        <label for="ho_ten" class="form-label">Họ tên</label>
                                        <input type="hidden" name="studentId" id="studentId"
                                            value="{{ $contract->studentProfile->student->id }}" readonly>
                                        <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                                            placeholder="Nhập họ tên"
                                            value="{{ $contract->studentProfile->student->name }}" readonly>
                                        <div id="suggestions" class="list-group position-absolute w-100"
                                            style="z-index:1000;display:none;max-height:200px;overflow-y:auto;"></div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" id="so_dien_thoai"
                                            name="so_dien_thoai"
                                            value="{{ $contract->studentProfile->student->phone_number }}" readonly>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $contract->studentProfile->student->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 d-flex justify-content-center" style="margin-top: 30px;">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Thông tin phiếu thu</h3>
                    </div>

                </div>
                <table class="table table-bordered text-center align-middle">

                    <thead>
                        <tr>
                            <th>Lần thu</th>
                            <th>Ngày thu</th>
                            <th>Số tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Ảnh</th>
                            <th>Nội dung</th>
                            <th>Hành động</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1; ?>
                        @foreach ($bills as $bill)
                            <tr>
                                <td>{{ $stt++ }}</td>
                                <td>{{ $bill->payment_time }}</td>
                                <td>{{ $bill->money }}</td>
                                <td>{{ $bill->bank_account_id ? $bill->bank . ' - ' . $bill->account_number : 'Tiền mặt' }}</td>
                                <td>
                                    @if ($bill->image)
                                        <img src="{{ asset($bill->image) }}" alt="Ảnh chuyển khoản"
                                            style="max-width: 100px; max-height: 100px; object-fit: contain; border-radius: 8px; box-shadow: 0 0 4px rgba(0,0,0,0.15);">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>

                                <td>{{ $bill->content }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Sửa</a>
                                    <form action="{{ url('admin/contracts/deletebill') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="fa-solid fa-trash"></i> Xóa</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="col-md-12">

                    <!-- Nút thêm phiếu thu -->
                    @if($contract->status != App\Models\Contract::STATUS_DONE)
                     <div class="text-center mb-3">
                        <a href="#" id="btnThemPhieu" class="btn btn-sm btn-success text-center">
                            <i class="fa-solid fa-plus"></i> Thêm phiếu thu
                        </a>
                    </div>
                    @endif

                    <!-- Form phiếu thu (ẩn ban đầu) -->
                    <div id="formPhieuThu" class=" col-md-12 " style="display: none;">
                        <form action="{{ url('admin/contracts/addbill') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                            <div class="row">
                                {{-- Ngày thu --}}
                                <div class="col-md-4 mb-3">
                                    <label for="ngay_thu" class="form-label">Ngày thu</label>
                                    <input type="datetime-local" class="form-control" name="ngay_tao"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                                </div>

                                {{-- Phương thức thanh toán --}}
                                <div class="col-md-4 mb-3">
                                    <label for="phuong_thuc_thanh_toan" class="form-label">Phương thức thanh toán</label>
                                    <select class="form-select" id="phuong_thuc_thanh_toan"
                                        name="phuong_thuc_thanh_toan">
                                        <option value="0">Tiền mặt</option>
                                      
                                        @foreach ($bankAccounts as $bankAccount)
                                              <option value="{{ $bankAccount->id }}">{{ $bankAccount->bank . ' - ' . $bankAccount->account_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Số tiền --}}
                                <div class="col-md-4 mb-3">
                                    <label for="so_tien" class="form-label">Số tiền</label>
                                    <input type="number" class="form-control" id="so_tien" name="so_tien"
                                        min="0">
                                    <small id="moneyHelp" class="text-muted"></small>
                                </div>


                                {{-- Ảnh chuyển khoản --}}
                                <div class="col-md-6 mb-3">
                                    <label for="anh_chuyen_khoan" class="form-label">Ảnh chuyển khoản</label>

                                    <!-- Ảnh xem trước -->
                                    <img id="preview" src="" alt="Chưa có ảnh" class="img-fluid mb-2"
                                        style="max-height: 200px; display:none;">

                                    <!-- Input chọn file -->
                                    <input type="file" class="form-control" id="anh_chuyen_khoan"
                                        name="anh_chuyen_khoan" accept="image/*">
                                </div>

                                {{-- Nội dung --}}
                                <div class="col-md-6 mb-3">
                                    <label for="noi_dung" class="form-label">Nội dung</label>
                                    <textarea id="noi_dung" name="noi_dung" class="form-control" rows="5"></textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-success text-center">
                                        <i class="fa-solid fa-save"></i> Lưu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Script xử lý hiển thị form và preview ảnh -->
                <script>
                    // Khi nhấn "Thêm phiếu thu" thì hiện form
                    document.getElementById('btnThemPhieu').addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = document.getElementById('formPhieuThu');

                        // Hiện / ẩn form luân phiên
                        form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    });

                    // Hiển thị ảnh xem trước khi chọn file
                    const input = document.getElementById("anh_chuyen_khoan");
                    const preview = document.getElementById("preview");

                    input.addEventListener("change", function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = "block";
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                </script>

            </div>
        </div>
    </div>
    <script>
        // Giới hạn số tiền không vượt quá tổng còn lại
        const totalValue = {{ $contract->total_value }};
        const collected = {{ $contract->collected ?? 0 }};
        const remaining = totalValue - collected;

        const inputMoney = document.getElementById('so_tien');
        const helpText = document.getElementById('moneyHelp');

        // Hiển thị số tiền tối đa
        helpText.textContent = `Số tiền tối đa có thể thu: ${remaining.toLocaleString()} VNĐ`;

        inputMoney.addEventListener('input', function() {
            let val = parseFloat(this.value) || 0;

            if (val > remaining) {
                this.value = remaining; // ✅ Tự động set lại về giá trị lớn nhất
            } else if (val < 0) {
                this.value = 0; // ✅ Không cho nhập số âm
            }
        });
    </script>



    {{-- ================== SCRIPT XỬ LÝ ================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ======== DỮ LIỆU TỪ SERVER ========
            //const students = @json($contract->students);

            // ======== FORMAT NGÀY dd/mm/yyyy ========
            const ngayTaoInput = document.getElementById("ngay_tao");
            const date = new Date();
            ngayTaoInput.value =
                `${String(date.getDate()).padStart(2,'0')}/${String(date.getMonth()+1).padStart(2,'0')}/${date.getFullYear()}`;
            ngayTaoInput.readOnly = true;

            // ======== HỌC VIÊN ========
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
                console.log("✅ Selected student:", stu.id);
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

            // ======== LỌC NGÔN NGỮ / CHỨNG CHỈ / KHÓA HỌC ========
            const langSelect = document.getElementById("ngon_ngu");
            const certSelect = document.getElementById("chung_chi");
            const courseSelect = document.getElementById("khoa_hoc");
            const thoiLuongInput = document.getElementById("thoi_luong_hoc");
            const tongTienInput = document.getElementById("tong_tien");
            const khuyenMaiInput = document.getElementById("khuyen_mai");
            const hocPhiThucDongInput = document.getElementById("hoc_phi_thuc_dong");

            const allCertificates = Array.from(certSelect.options);
            const allCourses = Array.from(courseSelect.options);

            function filterCertificatesByLanguage(languageId) {
                certSelect.innerHTML = '<option value="">Chọn chứng chỉ</option>';
                allCertificates.forEach(opt => {
                    if (opt.dataset.language === languageId)
                        certSelect.appendChild(opt.cloneNode(true));
                });
            }

            function filterCoursesByCertificate(certId) {
                courseSelect.innerHTML = '<option value="">Chọn khóa học</option>';
                allCourses.forEach(opt => {
                    if (opt.dataset.certificate === certId)
                        courseSelect.appendChild(opt.cloneNode(true));
                });
            }

            function updateCourseInfo(selected) {
                const totalLesson = selected.dataset.total || 0;
                const price = selected.dataset.price || 0;
                thoiLuongInput.value = totalLesson;
                tongTienInput.value = price;
                khuyenMaiInput.max = price;
                khuyenMaiInput.min = 0;
                khuyenMaiInput.value = 0;
                hocPhiThucDongInput.value = price;
            }

            langSelect.addEventListener("change", function() {
                filterCertificatesByLanguage(this.value);
                courseSelect.innerHTML = '<option value="">Chọn khóa học</option>';
                thoiLuongInput.value = tongTienInput.value = hocPhiThucDongInput.value = "";
                khuyenMaiInput.value = 0;
            });

            certSelect.addEventListener("change", function() {
                const cert = this.selectedOptions[0];
                if (!cert) return;
                const certId = cert.value;
                const langId = cert.dataset.language;
                if (langSelect.value !== langId) {
                    langSelect.value = langId;
                    filterCertificatesByLanguage(langId);
                    certSelect.value = certId;
                }
                filterCoursesByCertificate(certId);
            });

            courseSelect.addEventListener("change", function() {
                const selected = this.selectedOptions[0];
                if (!selected) return;
                const certId = selected.dataset.certificate;
                const certOpt = allCertificates.find(opt => opt.value === certId);
                const langId = certOpt ? certOpt.dataset.language : "";

                if (langSelect.value !== langId) {
                    langSelect.value = langId;
                    filterCertificatesByLanguage(langId);
                }
                if (certSelect.value !== certId) {
                    filterCoursesByCertificate(certId);
                    certSelect.value = certId;
                }
                updateCourseInfo(selected);
            });

            khuyenMaiInput.addEventListener("input", function() {
                const tongTien = parseFloat(tongTienInput.value) || 0;
                let km = parseFloat(this.value) || 0;
                if (km < 0) km = 0;
                if (km > tongTien) km = tongTien;
                this.value = km;
                hocPhiThucDongInput.value = tongTien - km;
            });

            // ======== KIỂM TRA TRƯỚC KHI SUBMIT ========
            document.getElementById('contractForm').addEventListener('submit', function(e) {
                const studentId = document.getElementById('studentId').value;
                if (!studentId) {
                    e.preventDefault();
                    alert("⚠️ Vui lòng chọn học viên từ danh sách gợi ý trước khi lưu!");
                    return false;
                }
                console.log("🟢 Student ID gửi đi:", studentId);
            });
        });
    </script>
@endsection
