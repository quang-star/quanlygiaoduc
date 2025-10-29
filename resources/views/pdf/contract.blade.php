<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hợp đồng khóa học</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; }
        .header p { margin: 2px 0; }

        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; margin-bottom: 10px; font-size: 16px; border-bottom: 1px solid #000; padding-bottom: 5px; }

        .info-table, .course-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 5px 8px; }
        .course-table th, .course-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .course-table th { background-color: #f0f0f0; }

        .note { margin-top: 10px; font-style: italic; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>HỢP ĐỒNG KHÓA HỌC</h2>
        <p>Mã hợp đồng: {{ $contract->code }}</p>
        <p>Ngày ký: {{ \Carbon\Carbon::parse($contract->sign_date)->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Thông tin học viên</div>
        <table class="info-table">
            <tr>
                <td><strong>Họ tên:</strong> {{ $contract->studentProfile->student->name }}</td>
                <td><strong>Email:</strong> {{ $contract->studentProfile->student->email }}</td>
            </tr>
            <tr>
                <td><strong>Điện thoại:</strong> {{ $contract->studentProfile->student->phone_number }}</td>
                <td><strong>Level:</strong> {{ $contract->studentProfile->level->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Thông tin khóa học</div>
        <table class="course-table">
            <thead>
                <tr>
                    <th>Khóa học</th>
                    <th>Chứng chỉ</th>
                    <th>Ngôn ngữ</th>
                    <th>Thời lượng</th>
                    <th>Tổng tiền ($)</th>
                    <th>Học phí thực đóng ($)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $contract->course->name }}</td>
                    <td>{{ $contract->certificate->name }}</td>
                    <td>{{ $contract->studentProfile->language->name }}</td>
                    <td>{{ $contract->course->total_lesson }} buổi</td>
                    <td>{{ number_format($contract->total_value, 0, ',', '.') }}</td>
                    <td>{{ number_format($contract->total_value - ($contract->discount ?? 0), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($contract->note)
    <div class="section">
        <div class="section-title">Ghi chú</div>
        <p class="note">{{ $contract->note }}</p>
    </div>
    @endif

    <div class="footer">
        Học viên ký: ....................... &nbsp;&nbsp;&nbsp; Trung tâm ký: .......................<br>
        Đây là hợp đồng tự động được tạo bởi hệ thống quản lý trung tâm.
    </div>

</body>
</html>
