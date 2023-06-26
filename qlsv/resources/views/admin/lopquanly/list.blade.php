{{-- Bảng lớp quản lý --}}
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
                        <option value="malop" {{ request()->query('optionSearch') == 'malop' ? 'selected' : '' }}>Mã lớp
                        </option>
                        <option value="tenlop" {{ request()->query('optionSearch') == 'tenlop' ? 'selected' : '' }}>
                            Tên lớp
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary"
                        onclick="searchOption('search', $('input[name=\'search\']').val(), 'optionSearch' , $('select[name=\'optionSearch\']').val())">
                        Tìm kiếm
                    </button>
                </div>
                {{-- Nút thao tác nhanh --}}
                <div class="col-auto ml-auto">
                    <div class="row mb-3">
                        {{-- Thêm bản ghi --}}
                        <div class="col-auto">
                            <a href="/admin/lopquanly/add" class="btn btn-success">
                                <i class="fas fa-plus"> Add</i>
                            </a>
                        </div>
                        {{-- Xóa nhiều bản ghi --}}
                        <div class="col-auto">
                            <input type="hidden" name="ids" id="delete-ids">
                            <button class="btn btn-danger" onclick="beforeDeletes('/admin/lopquanly/deletemany')">
                                <i class="fas fa-trash"> Delete more</i>
                            </button>
                        </div>
                    </div>
                </div>
                {{--  Kết thúc code nút thao tác nhanh --}}
            </div>
            {{-- Combobox phân trang --}}
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
            <table class="table table-bordered table-hover" id="table-sort">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="check-all" onchange="checkAll(this)"></th>
                        <th scope="col">STT</th>
                        <th scope="col" hidden>ID</th>
                        <th scope="col" onclick="sortTable(3,'table-sort')"><a href="#">Mã lớp
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th scope="col" onclick="sortTable(4,'table-sort')"><a href="#">Tên lớp
                                <i class="fa fa-fw fa-sort"></i></a></th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($lopquanlys->count())
                        @foreach ($lopquanlys as $index => $lop)
                            <tr>
                                <td><input type="checkbox" class="checkbox"></td>
                                <td>{{ $lopquanlys->firstItem() + $index }}</td>
                                <td hidden>{{ $lop->id }}</td>
                                <td>{{ $lop->malop }}</td>
                                <td>{{ $lop->tenlop }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/admin/lopquanly/edit/{{ $lop->id }}">
                                        <i class="fas fa-edit"> </i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm"
                                        onclick="removeRow({{ $lop->id }},'/admin/lopquanly/delete')">
                                        <i class="fas fa-trash"> </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">Không có lớp quản lý nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- {{ $lopquanlys->links() }} --}}
            {{ $lopquanlys->appends(['perPage' => request()->query('perPage')])->links() }}
        </div>
    </div>
@endsection
