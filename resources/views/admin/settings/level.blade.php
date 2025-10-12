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
                        <h5>Thông tin level</h5>
                        <label for="tim_kiem">Lọc</label>
                        <select name="filter_language" id="filter_language" class="form-control mb-2"
                            style="width: 200px; display: inline-block;">
                            <option value="">-- Tất cả ngôn ngữ --</option>
                            <option value="vi">Tiếng Việt</option>
                            <option value="en">Tiếng Anh</option>
                            <!-- Thêm các ngôn ngữ khác nếu cần -->
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
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>2</td>
                                    <td>Tiếng Việt</td>
                                    <td>TOEIC</td>
                                    <td>B1</td>
                                    <td>350</td>
                                    <td>550</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="fa-solid fa-edit"></i>
                                            Sửa</a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                            Xóa</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tiếng Anh</td>
                                    <td>IELTS</td>
                                    <td>C1</td>
                                    <td>6.5</td>
                                    <td>8.0</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="fa-solid fa-edit"></i>
                                            Sửa</a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                            Xóa</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <div class="col-md-12">
                                        <div class="row">


                                            {{-- -Thêm ngôn ngữ --}}
                                            <label for="chon_ngon_ngu" class="form-label">
                                                chọn ngôn ngữ
                                            </label>
                                            <select name="" id="" class="form-control mb-3">
                                                <option value="1">Tiếng việt</option>
                                                <option value="2">tiếng Anh</option>
                                            </select>
                                            <label for="loai_chung_chi" class="form-label">Loại chứng chỉ</label>
                                            <select name="" id="" class="form-control mb-3">
                                                <option value="1">TOeic</option>
                                                <option value="2">hsk</option>
                                            </select>
                                            <label for="level_" class="form-label">level</label>

                                            <input type="text" class="form-control mb-3">

                                            <div class="col-md-6">
                                                <label for="diem_dau_vao" class="form-label">Điểm đầu vào</label>
                                                <input type="text" class="form-control mb-3" id="diem_dau_vao"
                                                    name="diem_dau_vao">
                                            </div>
                                            <div class="col-md-6">

                                                <label for="diem_dau_ra" class="form-label">Điểm đầu ra</label>
                                                <input type="text" class="form-control mb-3" id="diem_dau_ra"
                                                    name="diem_dau_ra">

                                            </div>




                                            <a href="" class="btn btn-success"><i class="fa-solid fa-plus"></i>Thêm
                                                mới</a>
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
@endsection
