@extends('index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">lớp học</h3>
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
                        <h4><i class="fa-solid fa-table"></i> Tạo mới lớp học</h4>
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
                            <h5>Lịch học</h5>
                            <div class="kt-form">
                                <div class="kt-portlet__body">
                                    <div class="kt-section kt-section--first">

                                        @php
                                            $days = [
                                                'monday' => 'Thứ 2',
                                                'tuesday' => 'Thứ 3',
                                                'wednesday' => 'Thứ 4',
                                                'thursday' => 'Thứ 5',
                                                'friday' => 'Thứ 6',
                                                'saturday' => 'Thứ 7',
                                                'sunday' => 'Chủ nhật',
                                            ];

                                            $sessions = [
                                                '08h00-09h30' => '08h00 - 09h30',
                                                '09h45-11h15' => '09h45 - 11h15',
                                                '14h30-16h30' => '14h30 - 16h30',
                                                '18h00-20h00' => '18h00 - 20h00',
                                            ];
                                        @endphp

                                        <div class="form-group form-class-schedule">


                                            <div class="table-scroll-wrapper">
                                                <table class="table table-bordered align-middle table-class-schedule">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="align-middle text-bold">
                                                                <span>Thứ</span>
                                                                <button type="button"
                                                                    class="btn btn-outline-primary rounded-circle btn-circle-add-session"
                                                                    id="addRow" title="Thêm ngày học">
                                                                    <i class="bi bi-plus"></i>
                                                                </button>
                                                            </th>
                                                            <th class="text-center">
                                                                <label>Ca học</label>
                                                            </th>
                                                            <th style="width: 60px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="scheduleBody">
                                                        <!-- Các dòng sẽ được thêm ở đây -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                        </div>
                        <div class="col-md-12">
                            <br>
                            <h5>Số học viên</h5>
                            <textarea rows="10" type="text" class="form-control"></textarea>
                            <br>
                            <h5>Ghi chú</h5>
                            <textarea rows="3" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                     <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-11">
                                   <h5>Tên lớp</h5>
                        <input type="text" class="form-control" placeholder="Nhập tên lớp">
                        <br>
                        <h5>Ngày khai giảng</h5>
                        <input type="date" class="form-control">
                        <br>
                        <h5>Khóa học</h5>
                        <select class="form-select">
                            <option value="">-- Chọn khóa học --</option>
                            <option value="course1">Khóa học 1</option>
                            <option value="course2">Khóa học 2</option>
                            <option value="course3">Khóa học 3</option>
                        </select>
                        <br>
                        <h5>Tổng số buổi học</h5>
                        <input type="number" class="form-control" placeholder="Nhập tổng số buổi học">
                        <br>
                        <h5>Số buổi đã học</h5>
                        <input type="number" class="form-control" placeholder="Nhập số buổi đã học">
                        <br>
                        <h5>Sĩ số tối thiểu</h5>
                        <input type="number" class="form-control" placeholder="Nhập sĩ số tối thiểu">
                        <br>
                        <h5>Sĩ số tối đa</h5>
                        <input type="number" class="form-control" placeholder="Nhập sĩ số tối
đa">
                        <br>
                        <h5>
                        Sĩ số
                        </h5>
                        <input type="number" class="form-control" placeholder="Nhập sĩ số hiện tại">
                        <br>
                        <h5>Giáo viên</h5>
                        <select class="form-select">
                            <option value="">-- Chọn giáo viên --</option>
                            <option value="teacher1">Giáo viên 1</option>
                            <option value="teacher2">Giáo viên 2</option>
                            <option value="teacher3">Giáo viên 3</option>
                        </select>
                        <br>
                        <h5>Cơ sở</h5>
                        <select class="form-select">
                            <option value="">-- Chọn cơ sở --</option>
                            <option value="branch1">Cơ sở 1</option>
                            <option value="branch2">Cơ sở 2</option>
                            <option value="branch3">Cơ sở 3</option>
                        </select>
                        <br>
                        <h5>Tình trạng</h5>
                        <select class="form-select">
                            <option value="">-- Chọn tình trạng --</option>
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Ngừng hoạt động</option>
                            <option value="completed">Hoàn thành</option>
                        </select>
                        <br>
                        <h5>trợ giảng</h5>
                        <select class="form-select">
                            <option value="">-- Chọn trợ giảng --</option>
                            <option value="assistant1">Trợ giảng 1</option>
                            <option value="assistant2">Trợ giảng 2</option>
                            <option value="assistant3">Trợ giảng 3</option>
                        </select>

                            </div>
                        </div>
                     </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- JS -->
    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            const tbody = document.getElementById('scheduleBody');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
    <td>
      <select class="form-select">
        <option value="">-- Chọn thứ --</option>
        <option value="monday">Thứ 2</option>
        <option value="tuesday">Thứ 3</option>
        <option value="wednesday">Thứ 4</option>
        <option value="thursday">Thứ 5</option>
        <option value="friday">Thứ 6</option>
        <option value="saturday">Thứ 7</option>
        <option value="sunday">Chủ nhật</option>
      </select>
    </td>
    <td>
      <select class="form-select">
        <option value="">-- Chọn ca học --</option>
        <option value="08h00-09h30">08h00 - 09h30</option>
        <option value="09h45-11h15">09h45 - 11h15</option>
        <option value="14h30-16h30">14h30 - 16h30</option>
        <option value="18h00-20h00">18h00 - 20h00</option>
      </select>
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-link text-danger btn-remove-row">
        <i class="bi bi-trash-fill"></i>
      </button>
    </td>
  `;

            tbody.appendChild(newRow);

            // Gán sự kiện xóa cho nút thùng rác mới
            newRow.querySelector('.btn-remove-row').addEventListener('click', function() {
                newRow.remove();
            });
        });
    </script>
    <style>
        .btn-circle-add-session {
            width: 28px;
            height: 28px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }

        .table-class-schedule select {
            min-width: 180px;
        }

        .table-scroll-wrapper {
            overflow-x: auto;
        }

        .table-class-schedule th,
        .table-class-schedule td {
            vertical-align: middle !important;
        }
    </style>
@endsection
