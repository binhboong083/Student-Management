<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    use HasFactory;
    protected $table = 'sinh_viens'; // tên bảng trong cơ sở dữ liệu
    protected $fillable = [
        'mssv',
        'name',
        'class_id',
        'date',
        'gender',
        'phone',
        'email',
        'thumb'
    ];

    public function lopquanly()
    {
        return $this->hasOne(LopQuanLy::class, 'id', 'class_id')
            ->withDefault(['tenlop' => '']);
    }
}
