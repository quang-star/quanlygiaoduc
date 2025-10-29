<h2 style="text-align:center">HỢP ĐỒNG KHÓA HỌC</h2>
<hr>
<p><strong>Học viên:</strong> {{ $contract->studentProfile->student->name }}</p>
<p><strong>Email:</strong> {{ $contract->studentProfile->student->email }}</p>
<p><strong>Khóa học:</strong> {{ $contract->course->name }}</p>
<p><strong>Level:</strong> {{ $contract->studentProfile->level->name }}</p>
<p><strong>Ngày ký:</strong> {{ \Carbon\Carbon::parse($contract->sign_date)->format('d/m/Y') }}</p>
<p><strong>Tổng tiền:</strong> ${{ $contract->total_value }}</p>
<p><strong>Ghi chú:</strong> {{ $contract->note ?? 'Không có' }}</p>
<hr>
<p style="text-align:center">Cảm ơn bạn đã đăng ký khóa học!</p>
