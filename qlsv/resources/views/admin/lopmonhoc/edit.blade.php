{{-- Bảng lớp môn học --}}
@extends('admin.main')
@section('content')
    <form id="lop-form" action="" method="post">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Mã lớp học <strong style="color: red;">*</strong></label>
                <input type="text" value="{{ $lop->malop }} " name="malop" class="form-control" id="malop"
                    placeholder="Nhập mã lớp học">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Tên lớp học <strong style="color: red;">*</strong></label>
                <input type="text" value="{{ $lop->tenlop }}" name="tenlop" class="form-control" id="tenlop"
                    placeholder="Nhập tên lớp học">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mô tả</label>
                <textarea name="mota" id="mota" rows="10" cols="80">
                        {{ $lop->mota }}
                </textarea>
                <script>
                    CKEDITOR.replace('mota');
                </script>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Số lượng sinh viên <strong style="color: red;">*</strong></label>
                <input type="number" value="{{ $lop->soluongsv }}" name="soluongsv" class="form-control" id="soluongsv"
                    placeholder="Nhập số lượng sinh viên">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
        @csrf
    </form>
@endsection
