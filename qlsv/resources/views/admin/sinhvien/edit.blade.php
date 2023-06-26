{{-- Bảng sinh viên --}}
@extends('admin.main')
@section('content')
    <form action="" method="post">
        <div class="card-body">
            <div class="form-group">
                <label for="mssv">Mã sinh viên <strong style="color: red;">*</strong></label>
                <input type="number" name="mssv" class="form-control" id="mssv" value="{{ $sinhvien->mssv }}"
                    placeholder="Nhập mã số sinh viên">
            </div>
            <div class="form-group">
                <label for="name">Tên sinh viên <strong style="color: red;">*</strong></label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $sinhvien->name }}"
                    placeholder="Nhập tên sinh viên">
            </div>

            <div class="form-group">
                <label>Lớp quản lý <strong style="color: red;">*</strong></label>
                <select class="form-control" name="class_id">
                    @foreach ($lops as $lop)
                        <option value="{{ $lop->id }}" {{ $sinhvien->class_id == $lop->id ? 'selected' : '' }}>
                            {{ $lop->tenlop }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ngày sinh <strong style="color: red;">*</strong></label>
                <input type="date" class="form-control" name="date" id="date" value="{{ $sinhvien->date }}">
            </div>

            <div class="form-group">
                <label>Giới tính <strong style="color: red;">*</strong></label>
                <select class="form-control" name="gender">
                    <option value="0" {{ $sinhvien->gender == '0' ? 'selected' : '' }}>Nam</option>
                    <option value="1" {{ $sinhvien->gender == '1' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>

            <div class="form-group">
                <label>Số điện thoại <strong style="color: red;">*</strong></label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="123-456-7890"
                        pattern="[0-9]{3}[0-9]{3}[0-9]{4}" value="{{ $sinhvien->phone }}">
                </div>
                <!-- /.input group -->
            </div>

            <div class="form-group">
                <label>Email <strong style="color: red;">*</strong></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="abc@gmail.com"
                        value="{{ $sinhvien->email }}">
                </div>
            </div>

            <div class="form-group">
                <label for="file">Ảnh đại diện <strong style="color: red;">*</strong></label>
                <input type="file" name="file" class="form-control" id="upload"
                    style="text-align: center; line-height: normal;">
                <div id="image_show">
                    <a href="{{ $sinhvien->thumb }}" target="_blank">
                        <img src="{{ $sinhvien->thumb }}" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{ $sinhvien->thumb }}">
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
        @csrf
    </form>
@endsection
