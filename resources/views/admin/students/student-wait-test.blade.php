@extends('admin.index')
@section('header-content')
    Học viên chờ test
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Học viên chờ test</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <input id="searchInput" type="text" class="form-control" placeholder="Tìm nhanh..."
                                style="width: 200px; margin-right: 10px;" onkeyup="searchTable()">

                            {{-- <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button> --}}
                            <button class="btn btn-secondary" id="toggleSearchBtn" style="margin-right: 10px;">
                                <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                            </button>
                            {{-- <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button> --}}
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('/admin/students/create-wait-test') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/students/wait-test') }}">
                    <div class="row">





                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="course" class="form-control" placeholder="Nhập tên khóa học">
                        </div> --}}
                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngôn ngữ</label>
                            <select id="language" class="form-select" name="language_id">
                                <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}"
                                        {{ isset($datas['language_id']) && $datas['language_id'] == $language->id ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Chọn chứng chỉ</label>
                            <select id="certificate" class="form-select" name="certificate_id">
                                <option value="">-- Chọn chứng chỉ --</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}" data-lang="{{ $certificate->language_id }}"
                                        {{ isset($datas['certificate_id']) && $datas['certificate_id'] == $certificate->id ? 'selected' : '' }}>
                                        {{ $certificate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1"
                                    {{ isset($datas['status']) && $datas['status'] == 1 ? 'selected' : '' }}>Trong thời gian
                                </option>
                                <option value="2"
                                    {{ isset($datas['status']) && $datas['status'] == 2 ? 'selected' : '' }}>Còn hạn
                                </option>
                                <option value="3"
                                    {{ isset($datas['status']) && $datas['status'] == 3 ? 'selected' : '' }}>Hết hạn
                                </option>

                            </select>

                        </div>


                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            <a href="{{ url('admin/students/wait-test') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <div class="col-md-12">
                <table class="table table-bordered" id="studentTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Tên</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Ngôn ngữ</th>
                            <th>Chứng chỉ</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tiến hành</th>
                            <th>Điểm thi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->phone_number }}</td>
                                <td>{{ $student->email }}</td>
                                {{-- -thêm dữ liệu mẫu cho th --}}
                                <td>{{ $student->language_name }}</td>
                                <td>{{ $student->certificate_name }}</td>
                                @php

                                    $today = Carbon\Carbon::today();
                                    $registerDate = Carbon\Carbon::parse($student->register_date)->startOfDay();
                                @endphp

                                @if ($today->isSameDay($registerDate))
                                    <td><span class="badge bg-success">Trong thời gian</span></td>
                                @elseif($today->lt($registerDate))
                                    <td><span class="badge bg-primary">Còn hạn</span></td>
                                @else
                                    <td><span class="badge bg-danger">Hết hạn</span></td>
                                @endif


                                <td>
                                    {{ $student->register_date ? \Carbon\Carbon::parse($student->register_date)->format('d/m/Y') : '' }}
                                </td>

                                <td>Chưa có</td>
                                <td class="d-flex text-center">

                                    @if ($student->pdf_test_file)
                                        <a href="{{ asset($student->pdf_test_file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-sm btn-outline-secondary mr-3 disabled">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                    @endif

                                    <a href="{{ url('/admin/students/wait-test/edit/' . $student->student_profile_id) }}"
                                        class="btn btn-sm btn-warning ml-3"><i class="fa-solid fa-pen-to-square"></i>
                                        Sửa</a>
                                    <form action="{{ url('/admin/students/delete-wait-test') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="studentId" value="{{ $student->id }}">
                                        <input type="hidden" name="studentProfileId"
                                            value="{{ $student->student_profile_id }}">
                                        <button type="submit" class="btn btn-sm btn-danger ml-3"><i
                                                class="fa-solid fa-trash"></i>
                                            Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Lưu trạng thái form vào sessionStorage (chỉ lưu tạm trong tab trình duyệt)
        document.getElementById('toggleSearchBtn').addEventListener('click', function() {
            const form = document.getElementById('form-search');
            const isVisible = form.style.display === 'block';
            form.style.display = isVisible ? 'none' : 'block';
            sessionStorage.setItem('formVisible', !isVisible);
        });

        // Giữ trạng thái mở/đóng khi F5
        window.addEventListener('DOMContentLoaded', function() {
            const savedState = sessionStorage.getItem('formVisible') === 'true';
            document.getElementById('form-search').style.display = savedState ? 'block' : 'none';
        });
    </script>
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

    <script>
        const languageSelect = document.getElementById('language');
        const certificateSelect = document.getElementById('certificate');

        // Lưu danh sách chứng chỉ gốc
        const allCertificates = Array.from(certificateSelect.options).slice(1); // bỏ option đầu tiên "-- Chọn chứng chỉ --"

        languageSelect.addEventListener('change', function() {
            const selectedLang = this.value;

            // Xóa các option hiện tại (giữ lại dòng đầu tiên)
            certificateSelect.innerHTML = '<option value="">-- Chọn chứng chỉ --</option>';

            // Lọc chứng chỉ theo language_id
            const filtered = allCertificates.filter(opt =>
                !selectedLang || opt.getAttribute('data-lang') === selectedLang
            );

            // Thêm lại các option phù hợp
            filtered.forEach(opt => certificateSelect.appendChild(opt));
        });
    </script>
@endsection
