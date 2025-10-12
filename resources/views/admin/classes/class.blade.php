@extends('admin.index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">Lớp học</h3>
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
                        <h4><i class="fa-solid fa-table"></i> Lớp học</h4>
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Mã lớp học</th>
                        <th>Tên lớp học</th>
                        <th>Khóa học</th>
                        <th>Giáo viên</th>
                        <th>Số lượng học viên</th>
                        <th>Ngày khai giảng</th>
                        <th>Tổng số buổi học</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>LH001</td>
                        <td>Lớp Toán 1</td>
                        <td>Khóa Toán Cơ Bản</td>
                        <td>Nguyễn Văn A</td>
                        <td>25</td>
                        <td>01/09/2024</td>
                        <td>30</td>
                        <td><span class="badge bg-success">Đang học</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch học</a>
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>LH002</td>
                        <td>Lớp Văn 2</td>
                        <td>Khóa Văn Học Nâng Cao</td>
                        <td>Trần Thị B</td>
                        <td>20</td>
                        <td>15/09/2024</td>
                        <td>25</td>
                        <td><span class="badge bg-warning text-dark">Sắp khai giảng</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch học</a>
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <!-- Thêm các dòng dữ liệu khác tại đây -->
               
            </table>
        </div>
    </div>
@endsection
