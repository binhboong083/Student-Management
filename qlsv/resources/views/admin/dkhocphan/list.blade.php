{{-- Bảng đăng ký lớp học phần cho sinh viên --}}
@extends('admin.main')
@section('content')
    {{-- Combobox lựa lớp học phần --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="col-auto">
                <div class="form-group">
                    <label for="idlop">Chọn lớp môn học <strong style="color: red;">*</strong></label>
                    <select class="form-control" name="idlop" id="idlop"
                        onchange="refreshData('idlop',$('#idlop').val())">
                        @foreach ($lops as $lop)
                            <option value="{{ $lop->id }}" {{ $idlop == $lop->id ? 'selected' : '' }}>
                                {{ $lop->tenlop }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        {{-- Bảng 1 --}}
        <div class="col-md-6">
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
                        <input type="hidden" name="idsvs" id="insert-ids">
                        <button class="btn btn-success"
                            onclick="beforeInsertMany($('#idlop').val(),'/admin/dkhocphan/storemany')">
                            <i class="fas fa-plus"> Add more</i>
                        </button>
                    </div>
                </div>
                {{--  --}}
                <label><strong>Danh sách sinh viên chưa đăng ký</strong></label>
                <div>
                    <span>Hiển thị</span>
                    <select id="perPage1" name="perPage1" onchange="refreshData('perPage',$('#perPage1').val())">
                        <option value="5" {{ request()->query('perPage') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request()->query('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request()->query('perPage') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request()->query('perPage') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    bản ghi/trang
                </div>
                <table class="table table-bordered table-hover" id="table-data1">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" id="check-all" onchange="checkAll(this)">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col" hidden>ID</th>
                            <th scope="col" onclick="sortTable(3,'table-data1')"><a href="#">Mã sinh viên
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th scope="col" onclick="sortTable(4,'table-data1')"><a href="#">Tên sinh viên
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th scope="col" onclick="sortTable(5,'table-data1')"><a href="#">Tên lớp
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($datas->count())
                            @foreach ($datas as $index => $sv)
                                <tr>
                                    <td><input type="checkbox" class="checkbox"></td>
                                    <td>{{ $datas->firstItem() + $index }}</td>
                                    <td hidden>{{ $sv->id }}</td>
                                    <td>{{ $sv->mssv }}</td>
                                    <td>{{ $sv->name }}</td>
                                    <td>{{ $sv->tenlop }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm"
                                            onclick="beforeInsert({{ $sv->id }},$('#idlop').val(),'/admin/dkhocphan/store')">
                                            <i class="fas fa-plus"> Đăng ký</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Không có sinh viên nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{-- {{ $datas->appends(['perPage' => request()->query('perPage')])->links() }} --}}
                {{ $datas->appends(['perPage' => $perPage, 'perPage2' => $perPage2, 'idlop' => $idlop])->links() }}
            </div>
        </div>

        {{-- Bảng 2 --}}
        <div class="col-md-6">
            <div class="col-auto">
                {{-- Tìm kiếm --}}
                <div class="row mb-3">
                    <div class="col-auto">
                        <input type="text" name="search2" class="form-control" placeholder="Tìm kiếm"
                            value="{{ request()->query('search2') }}">
                    </div>
                    <div class="col-auto">
                        <select name="optionSearch2" class="form-control">
                            <option value="mssv" {{ request()->query('optionSearch2') == 'mssv' ? 'selected' : '' }}>Mã
                                SV
                            </option>
                            <option value="name" {{ request()->query('optionSearch2') == 'name' ? 'selected' : '' }}>
                                Tên
                                SV
                            </option>
                            <option value="tenlop" {{ request()->query('optionSearch2') == 'tenlop' ? 'selected' : '' }}>
                                Tên lớp
                            </option>
                            <option value="phone" {{ request()->query('optionSearch2') == 'phone' ? 'selected' : '' }}>
                                Số
                                điện thoại
                            </option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary"
                            onclick="searchOption('search2', $('input[name=\'search2\']').val(), 'optionSearch2' , $('select[name=\'optionSearch2\']').val())">
                            Tìm kiếm
                        </button>
                    </div>
                    <div class="col-auto ml-auto">
                        <input type="hidden" name="ids" id="delete-ids">
                        <button class="btn btn-danger" onclick="beforeClearHocPhan('/admin/dkhocphan/deletemany')">
                            <i class="fas fa-trash"> Delete more</i>
                        </button>
                    </div>
                </div>
                {{--  --}}
                <label><strong>Danh sách sinh viên đã đăng ký</strong></label>
                <div>
                    <span>Hiển thị</span>
                    <select id="perPage2" name="perPage2" onchange="refreshData('perPage2',$('#perPage2').val())">
                        <option value="5" {{ request()->query('perPage2') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request()->query('perPage2') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request()->query('perPage2') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request()->query('perPage2') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    bản ghi/trang
                </div>
                <table class="table table-bordered table-hover" id="table-data2">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" id="check-all2" onchange="checkAll2(this)">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col" hidden>ID Đăng ký</th>
                            <th scope="col" onclick="sortTable(3,'table-data2')"><a href="#">Mã sinh viên
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th scope="col" onclick="sortTable(4,'table-data2')"><a href="#">Tên sinh viên
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th scope="col" onclick="sortTable(5,'table-data2')"><a href="#">Tên lớp
                                    <i class="fa fa-fw fa-sort"></i></a></th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($datas2->count())
                            @foreach ($datas2 as $index => $sv)
                                <tr>
                                    <td><input type="checkbox" class="checkbox2"></td>
                                    <td>{{ $datas2->firstItem() + $index }}</td>
                                    <td hidden>{{ $sv->iddk }}</td>
                                    <td>{{ $sv->mssv }}</td>
                                    <td>{{ $sv->name }}</td>
                                    <td>{{ $sv->tenlop }}</td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="removeRow({{ $sv->iddk }},'/admin/dkhocphan/delete')">
                                            <i class="fas fa-trash"> Hủy</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Không có sinh viên nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{-- {{ $datas2->appends(['perPage2' => request()->query('perPage2')])->links() }} --}}
                {{ $datas2->appends(['perPage' => $perPage, 'perPage2' => $perPage2, 'idlop' => $idlop])->links() }}
            </div>
        </div>
    </div>
@endsection
