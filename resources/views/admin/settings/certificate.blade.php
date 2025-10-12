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
                    <h5>Thông tin chứng chỉ</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ngôn ngữ</th>
                                <th>Loại chứng chỉ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Tiếng Anh</td>
                                <td>IELTS</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm"><i class="fa-solid fa-edit"></i> Sửa</a>
                                    <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Xóa</a>
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
                                    {{-- -Thêm ngôn ngữ --}}
                                    <label for="chon_ngon_ngu" class="form-label">
                                       chọn ngôn ngữ
                                    </label>
                                    <select name="" id="" class="form-control mb-3">
                                        <option value="1">Tiếng việt</option>
                                        <option value="2">tiếng Anh</option>
                                    </select>
                                    <label for="loai_chung_chi" class="form-label">Loại chứng chỉ</label>
                                    <input type="text" class="form-control mb-3">
                                    <a href="" class="btn btn-success"><i class="fa-solid fa-plus"></i>Thêm mới</a>
                                        
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
