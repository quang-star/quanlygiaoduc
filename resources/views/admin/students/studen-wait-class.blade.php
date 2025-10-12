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
                        <h4><i class="fa-solid fa-table"></i> Dịch vụ</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <input type="text" class="form-control" placeholder="Tìm kiếm..."
                                style="width: 200px; margin-right: 10px;">

                            <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button>
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <button class="btn btn-primary" style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Khóa học</th>
                            <th>Level</th>
                            {{-- <th>Lớp học</th>--}}
                             {{-- <th>Trạng thái</th> --}}
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Nguyễn Văn A</td>
                            <td>0123456789</td>
                            <td>zVY9y@example.com</td>
                            <td>Khóa Toán Cơ Bản</td>
                            <td>Trung bình</td>
                            {{-- <td>Lớp Toán 1</td>
                            <td><span class="badge bg-success">Đang học</span></td> --}}
                            {{-- <td>
                                {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch
                                    học</a> 
                                <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                    Sửa</a>
                                <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                            </td> --}}
                            {{-- a href xếp lớp --}}
                            <td>
                                <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Xếp lớp</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
