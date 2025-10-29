@extends('admin.index')
@section('header-content')
Thống kê
@endsection
@section('content')
<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">


        <!-- Hàng 1 -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Tổng học viên</div>
                        <div class="stat-number">{{ $totalStudents }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Tổng giáo viên</div>
                        <div class="stat-number">{{ $totalTeachers }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Tổng khóa học</div>
                        <div class="stat-number">{{ $totalCourses }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="fa-solid fa-school"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Lớp đang học</div>
                        <div class="stat-number">{{ $classRunning }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HÀNG 2 -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-secondary-subtle text-secondary">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Hợp đồng trong tháng</div>
                        <div class="stat-number">{{ $contractInMonth }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Tổng doanh thu</div>
                        <div class="stat-number">{{ number_format($totalRevenue, 0, ',', '.') }} đ</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Tổng lương giáo viên</div>
                        <div class="stat-number">{{ number_format($teacherSalaries, 0, ',', '.') }} đ</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-icon bg-dark-subtle text-dark">
                        <i class="fa-solid fa-flag-checkered"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-title">Lớp đã hoàn thành</div>
                        <div class="stat-number">{{ $classFinished }}</div>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- BIỂU ĐỒ -->

        <div class="container-fluid py-3">

            <!-- BIỂU ĐỒ DOANH THU (MIỀN) -->
            <div class="row mb-4">
                <div class="col-md-8 mb-4">
                    <div class="border rounded shadow-sm p-3 bg-white" style="height: 380px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-primary">Biểu đồ miền doanh thu theo tháng</h6>
                            <select id="yearFilter" class="form-select form-select-sm" style="width: 150px;">
                                @foreach ($years as $y)
                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                    Năm {{ $y }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div style="height: 320px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!--  BIỂU ĐỒ TRÒN NGÔN NGỮ  -->
                <div class="col-md-4 mb-4">
                    <div class="border rounded shadow-sm p-3 bg-white" style="height: 380px;">
                        <h6 class="fw-bold text-center text-primary mb-3">Tỉ lệ học viên tham gia các ngôn ngữ</h6>
                        <div style="height: 310px;">
                            <canvas id="coursePieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BIỂU ĐỒ CỘT KHÓA HỌC  -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="border rounded shadow-sm p-3 bg-white" style="height: 350px;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-primary">Biểu đồ thống kê doanh số theo khóa học (lọc theo tháng)</h6>
                            <select id="monthFilter" class="form-select form-select-sm" style="width: 150px;">
                                <option value="all" {{ $selectedMonth == 'all' ? 'selected' : '' }}>Tất cả tháng</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                    Tháng {{ $m }}
                                    </option>
                                    @endfor
                            </select>
                        </div>
                        <div style="height: 280px;">
                            <canvas id="salesBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>




    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script for the revenue - area chart -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const yearFilter = document.getElementById('yearFilter');

        // === DỮ LIỆU PHP TRUYỀN SANG ===
        const chartAreaData = @json($chartAreaData);

        const labels = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        let currentYear = yearFilter.value;

        const data = {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (triệu đồng)',
                data: chartAreaData[currentYear].revenue,
                fill: true,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointRadius: 4
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Triệu đồng'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        };

        const revenueChart = new Chart(ctx, config);

        // === Khi chọn năm khác ===
        yearFilter.addEventListener('change', function() {
            const selectedYear = this.value;
            const yearData = chartAreaData[selectedYear];

            revenueChart.data.datasets[0].data = yearData.revenue;
            revenueChart.update();
        });
    });
</script>


<!-- Script for the course - bar chart -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctxPie = document.getElementById('coursePieChart').getContext('2d');
        const labels = @json($chartPieLabels);
        const data = @json($chartPieData);

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượng học viên',
                    data: data,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.parsed;
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>

<!-- Script for course - bar chart -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctxSales = document.getElementById('salesBarChart').getContext('2d');

        const courses = @json($chartSalesLabels);
        const data = @json($chartSalesData);

        const salesChart = new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: courses,
                datasets: [{
                    label: 'Doanh số (triệu đồng)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Triệu đồng'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Khóa học'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.formattedValue} triệu đồng`
                        }
                    }
                }
            }
        });

        // === Lọc theo tháng (reload page) ===
        document.getElementById('monthFilter').addEventListener('change', function() {
            const month = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('month', month);
            window.location.href = url.toString();
        });
    });
</script>


<style>
    .stat-box {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
        height: 110px;
    }

    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .stat-info {
        text-align: left;
        flex: 1;
    }

    .stat-title {
        font-size: 15px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #000;
        margin: 0;
    }
</style>



@endsection