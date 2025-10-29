@extends('admin.index')
@section('header-content')
    Lương giảng viên
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Danh sách Giảng Viên</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <!-- tìm kiếm nhanh theo tên/email -->
                            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm nhanh..."
                                style="width: 200px; margin-right: 10px;">

                            <!-- chọn tháng/năm -->
                            <input type="month" id="monthInput" class="form-control"
                                style="width: 180px; margin-right: 10px;" value="{{ $month }}">

                            <!-- xuất lương -->
                            <form id="exportForm" action="{{ url('admin/teachers/salary/export') }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <input type="hidden" id="selected_ids" name="selected_ids">
                                <input type="hidden" id="selected_month" name="month">
                                <button type="button" class="btn btn-success" id="exportBtn">
                                    <i class="fa-solid fa-file-excel"></i> Xuất lương
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- bảng danh sách lương giảng viên -->
                <table class="table table-bordered" id="teacherTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Lương cơ bản</th>
                            <th>Tổng buổi dạy</th>
                            <th>Lương thực tế</th>
                            <th>Thưởng</th>
                            <th>Tổng lương</th>
                            <th>Tháng</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salaries as $salary)
                            <tr>
                                <td><input type="checkbox" class="teacher-checkbox" data-id="{{ $salary->id }}"
                                        data-name="{{ $salary->teacher->name }}" data-email="{{ $salary->teacher->email }}">
                                </td>
                                <td>{{ $salary->teacher->name }}</td>
                                <td>{{ $salary->teacher->email }}</td>
                                <td>{{ number_format($salary->teacher->base_salary) }}</td>
                                <td>{{ $salary->total_sessions ?? 0 }}</td>
                                <td>{{ number_format(($salary->total_sessions ?? 0) * $salary->teacher->base_salary) }}
                                </td>
                                <td>{{ number_format($salary->bonus ?? 0) }}</td>
                                <td>{{ number_format($salary->total_salary ?? 0) }}</td>
                                <td>{{ $salary->month ?? now()->format('Y-m') }}</td>
                                <td>
                                    <span class="badge bg-{{ $salary->status_color }}">
                                        {{ $salary->status_label }}
                                    </span>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script>
        // Khởi tạo các biến DOM
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.teacher-checkbox');
        const exportBtn = document.getElementById('exportBtn');
        const exportForm = document.getElementById('exportForm');
        const selectedIdsInput = document.getElementById('selected_ids');
        const selectedMonthInput = document.getElementById('selected_month');
        const monthInput = document.getElementById('monthInput');
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('teacherTable').getElementsByTagName('tbody')[0];
        // Chọn / bỏ chọn tất cả
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Xuất lương
        exportBtn.addEventListener('click', function() {
            const checked = document.querySelectorAll('.teacher-checkbox:checked');
            if (checked.length === 0) {
                alert('Vui lòng chọn ít nhất một giảng viên để xuất!');
                return;
            }
            const ids = Array.from(checked).map(cb => cb.dataset.id);
            selectedIdsInput.value = JSON.stringify(ids);
            selectedMonthInput.value = monthInput.value;
            exportForm.submit();
        });

        // Khi đổi tháng thì submit form để load dữ liệu từ server
        monthInput.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('month', monthInput.value); // gắn tháng mới vào query string
            window.location.href = url.toString();
        });

        // Tìm kiếm nhanh vẫn dùng JS (lọc ngay trên DOM)
        searchInput.addEventListener('input', function() {
            const filterText = searchInput.value.toLowerCase();
            Array.from(table.rows).forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                if (name.includes(filterText) || email.includes(filterText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
