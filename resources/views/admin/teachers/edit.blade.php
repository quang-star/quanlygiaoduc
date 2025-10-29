@extends('admin.index')

@section('header-content')
    chỉnh sửa giảng viên
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">

            <div class="col-md-12 mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-user-pen"></i> Chỉnh sửa giảng viên</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end">
                        <a id="backBtn" class="btn btn-light me-2">
                            <i class="fa-solid fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="#" class="btn btn-warning"
                            onclick="document.getElementById('editTeacherForm').submit();">
                            <i class="fa-solid fa-check"></i> Lưu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form chỉnh sửa giảng viên -->
            <form id="editTeacherForm" action="{{ url('/admin/teachers/update') }}" method="POST">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Họ tên</label>
                        <input type="text" class="form-control" name="name" value="{{ $teacher->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $teacher->email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ $teacher->phone_number }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Ngày sinh</label>
                        <input type="date" class="form-control" name="birthday" value="{{ $teacher->birthday }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Lương cơ sở (VNĐ / buổi dạy)</label>
                        <input type="number" class="form-control" name="base_salary" value="{{ $teacher->base_salary }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Ngân hàng</label>
                        <input type="text" class="form-control" name="bank_name"
                            value="{{ $teacher->bankAccount->bank }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Số tài khoản</label>
                        <input type="text" class="form-control" name="bank_account"
                            value="{{ $teacher->bankAccount->account_number }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="0" {{ $teacher->active == App\Models\User::ACTIVE ? 'selected' : '' }}>Hoạt
                                động</option>
                            <option value="1" {{ $teacher->active == App\Models\User::INACTIVE ? 'selected' : '' }}>
                                Ngưng hoạt động</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <div class="col-md-12 mt-4">
        <div class="row g-4">
            <div class="col-md-6">
                <canvas id="teachingChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="classingChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="salaryChart"></canvas>
            </div>
        </div>
    </div>

    {{-- JS cho biểu đồ --}}
  <script>
    const teachingLabels = {!! json_encode(array_keys($teachingData)) !!};
    const teachingValues = {!! json_encode(array_values($teachingData)) !!};

    const classLabels = {!! json_encode(array_keys($classData)) !!};
    const classValues = {!! json_encode(array_values($classData)) !!};

    const salaryLabels = {!! json_encode(array_keys($salaryData)) !!};
    const salaryValues = {!! json_encode(array_values($salaryData)) !!};

    const pass = {{ $testStats->pass_count ?? 0 }};
    const fail = {{ $testStats->fail_count ?? 0 }};

    // Biểu đồ buổi dạy
    new Chart(document.getElementById('teachingChart'), {
        type: 'bar',
        data: {
            labels: teachingLabels,
            datasets: [{
                label: 'Số buổi dạy',
                data: teachingValues,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Biểu đồ lớp học
    new Chart(document.getElementById('classingChart'), {
        type: 'bar',
        data: {
            labels: classLabels,
            datasets: [{
                label: 'Số lớp dạy',
                data: classValues,
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Biểu đồ lương
    new Chart(document.getElementById('salaryChart'), {
        type: 'line',
        data: {
            labels: salaryLabels,
            datasets: [{
                label: 'Thu nhập (VNĐ)',
                data: salaryValues,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.3)',
                tension: 0.3
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Biểu đồ điểm (nếu có)
    // new Chart(document.getElementById('resultChart'), {
    //     type: 'pie',
    //     data: {
    //         labels: ['Đạt', 'Chưa đạt'],
    //         datasets: [{ data: [pass, fail], backgroundColor: ['#28a745', '#dc3545'] }]
    //     },
    //     options: { plugins: { legend: { position: 'bottom' } } }
    // });
</script>

@endsection
