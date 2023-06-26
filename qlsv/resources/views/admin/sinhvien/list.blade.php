{{-- Bảng sinh viên --}}
@extends('admin.main')
@section('content')
    <div class="col-md-12">
        <div class="col-auto">
            {{-- Tìm kiếm --}}
            <div class="row mb-3">
                <div class="col-auto">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm"
                        value="{{ request()->query('search') }}">
                </div>
                <div class="col-auto">
                    <select name="optionSearch" class="form-control">
                        <option value="mssv" {{ request()->query('optionSearch') == 'mssv' ? 'selected' : '' }}>Mã
                            SV
                        </option>
                        <option value="name" {{ request()->query('optionSearch') == 'name' ? 'selected' : '' }}>
                            Tên
                            SV
                        </option>
                        <option value="tenlop" {{ request()->query('optionSearch') == 'tenlop' ? 'selected' : '' }}>
                            Tên lớp
                        </option>
                        <option value="phone" {{ request()->query('optionSearch') == 'phone' ? 'selected' : '' }}>
                            Số
                            điện thoại
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary"
                        onclick="searchOption('search', $('input[name=\'search\']').val(), 'optionSearch' , $('select[name=\'optionSearch\']').val())">
                        Tìm kiếm
                    </button>
                </div>
                <div class="col-auto ml-auto">
                    <div class="row mb-3">
                        {{-- Thêm bản ghi --}}
                        <div class="col-auto">
                            <a href="/admin/sinhvien/add" class="btn btn-success">
                                <i class="fas fa-plus"> Add</i>
                            </a>
                        </div>
                        {{-- Xóa nhiều bản ghi --}}
                        <div class="col-auto">
                            <input type="hidden" name="ids" id="delete-ids">
                            <button class="btn btn-danger" id="delete-selected">
                                <i class="fas fa-trash"> Delete more</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Combobox lấy giá trị phân trang --}}
            <div>
                <span>Hiển thị</span>
                <select id="perPage" name="perPage">
                    <option value="10" {{ request()->query('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request()->query('perPage') == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request()->query('perPage') == 20 ? 'selected' : '' }}>20</option>
                    <option value="25" {{ request()->query('perPage') == 25 ? 'selected' : '' }}>25</option>
                </select>
                bản ghi/trang
            </div>
            {{-- Bảng sinh viên --}}
            <table class="table table-bordered table-hover" id="sinhvien-list">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="check-all" onchange="checkAll(this)">
                        </th>
                        <th scope="col">STT</th>
                        <th scope="col" hidden>ID</th>
                        <th scope="col" onclick="sortTable(3,'sinhvien-list')"><a href="#">Mã sinh viên
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th scope="col" onclick="sortTable(4,'sinhvien-list')"><a href="#">Tên sinh viên
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th scope="col" onclick="sortTable(5,'sinhvien-list')"><a href="#">Tên lớp
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th scope="col" onclick="sortTable(6,'sinhvien-list')"><a href="#">Ngày sinh
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th scope="col" onclick="sortTable(7,'sinhvien-list')"><a href="#">Số điện thoại
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($svs->count())
                        @foreach ($svs as $index => $sv)
                            <tr>
                                <td><input type="checkbox" class="checkbox"></td>
                                <td>{{ $svs->firstItem() + $index }}</td>
                                <td hidden>{{ $sv->id }}</td>
                                <td>{{ $sv->mssv }}</td>
                                <td>{{ $sv->name }}</td>
                                <td>{{ $sv->tenlop }}</td>
                                <td>{{ $sv->date }}</td>
                                <td>{{ $sv->phone }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/admin/sinhvien/edit/{{ $sv->id }}">
                                        <i class="fas fa-edit"> </i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm"
                                        onclick="removeRow({{ $sv->id }},'/admin/sinhvien/delete')">
                                        <i class="fas fa-trash"> </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">Không có sinh viên nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- Phân trang --}}
            {{ $svs->appends(['perPage' => request()->query('perPage')])->links() }}
        </div>
    </div>
    @csrf
@endsection
