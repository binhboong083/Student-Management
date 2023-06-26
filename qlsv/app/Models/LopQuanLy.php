<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopQuanLy extends Model
{
    use HasFactory;

    protected $table = 'lop_quan_lies'; // tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'malop',
        'tenlop',
        'mota',
        'soluongsv',
    ];
    public function sinhViens()
    {
        return $this->hasMany(SinhVien::class, 'class_id', 'id');
    }
}
