@extends('admin.main')
@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.lopmonhoc.list') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm"
                        value="{{ request()->query('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <form method="GET" action="{{ route('admin.lopmonhoc.list') }}">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <select name="sort" class="form-control">
                                <option value="id" {{ request()->query('sort') == 'id' ? 'selected' : '' }}>ID</option>
                                <option value="malop" {{ request()->query('sort') == 'malop' ? 'selected' : '' }}>Mã lớp
                                </option>
                                <option value="tenlop" {{ request()->query('sort') == 'tenlop' ? 'selected' : '' }}>Tên lớp
                                </option>
                                <option value="soluongsv" {{ request()->query('sort') == 'soluongsv' ? 'selected' : '' }}>Số
                                    lượng SV
                                </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select name="order" class="form-control">
                                <option value="asc" {{ request()->query('order') == 'asc' ? 'selected' : '' }}>Tăng dần
                                </option>
                                <option value="desc" {{ request()->query('order') == 'desc' ? 'selected' : '' }}>Giảm dần
                                </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Sắp xếp</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã lớp</th>
                <th>Tên lớp</th>
                <th>Mô tả</th>
                <th>Số lượng SV</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @if ($lopmonhocs->count())
                @foreach ($lopmonhocs as $lopmonhoc)
                    <tr>
                        <td>{{ $lopmonhoc->id }}</td>
                        <td>{{ $lopmonhoc->malop }}</td>
                        <td>{{ $lopmonhoc->tenlop }}</td>
                        <td>{!! $lopmonhoc->mota !!}</td>
                        <td>{{ $lopmonhoc->soluongsv }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/lop/edit/{{ $lopmonhoc->id }}">
                                <i class="fas fa-edit"> </i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="removeRow({{ $lopmonhoc->id }},'/admin/lop/delete')">
                                <i class="fas fa-trash"> </i>
                            </a>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">Không có lớp học nào.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $lopmonhocs->appends(request()->query())->links() }}
@endsection
