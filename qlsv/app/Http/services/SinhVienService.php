<?php

namespace App\Http\Services;

use App\Models\LopQuanLy;
use App\Models\SinhVien;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SinhVienService
{
    public function getClass()
    {
        $data = DB::select("select * from lop_quan_lies");
        //return $data;
        return LopQuanLy::all();
    }

    public function create($request)
    {
        try {
            $request->except('_token');
            SinhVien::create($request->all());
        }
        //xử lý exception, nếu có exception thì lấy ra message và hiển thị ra màn hình.
        catch (\Exception $ex) {
            // session()->flash('error', $ex->getMessage());
            return false;
        }
        return true;
    }

    // public function getAll()
    // {
    //     return SinhVien::paginate(5);
    // }
    // $query->where('sinh_viens.name', 'LIKE', "%{$search}%")
    //     ->orWhere('sinh_viens.mssv', 'LIKE', "%{$search}%")
    //     ->orWhere('sinh_viens.phone', 'LIKE', "%{$search}%");

    public function getAll($sortField = null, $order = 'asc', $search = null, $optionSearch = null, $perPage = 10)
    {
        $query = DB::table('sinh_viens')
            ->join('lop_quan_lies', 'sinh_viens.class_id', '=', 'lop_quan_lies.id')
            ->select('sinh_viens.*', 'lop_quan_lies.tenlop');

        if ($search) {
            if ($optionSearch == "mssv") {
                $query->where('sinh_viens.mssv', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "name") {
                $query->where('sinh_viens.name', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "tenlop") {
                $query->where('lop_quan_lies.tenlop', 'LIKE', "%{$search}%");
            } else if ($optionSearch == "phone") {
                $query->where('sinh_viens.phone', 'LIKE', "%{$search}%");
            }
        }

        if ($sortField) {
            $query->orderBy($sortField, $order);
        }

        return $query->paginate($perPage);
    }
    public function delete($request)
    {
        $sinhvien = SinhVien::where('id', $request->input('id'))->first();
        if ($sinhvien) {
            $path = str_replace('storage', 'public', $sinhvien->thumb);
            Storage::delete($path);
            $sinhvien->delete();
            return true;
        }
        return false;
    }
    public function deletemany($request)
    {
        // $sinhvien = SinhVien::whereIn('id', explode(',', $request->input('ids')));
        // if ($sinhvien) {
        //     return $sinhvien->delete();
        // }
        // return false;
        $ids = $request->input('ids');
        $arr = explode(",", $ids);
        $success = false;
        foreach ($arr as $id) {
            $sinhvien = SinhVien::where('id', $id)->first();
            if ($sinhvien) {
                $success = true;
                $path = str_replace('storage', 'public', $sinhvien->thumb);
                Storage::delete($path);
                $sinhvien->delete();
            }
        }
        return $success;
    }

    public function edit($request, $sinhvien)
    {
        //dd($sinhvien);
        try {
            $sinhvien->fill($request->input());
            $sinhvien->save();
            $message = 'Cập nhật thông tin thành công!';
            // session()->flash('success', $message);
            toastr()->success($message, 'Thông báo');
        } catch (\Exception $ex) {
            // session()->flash('error', $ex->getMessage());
            toastr()->error($ex->getMessage(), 'Thông báo');
            return false;
        }
        return true;
    }
}
