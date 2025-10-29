@extends('student.index')
@section('header-content')
Thông tin tài chính
{{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa-solid fa-table"></i> Học phí</h4>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end">
                          <input id="searchInput" type="text" class="form-control" placeholder="Tìm nhanh..."
                                style="width: 200px; margin-right: 10px;" onkeyup="searchTable()">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12  d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
        <table class="table table-bordered" id="studentTable">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <!-- <th>Học viên</th> -->
                    <th>Thời gian học</th>
                    <th>Khóa học</th>
                    <th>Lớp học</th>
                    <th>Tổng học phí</th>
                    <th>Đã đóng</th>
                    <th>Nợ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $contract)
                <tr>
                    <td><input type="checkbox"></td>
                    <!-- <td>{{ $contract->student->name ?? ''}}</td> -->
                    <td>
                        {{ \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') ?? '' }}
                        -
                        {{ \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') ?? '' }}
                    </td>
                    <td>{{ $contract->course_name ?? ''}}</td>
                    <td>{{ $contract->name ?? '' }}</td> {{-- tên lớp --}}

                    
                    <td>{{ number_format($contract->total_value, 0, ',', '.') }} ₫</td>
                    <td>{{ number_format($contract->collected, 0, ',', '.') }} ₫</td>
                    <td>{{ number_format($contract->total_value - $contract->collected, 0, ',', '.') }} ₫</td>

                    <td>
                        @if ($contract->status == App\Models\Contract::STATUS_DONE)
                        <span class="badge bg-success">đã thanh toán đủ</span>
                        @else
                        <span class="badge bg-danger">chưa thanh toán đủ</span>

                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Xem lịch sử</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
 <script>
      

        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("studentTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection