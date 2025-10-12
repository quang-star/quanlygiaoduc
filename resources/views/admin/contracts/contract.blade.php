@extends('index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">Hợp đồng</h3>
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
                        <h4><i class="fa-solid fa-table"></i> Hợp đồng</h4>
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
                        <th>Học viên</th>

                        <th>Tổng $</th>
                        <th>Đã thu</th>
                        <th>Chưa thu</th>
                        <th>Khóa học</th>
                        <th>Ngày ký</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Nguyễn Văn A</td>

                        <td>5,000,000</td>
                        <td>3,000,000</td>
                        <td>2,000,000</td>
                        <td>Tiếng Anh cơ bản</td>
                        <td>01/01/2024</td>
                        <td><span class="badge bg-success">Đã thanh toán đủ</span></td>
                        <td>
                            {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Xem</a> --}}
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Trần Thị B</td>

                        <td>6,000,000</td>
                        <td>6,000,000</td>
                        <td>0</td>
                        <td>Tiếng Anh nâng cao</td>
                        <td>15/02/2024</td>
                        <td><span class="badge bg-secondary">Đã đặt cọc</span></td>
                        <td>
                            {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Xem</a> --}}
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Phạm Văn C</td>

                        <td>4,000,000</td>
                        <td>1,000,000</td>
                        <td>3,000,000</td>
                        <td>Tiếng Anh giao tiếp</td>
                        <td>20/03/2024</td>
                        <td><span class="badge bg-warning text-dark">Chưa thanh toán</span></td>
                        <td>
                            {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Xem</a> --}}
                            <a href="#" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                Sửa</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Xóa</a>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
