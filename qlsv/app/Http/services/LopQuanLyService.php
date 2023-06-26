<?php

namespace App\Http\Services;

use App\Models\LopQuanLy;
use Illuminate\Support\Facades\DB;

class LopQuanLyService
{
    public function create($request)
    {
        try {
            $request->except('_token');
            LopQuanLy::create($request->all());
            $message = 'Thêm mới lớp quản lý thành công!';
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
        $query = LopQuanLy::query();
        LopQuanLy::where('malop', 'like', "%$search%");
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
        $lop = LopQuanLy::where('id', $request->input('id'))->first();
        if ($lop) {
            return $lop->delete();
        }
        return false;
    }
    public function deletemany($request)
    {
        $lop = LopQuanLy::whereIn('id', explode(',', $request->input('ids')));
        if ($lop) {
            return $lop->delete();
        }
        return false;
    }
    public function edit($request, $lop)
    {
        //dd($lopQuanLy);
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
