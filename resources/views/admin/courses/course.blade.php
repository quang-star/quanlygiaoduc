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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Mã khóa học</th>
                        <th>Tên khóa học</th>
                        <th>Sĩ số tối thiểu</th>
                        <th>Sĩ số tối đa</th>
                        <th>Học phí</th>
                        <th>Thời lượng học(buổi)</th>
                        <th>Số buổi học /tuần</th>
                        {{-- <th>Trạng thái</th> --}}
                        <th>Hành động</th>

                    </tr>
                </thead>
                <tbody>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   <tr>
                    <td><input type="checkbox"></td>
                    <td>KH001</td>
                    <td>Khóa học tiếng Anh cơ bản</td>
                    <td>10</td>
                    <td>30</td>
                    <td>5,000,000 VND</td>
                    <td>40</td>
                    <td>3</td>
                    {{-- <td><span class="badge bg-success">Kích hoạt</span></td> --}}
                    <td>
                      
                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                   </tr>
                   
                </tbody>
            </table>
        </div>
    </div>
@endsection
