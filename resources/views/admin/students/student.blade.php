@extends('admin.index')
@section('header-content')
    Học viên
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Danh sách học viên</h4>
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

                            <div class="btn-group" style="margin-right: 10px;">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-file-excel"></i> Excel
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" id="exportBtn"><i
                                                class="fa-solid fa-file-export"></i> Xuất file</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#importModal"><i class="fa-solid fa-file-import"></i> Import
                                            điểm</a></li>
                                </ul>
                            </div>



                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <a href="{{ url('/admin/students/create-wait-test') }}" class="btn btn-primary"
                                style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</a>
                        </div>


                    </div>
                </div>
                <!-- Modal Import Excel -->
                <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 10px;">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="importModalLabel"><i class="fa-solid fa-file-import"></i> Import
                                    điểm học viên</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Đóng"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ url('admin/students/importScore') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file" class="form-label">Chọn file Excel</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-success">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div class="card shadow-sm p-3" id="form-search" style="display: none; transition: all 0.3s ease;">
                <form method="GET" action="{{ url('admin/students/index') }}">
                    <div class="row">





                        <div class="col-md-3 mb-3">
                            <label class="form-label">Khóa học</label>
                            <input type="text" name="course" class="form-control" placeholder="Nhập tên khóa học"
                                value="{{ $datas['course'] ?? '' }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Lớp học</label>
                            <input type="text" name="class" class="form-control" placeholder="Nhập tên lớp học"
                                value="{{ $datas['class'] ?? '' }}">

                        </div>


                        <div class="col-md-12 d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-filter"></i> Lọc
                            </button>
                            <a href="{{ url('admin/students/index') }}" class="btn btn-outline-secondary">
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
                <form id="exportForm" action="{{ url('admin/students/exportSelected') }}" method="post">
                    @csrf
                    <input type="hidden" name="selected_ids" id="selected_ids">
                    <input type="hidden" name="course" value="{{ request('course') }}">
                    <input type="hidden" name="class" value="{{ request('class') }}">
                    <table class="table table-bordered align-middle" id="studentTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Tên</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>Khóa học</th>
                                <th>Level</th>
                                <th>Lớp học</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $student_id = 0;
                            ?>
                            @foreach ($students as $student)
                                @if ($student_id != $student->id)
                                    <?php
                                    $student_id = $student->id;
                                    ?>
                                    <tr>
                                        {{-- -tạo dữ liệu mẫu --}}
                                        <td rowspan="{{ $student->rowspan }}"><input type="checkbox"
                                                class="student-checkbox" data-id="{{ $student->id }}"
                                                data-name="{{ $student->name }}" data-email="{{ $student->email }}">
                                        </td>
                                        <td rowspan="{{ $student->rowspan }}">{{ $student->name }}</td>
                                        <td rowspan="{{ $student->rowspan }}">{{ $student->phone_number }}</td>
                                        <td rowspan="{{ $student->rowspan }}">{{ $student->email }}</td>
                                        <td>{{ $student->course_name }}</td>
                                        <td>{{ $student->level_name }}</td>
                                        <td><span class="badge bg-success">{{ $student->class_name }}</span></td>

                                        <td>
                                            <span class="badge bg-{{ $student->status_color }}">
                                                {{ $student->status_label }}
                                            </span>
                                        </td>

                                        <td rowspan="{{ $student->rowspan }}">
                                            {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Tạo hợp
                                        đồng</a> --}}
                                            <a href="{{ url('admin/students/edit/' . $student->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i>
                                                Thông tin của học viên</a>
                                            {{-- <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>
                                            Xóa</a> --}}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $student->course_name }}</td>
                                        <td>{{ $student->level_name }}</td>
                                        <td><span class="badge bg-success">{{ $student->class_name ?? '' }}</span></td>
                                        <td>
                                            <span class="badge bg-{{ $student->status_color }}">
                                                {{ $student->status_label }}
                                            </span>
                                        </td>

                                    </tr>

                                    {{-- <td>
                                    {{-- <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i> Tạo hợp
                                        đồng</a> 
                                    <a href="#" class="btn btn-sm btn-warning"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Sửa</a>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i>
                                        Xóa</a>
                                </td> --}}
                                @endif
                            @endforeach

                            {{-- <tr>
                            {{-- -tạo dữ liệu mẫu 

                            <td>Trung</td>
                            <td>HsK</td>
                            <td><span class="badge bg-success">Đang tiến hành</span></td>

                            <td>8</td>

                        </tr> --}}

                        </tbody>
                    </table>
                </form>
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
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const selectedBox = document.getElementById('selectedBox');
        const selectedList = document.getElementById('selectedList');

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedList();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedList));

        function updateSelectedList() {
            selectedList.innerHTML = '';
            const selected = Array.from(checkboxes).filter(cb => cb.checked);
            if (selected.length > 0) {
                selectedBox.style.display = 'block';
                selected.forEach(cb => {
                    const li = document.createElement('li');
                    li.textContent = `${cb.dataset.name} (${cb.dataset.email})`;
                    selectedList.appendChild(li);
                });
            } else {
                selectedBox.style.display = 'none';
            }
        }
        document.getElementById('exportBtn').addEventListener('click', function() {
            const checked = document.querySelectorAll('.student-checkbox:checked');
            if (checked.length === 0) {
                alert('Vui lòng chọn ít nhất một học viên để xuất!');
                return;
            }

            // Lấy danh sách ID được chọn
            const ids = Array.from(checked).map(cb => cb.dataset.id);
            // Gán vào input hidden
            document.getElementById('selected_ids').value = JSON.stringify(ids);

            // Gửi form
            document.getElementById('exportForm').submit();
        });
    </script>

    <script>
        const importForm = document.querySelector('#importModal form');
        importForm.addEventListener('submit', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
            modal.hide();
        });
    </script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('table tbody tr');

            // Gom nhóm dòng theo student ID
            const groups = {};
            let currentId = null;

            rows.forEach(row => {
                const checkbox = row.querySelector('.student-checkbox');
                if (checkbox) {
                    // Dòng đầu tiên của nhóm
                    currentId = checkbox.dataset.id;
                    groups[currentId] = [row];
                } else if (currentId) {
                    // Dòng phụ thuộc nhóm hiện tại
                    groups[currentId].push(row);
                }
            });

            // Lọc hiển thị
            Object.values(groups).forEach(group => {
                const groupText = group.map(r => r.textContent.toLowerCase()).join(' ');
                const visible = groupText.includes(keyword);
                group.forEach(r => r.style.display = visible ? '' : 'none');
            });
        });
    </script>
@endsection
