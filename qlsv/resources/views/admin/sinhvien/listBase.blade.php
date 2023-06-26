{{-- Bảng sinh viên --}}
@extends('admin.main')
@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Tên sinh viên</th>
                <th>Lớp</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($svs as $sv)
                <tr>
                    <td>{{ $sv->mssv }}</td>
                    <td>{{ $sv->name }}</td>
                    <td>{{ $sv->lopMonHoc->TenLop }}</td>
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
        </tbody>
    </table>
    {{ $svs->links() }}
@endsection
