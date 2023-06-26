<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dkhocphan extends Model
{
    use HasFactory;
    protected $table = 'dkhocphans'; // tên bảng trong cơ sở dữ liệu
    protected $fillable = [
        'idsv',
        'idlop',
    ];
    public function sinhviens()
    {
        return $this->hasMany(SinhVien::class, 'id', 'idsv');
    }
    public function monhocs()
    {
        return $this->hasMany(LopMonHoc::class, 'id', 'idlop');
    }
}
