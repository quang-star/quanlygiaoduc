@extends('index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">Khóa học</h3>
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
                        <h4><i class="fa-solid fa-table"></i> Tạo mới khóa học</h4>
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
            <h3>Thông tin khóa học</h3>
            <!-- Form tạo mới khóa học -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ma_khoa_hoc" class="form-label">Mã khóa học</label>
                                    <input type="text" class="form-control" id="ma_khoa_hoc"
                                        placeholder="Nhập mã khóa học" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ten_khoa_hoc" class="form-label">Tên khóa học</label>
                                    <input type="text" class="form-control" id="ten_khoa_hoc"
                                        placeholder="Nhập tên khóa học">
                                </div>
                                {{-- -Ngôn ngữ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                    <select class="form-control" name="" id="" required></select>
                                        <option value="">Nhật</option>
                                        <option value="">Trung</option>
                                    </select>
                                </div>
                                {{-- Chứng chỉ --}}
                                <div class="col-md-6 mb-3">
                                    <label for="chung_chi" class="form-label">Chứng chỉ</label>
                                    <select name="" id="" class="form-control">
                                        <option value="1">TOEIC</option>
                                        <option value="2">ielts</option>
                                    </select>
                                </div>
                                {{-- -level --}}
                                <div class="col-md-6 mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <select name="" id="" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gia_khoa_hoc" class="form-label">Giá khóa học</label>
                                    <input type="number" class="form-control" id="gia_khoa_hoc"
                                        placeholder="Nhập giá khóa học">
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label for="thoi_luong_hoc" class="form-label">Thời lượng học</label>
                                    <input type="text" class="form-control" id="thoi_luong_hoc"
                                        placeholder="Nhập thời lượng học">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="so_buoi_hoc" class="form-label">Số buổi buổi học (/tuan)</label>
                                    <input type="number" class="form-control" id="so_buoi_hoc"
                                        placeholder="Nhập số buổi học">

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="si_so_toi_da" class="form-label">Sĩ số tối đa</label>
                                    <input type="number" class="form-control" id="si_so_toi_da"
                                        placeholder="Nhập sĩ số tối đa">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="si_so_toi_thieu" class="form-label">Sĩ số tối thiểu</label>
                                    <input type="number" class="form-control" id="si_so_toi_da"
                                        placeholder="Nhập sĩ số tối đa">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="mo_ta" class="form-label">Mô tả</label>
                                    <textarea rows="4" type="text" class="form-control" id="mo_ta" placeholder="Nhập mô tả"></textarea>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
