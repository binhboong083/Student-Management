<?php

namespace App\Http\Services;

use App\Models\LopMonHoc;
use Illuminate\Support\Facades\DB;

class LopMonHocService
{
    public function create($request)
    {
        try {
            $request->except('_token');
            LopMonHoc::create($request->all());
            $message = 'Thêm mới lớp môn học thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
        }
        //xử lý exception, nếu có exception thì lấy ra message và hiển thị ra màn hình.
        catch (\Exception $ex) {
            // session()->flash('error', $ex->getMessage());
            \toastr()->error($ex->getMessage(), 'Thông báo');
            return false;
        }
        return true;
    }
    public function getAll($search = null, $optionSearch = null, $perPage = 10)
    {
        $query = LopMonHoc::query();
        LopMonHoc::where('malop', 'like', "%$search%");
        // Tìm kiếm
        if ($search) {
            if ($optionSearch == "malop") {
                $query->where('malop', 'like', "%$search%");
            } else if ($optionSearch == "tenlop") {
                $query->where('tenlop', 'like', "%$search%");
            }
        }
        return $query->paginate($perPage);
    }
    public function delete($request)
    {
        $lop = LopMonHoc::where('id', $request->input('id'))->first();
        if ($lop) {
            return $lop->delete();
        }
        return false;
    }
    public function deletemany($request)
    {
        $lop = LopMonHoc::whereIn('id', explode(',', $request->input('ids')));
        if ($lop) {
            return $lop->delete();
        }
        return false;
    }

    public function edit($request, $lop)
    {
        //dd($lop);
        try {
            $lop->fill($request->input());
            $lop->save();
            $message = 'Cập nhật thông tin thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
        } catch (\Exception $ex) {
            // session()->flash('error', $ex->getMessage());
            \toastr()->error($ex->getMessage(), 'Thông báo');
            return false;
        }
        return true;
    }
}
