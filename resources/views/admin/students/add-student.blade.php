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
           
            <!-- Form tạo mới khóa học -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                           <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ho_ten" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="ho_ten"
                                    placeholder="Nhập họ tên">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="so_dien_thoai"
                                    placeholder="Nhập số điện thoại">   
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="Nhập email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="ngay_sinh"
                                    placeholder="Nhập ngày sinh">
                            </div>
                            {{-- -ngôn ngữ --}}
                            <div class="col-md-6 mb-3">
                                <label for="ngon_ngu" class="form-label">Ngôn ngữ</label>
                                <select class="form-control" name="" id="" required>
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
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                           <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11"></div>
                           </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    STT
                                </th>
                                <th>Khóa học</th>
                                <th>Lớp học</th>
                                <th>Thời gian học</th>
                                <th>Trạng thái</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>IELTS</td>
                                <td>IELTS 1</td>
                                <td>15/09/2023 - 16/09/2023</td>
                                <td><span class="badge bg-success">Đang tiến hành</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
