<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopMonHoc extends Model
{
    use HasFactory;
    protected $table = 'lop_mon_hocs'; // tên bảng trong cơ sở dữ liệu
    protected $fillable = [
        'malop',
        'tenlop',
        'mota',
        'soluongsv',
    ];
}
