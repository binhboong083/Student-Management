{{-- Bảng lớp môn học --}}
@extends('admin.main')
@section('content')
    <form id="lop-form" action="/admin/lopmonhoc/add/store" method="post">
        <div class="card-body">
            <div class="form-group">
                <label for="malop">Mã lớp học <strong style="color: red;">*</strong></label>
                <input type="text" name="malop" class="form-control" id="malop" placeholder="Nhập mã lớp học"
                    value="{{ old('malop') }}">
            </div>
            <div class="form-group">
                <label for="tenlop">Tên lớp học <strong style="color: red;">*</strong></label>
                <input type="text" name="tenlop" class="form-control" id="tenlop" placeholder="Nhập tên lớp học"
                    value="{{ old('tenlop') }}">
            </div>

            <div class="form-group">
                <label for="mota">Mô tả</label>
                <textarea name="mota" id="mota" rows="10" cols="80">Nhập mô tả vào đây</textarea>
                <script>
                    CKEDITOR.replace('mota');
                </script>
            </div>

            <div class="form-group">
                <label for="soluongsv">Số lượng sinh viên <strong style="color: red;">*</strong></label>
                <input type="number" name="soluongsv" class="form-control" id="soluongsv"
                    placeholder="Nhập số lượng sinh viên" value="{{ old('soluongsv') }}">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
        @csrf
    </form>
@endsection
