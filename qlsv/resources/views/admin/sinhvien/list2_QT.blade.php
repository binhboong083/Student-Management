{{-- Bảng sinh viên --}}
@extends('admin.main')
@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.sinhvien.list2') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm"
                        value="{{ request()->query('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.sinhvien.list2', ['sort' => 'mssv', 'order' => $order == 'asc' ? 'desc' : 'asc']) }}"
                        class="{{ $sort == 'mssv' ? 'active' : '' }}">Mã SV <i
                            class="fa fa-fw fa-sort{{ $sort == 'mssv' ? '-' . $order : '' }}"></i></a>
                </th>
                <th>
                    <a href="{{ route('admin.sinhvien.list2', ['sort' => 'name', 'order' => $order == 'asc' ? 'desc' : 'asc']) }}"
                        class="{{ $sort == 'name' ? 'active' : '' }}">Tên SV <i
                            class="fa fa-fw fa-sort{{ $sort == 'name' ? '-' . $order : '' }}"></i></a>
                </th>
                <th>
                    <a href="{{ route('admin.sinhvien.list2', ['sort' => 'class_id', 'order' => $order == 'asc' ? 'desc' : 'asc']) }}"
                        class="{{ $sort == 'class_id' ? 'active' : '' }}">Lớp <i
                            class="fa fa-fw fa-sort{{ $sort == 'class_id' ? '-' . $order : '' }}"></i></a>
                </th>
                <th>
                    <a href="{{ route('admin.sinhvien.list2', ['sort' => 'date', 'order' => $order == 'asc' ? 'desc' : 'asc']) }}"
                        class="{{ $sort == 'date' ? 'active' : '' }}">Ngày sinh <i
                            class="fa fa-fw fa-sort{{ $sort == 'date' ? '-' . $order : '' }}"></i></a>
                </th>
                <th>
                    <a href="{{ route('admin.sinhvien.list2', ['sort' => 'phone', 'order' => $order == 'asc' ? 'desc' : 'asc']) }}"
                        class="{{ $sort == 'phone' ? 'active' : '' }}">Số điện thoại <i
                            class="fa fa-fw fa-sort{{ $sort == 'phone' ? '-' . $order : '' }}"></i></a>
                </th>
            </tr>
        </thead>

        <tbody>
            @if ($svs->count())
                @foreach ($svs as $sv)
                    <tr>
                        <td>{{ $sv->mssv }}</td>
                        <td>{{ $sv->name }}</td>
                        <td>{{ $sv->TenLop }}</td>
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
                    <td colspan="6">Không có sinh viên nào.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $svs->links() }}
@endsection
