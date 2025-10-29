@extends('admin.index')

@section('header-content')
    Giảng viên
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Danh sách giảng viên</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm nhanh..."
                                style="width: 200px; margin-right: 10px;">






                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('/admin/teachers/add') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
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
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered text-center" id="teachersTable">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Ngày sinh</th>
                                    <th>Lương cơ sở</th>
                                    <th>Ngân hàng</th>
                                    <th>Số tài khoản</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($teachers as $t)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $t->name }}</td>
                                        <td>{{ $t->email }}</td>
                                        <td>{{ $t->phone_number }}</td>
                                        <td>{{ $t->birthday }}</td>
                                        <td>{{ $t->base_salary }}</td>
                                        <td>{{ $t->bankAccount->bank }}</td>
                                        <td>{{ $t->bankAccount->account_number }}</td>
                                        <td>
                                            <span class="badge {{ $t->active == 0 ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $t->active == 0 ? 'Hoạt động' : 'Ngưng hoạt động' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/teachers/update/' . $t->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-pen"></i> Sửa
                                            </a>
                                            <form action="{{ url('/admin/teachers/delete') }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="teacher_id" value="{{ $t->id }}">
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa giảng viên này?')">
                                                    <i class="fa-solid fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Tìm kiếm nhanh
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#teachersTable tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
   
@endsection
