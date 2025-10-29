@extends('admin.index')
@section('header-content')
    Hợp đồng
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Hợp đồng</h4>
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
                            <a href="{{ url('admin/contracts/add') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/contracts/index') }}">
                    <div class="row">





                        {{-- <div class="col-md-3 mb-3">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="course" class="form-control" placeholder="Nhập tên khóa học">
                        </div> --}}
                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngôn ngữ</label>
                            <select id="language" class="form-select" name="language_id">
                                {{-- <option value="">-- Chọn ngôn ngữ --</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach 
                            </select>
                        </div> --}}
                        {{-- <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Chọn chứng chỉ</label>
                            <select id="certificate" class="form-select" name="certificate_id">
                                <option value="">-- Chọn kh --</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}" data-lang="{{ $certificate->language_id }}">
                                        {{ $certificate->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <!-- khóa học -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Chọn khóa học</label>
                            <select name="course_id" id="courses" class="form-select">
                                <option value="">-- Chọn khóa học --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ isset($datas['course_id']) && $datas['course_id'] == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Ngày ký</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ isset($datas['date']) ? $datas['date'] : '' }}">
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="" class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="1"
                                    {{ isset($datas['status']) && $datas['status'] == 1 ? 'selected' : '' }}>Thanh toán đủ
                                </option>
                                <option value="0"
                                    {{ isset($datas['status']) && $datas['status'] == 0 ? 'selected' : '' }}>Đang thanh toán
                                </option>


                            </select>

                        </div>

                        <div class="col-md-3 mb-3">
                            <!-- sort theo lâu nhất với nhanh nhất -->
                            <label for="" class="form-label">Sắp xếp</label>
                            <select name="sort" class="form-select">
                                <option value="">-- Chọn sắp xếp --</option>
                                <option value="asc"
                                    {{ isset($datas['sort']) && $datas['sort'] == 'asc' ? 'selected' : '' }}>Lâu nhất
                                </option>
                                <option value="desc"
                                    {{ isset($datas['sort']) && $datas['sort'] == 'desc' ? 'selected' : '' }}>Gần nhất
                                </option>
                            </select>
                        </div>


                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            <a href="{{ url('admin/contracts/index') }}" class="btn btn-outline-secondary">
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
            <table class="table table-bordered" id="contractTable">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Học viên</th>

                        <th>Tổng $</th>
                        <th>Đã thu</th>
                        <th>Chưa thu</th>
                        <th>Khóa học</th>
                        <th>Ngày ký</th>
                        <th>Trạng thái</th>

                        <th>Ghi chú</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>{{ $contract->studentProfile->student->name ?? '' }}</td>
                            <td>{{ $contract->total_value }}</td>
                            <td>{{ $contract->collected }}</td>
                            <td>{{ $contract->total_value - $contract->collected }}</td>
                            <td>{{ $contract->course->name ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($contract->created_at)->format('d/m/Y H:i:s') }}</td>


                            <td>
                                @if ($contract->status == App\Models\Contract::STATUS_DONE)
                                    <span class="badge bg-success">đã thanh toán đủ</span>
                                @else
                                    <span class="badge bg-danger">chưa thanh toán đủ</span>
                                @endif
                            </td>
                            <td>{{ $contract->note ?? '' }}</td>
                            <td class="d-flex justify-content-center">
                                {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Lịch học</a> --}}
                                @if ($contract->path)
                                    <a href="{{ asset($contract->path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-success mr-3">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                @else
                                    <a class="btn btn-sm btn-outline-secondary mr-3 disabled">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                @endif

                                <a href="{{ url('admin/contracts/update/' . $contract->id) }}"
                                    class="btn btn-sm btn-warning mr-3"><i class="fa-solid fa-pen-to-square"></i> Sửa</a>
                                <form action="{{ url('/admin/contracts/delete') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>
                                        Xóa</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            const table = document.getElementById("contractTable");
            const trs = table.getElementsByTagName("tr");

            // Bỏ qua hàng tiêu đề
            for (let i = 1; i < trs.length; i++) {
                let rowText = trs[i].innerText.toLowerCase();
                trs[i].style.display = rowText.includes(filter) ? "" : "none";
            }
        }
    </script>
@endsection
