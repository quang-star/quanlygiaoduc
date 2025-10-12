@extends('index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">Tạo mới hợp đồng</h3>
            </div>

            <div class="col-md-6">
                <img src="{{ asset('images/avt.png') }}" alt=""
                    style="float: right; width: 50px; height: 50px; margin-top: 4px;" class="justify-content-center">
            </div>
        </div>
    </div>
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Tạo mới hợp đồng</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <a href="{{ url('/khoahoc') }}" class="btn btn-light"> <i class="fa-solid fa-arrow-left"></i>
                                Quay lại</a>

                            <a href="#" class="btn btn-primary"><i class="fa-solid fa-check"></i> Lưu</a>
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
                        <div class="col-md-12">
                            <h3>Thông tin hóa đơn</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ngay_tao" class="form-label">Ngày tạo</label>
                                    <input type="date" class="form-control" id="ngay_tao" name="ngay_tao">
                                </div>
                                <div class="col-md-6 mb-3">

                                    <label for="trang_thai" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="trang_thai" name="trang_thai">
                                        <option value="1">Đã đặt cọc</option>
                                        <option value="2">Chưa thanh toán</option>
                                        <option value="3">Đã thanh toán đủ</option>
                                    </select>

                                </div>
                                {{-- -thêm ngôn ngữ và chứng chỉ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                    <select class="form-select" id="ngon_ngu" name="ngon_ngu">
                                        <option value="1">Tiếng trung</option>
                                        <option value="2">Hàn</option>

                                    </select>
                                </div>
                                {{-- -chung chi --}}
                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chung chi</label>
                                    <select class="form-select" id="chung_chi" name="chung_chi">
                                        <option value="1">TOEIC</option>
                                        <option value="2">IELTS</option>
                                    </select>
                                </div>
                                {{-- khóa học --}}
                                <div class="col-md-6 mb-3">
                                    <label for="khoa_hoc" class="form-label">Khóa học</label>
                                    <select class="form-select" id="khoa_hoc" name="khoa_hoc">
                                        <option value="1">Khóa học 1</option>
                                        <option value="2">Khóa học 2</option>
                                        <option value="3">Khóa học 3</option>
                                    </select>
                                </div>
                                {{-- Thời lượng học --}}
                                <div class="col-md-6 mb-3">
                                    <label for="thoi_luong_hoc" class="form-label">Thời lượng học</label>
                                    <input type="text" class="form-control" id="thoi_luong_hoc"
                                        placeholder="Nhập thời lượng học">
                                </div>
                                {{-- Tổng tiền --}}
                                <div class="col-md-6 mb-3">
                                    <label for="tong_tien" class="form-label">Tổng tiền ($)</label>
                                    <input type="number" class="form-control" id="tong_tien" placeholder="Nhập tổng tiền">
                                </div>
                                {{-- khuyến mại --}}
                                <div class="col-md-6 mb-3">
                                    <label for="khuyen_mai" class="form-label">Khuyến mại ($)</label>
                                    <input type="number" class="form-control" id="khuyen_mai"
                                        placeholder="Nhập khuyến mại">
                                </div>
                                {{-- Học phí thực đóng --}}
                                <div class="col-md-6 mb-3">
                                    <label for="hoc_phi_thuc_dong" class="form-label">Học phí thực đóng ($)</label>
                                    <input type="number" class="form-control" id="hoc_phi_thuc_dong"
                                        placeholder="Nhập học phí thực đóng">
                                </div>
                                {{-- Hình thức thanh toán --}}
                                <div class="col-md-6 mb-3">
                                    <label for="hinh_thuc_thanh_toan" class="form-label">Hình thức thanh toán</label>
                                    <select class="form-select" id="hinh_thuc_thanh_toan" name="hinh_thuc_thanh_toan">
                                        <option value="1">Full phí</option>
                                        <option value="2">Trả góp</option>

                                    </select>
                                </div>
                                {{-- phương thức thanh toán --}}
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="phuong_thuc_thanh_toan" class="form-label">Phương thức thanh toán</label>
                                    <select class="form-select" id="phuong_thuc_thanh_toan"
                                        name="phuong_thuc_thanh_toan">
                                        <option value="1">Chuyển khoản</option>
                                        <option value="2">Tiền mặt</option>
                                    </select>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <h3>Thông tin khách</h3>
                                    <div class="col-md-12">
                                        <div class="row">
                                            {{-- Họ tên --}}
                                            <div class="col-md-12 mb-3">
                                                <label for="ho_ten" class="form-label">Họ tên</label>
                                                <input type="text" class="form-control" id="ho_ten"
                                                    placeholder="Nhập họ tên">
                                            </div>
                                            {{-- Số điện thoại --}}
                                            <div class="col-md-12 mb-3">
                                                <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                                <input type="text" class="form-control" id="so_dien_thoai"
                                                    placeholder="Nhập số điện thoại">
                                            </div>
                                            {{-- Email --}}
                                            <div class="col-md-12 mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email"
                                                    placeholder="Nhập email">
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                STT
                            </th>
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
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>15/09/2023</td>
                            <td>1000000</td>
                            <td>Chuyển khoản</td>
                            <td>anh 1</td>
                            <td>anh 2</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Sửa</a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12">

                    <!-- Nút thêm phiếu thu -->
                    <div class="text-center mb-3">
                        <a href="#" id="btnThemPhieu" class="btn btn-sm btn-success text-center">
                            <i class="fa-solid fa-plus"></i> Thêm phiếu thu
                        </a>
                    </div>

                    <!-- Form phiếu thu (ẩn ban đầu) -->
                    <div id="formPhieuThu" class=" col-md-12 " style="display: none;">
                        <div class="row">
                            {{-- Ngày thu --}}
                            <div class="col-md-4 mb-3">
                                <label for="ngay_thu" class="form-label">Ngày thu</label>
                                <input type="date" class="form-control" id="ngay_thu" name="ngay_thu">
                            </div>

                            {{-- Phương thức thanh toán --}}
                            <div class="col-md-4 mb-3">
                                <label for="phuong_thuc_thanh_toan" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" id="phuong_thuc_thanh_toan" name="phuong_thuc_thanh_toan">
                                    <option value="1">Chuyển khoản</option>
                                    <option value="2">Tiền mặt</option>
                                </select>
                            </div>

                            {{-- Số tiền --}}
                            <div class="col-md-4 mb-3">
                                <label for="so_tien" class="form-label">Số tiền</label>
                                <input type="number" class="form-control" id="so_tien" name="so_tien">
                            </div>

                            {{-- Ảnh chuyển khoản --}}
                            <div class="col-md-6 mb-3">
                                <label for="anh_chuyen_khoan" class="form-label">Ảnh chuyển khoản</label>

                                <!-- Ảnh xem trước -->
                                <img id="preview" src="" alt="Chưa có ảnh" class="img-fluid mb-2"
                                    style="max-height: 200px; display:none;">

                                <!-- Input chọn file -->
                                <input type="file" class="form-control" id="anh_chuyen_khoan" name="anh_chuyen_khoan"
                                    accept="image/*">
                            </div>

                            {{-- Nội dung --}}
                            <div class="col-md-6 mb-3">
                                <label for="noi_dung" class="form-label">Nội dung</label>
                                <textarea id="noi_dung" name="noi_dung" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="text-center">
                                <a href="#" class="btn btn-sm btn-success text-center">
                                    <i class="fa-solid fa-save"></i> Lưu
                                </a>
                            </div>
                        </div>
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
@endsection
