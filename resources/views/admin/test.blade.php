@extends('admin.index')
@section('header-content')
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-left">
                <h3 style="padding-left: 30px;">Khóa học</h3>
            </div>

            <div class="col-md-6">
                <img src="{{ asset('images/avt.png') }}" alt=""
                    style="float: right; width: 50px; height: 50px; margin-top: 4px;" class="justify-content-center">
            </div>
        </div>
    </div>
    {{-- <p>Đây là trang khóa học.</p> --}}
@endsection
@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <h4><i class="fa-solid fa-table"></i> Dịch vụ</h4>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-end">
                            <input type="text" class="form-control" placeholder="Tìm kiếm..."
                                style="width: 200px; margin-right: 10px;">
                            {{-- button tim kiem mo ra form cho tim kiem theo nhieu truong khac nhau --}}
                            <button class="btn btn-secondary" style="margin-right: 10px" onclick="openorclose()">Tim
                                kiem</button>
                            <button class="btn btn-secondary" style="margin-right: 10px;"><i
                                    class="fa-solid fa-file-export"></i> Xuất file</button>
                            {{-- <button class="btn btn-secondary"><i class="fa-solid fa-filter"></i> Lọc</button> --}}
                            <button class="btn btn-primary" style="margin-right: 10px;"><i class="fa-solid fa-plus"></i>
                                Thêm mới</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="form-search" style="display: none;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            {{-- -ho ten --}}
                            <label for="validationDefault01" class="form-label">Ho ten</label>
                            <input type="text" class="form-control" id="validationDefault01" value="Mark" required>
                        </div>
                        {{-- -khoa hoc --}}
                        <div class="col-md-4 mb-3">
                            <label for="validationDefault02" class="form-label">Khoa hoc</label>
                            <input type="text" class="form-control" id="validationDefault02" value="Otto" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationDefaultUsername" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                <input type="text" class="form-control" id="validationDefaultUsername"
                                    aria-describedby="inputGroupPrepend2" required>
                            </div>
                        </div>
                        {{-- -button search --}}
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Tim kiem</button>
                        </div>
                        {{-- -button reset --}}
                        <div class="col-md-12 d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12  d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">

        </div>
    </div>
    <script>
        function openorclose() {
            var x = document.getElementById("form-search");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
@endsection
