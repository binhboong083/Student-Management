<?php

namespace App\Http\Controllers;

use App\Http\Services\DangKyHocPhanService;
use App\Models\LopMonHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DangKyHocPhanController extends Controller
{
    protected $dangKyHocPhanService;

    public function __construct(DangKyHocPhanService $dangKyHocPhanService)
    {
        $this->dangKyHocPhanService = $dangKyHocPhanService;
    }

    public function index(Request $request)
    {
        $optionSearch = $request->input('optionSearch') ?? 'mssv';
        $search = $request->input('search');
        $perPage = $request->input('perPage') ?? 5;

        $optionSearch2 = $request->input('optionSearch2') ?? 'mssv';
        $search2 = $request->input('search2');
        $perPage2 = $request->input('perPage2') ?? 5;
        //
        // $lopMonHoc = LopMonHoc::first();
        // $idlopMD = $lopMonHoc->id;

        $idlopMD = LopMonHoc::first()->id;

        $idlop = $request->input('idlop') ?? $idlopMD;

        return view('admin.dkhocphan.list', [
            'title' => 'Đăng ký lớp học phần cho sinh viên',
            'datas' => $this->dangKyHocPhanService->getAll($search, $optionSearch, $perPage, $idlop),
            'datas2' => $this->dangKyHocPhanService->getAll2($search2, $optionSearch2, $perPage2, $idlop),
            'search' => $search,
            'perPage' => $perPage,
            'search2' => $search2,
            'perPage2' => $perPage2,
            'lops' => $this->dangKyHocPhanService->getClass(),
            'idlop' => $idlop,
        ]);
    }

    public function store(Request $request)
    {
        // Xử lý thêm mới sinh viên
        //dd($request->input());
        $return = $this->dangKyHocPhanService->check($request);
        $message = '';
        if ($return == 0) {
            $message = 'Đăng ký học phần lỗi!';
            // session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } else if ($return == 1) {
            $message = 'Đăng ký học phần thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        } else if ($return == -1) {
            $message = 'Hết slot!';
            // session()->flash('error', $message);
            \toastr()->info($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        }
    }
    public function storemany(Request $request)
    {
        // Xử lý thêm mới nhiều bản ghi
        $return = $this->dangKyHocPhanService->checkmany($request);
        $message = '';
        if ($return == -2) {
            $message = 'Hết slot!';
            // session()->flash('error', $message);
            \toastr()->info($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        } else if ($return == -1) {
            $message = 'Đăng ký học phần lỗi!';
            // session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        } else if ($return == 0) {
            $message = 'Đăng ký học phần thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } else if ($return > 0) {
            $message = 'Chỉ còn ' . $return . ' slot nữa thôi!';
            // session()->flash('warning', $message);
            \toastr()->info($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' =>  $message
            ]);
        }
    }

    public function delete(Request $request)
    {
        //xử lý xóa
        $result = $this->dangKyHocPhanService->delete($request);
        $message = '';
        if ($result) {
            $message = 'Xóa bản ghi thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        }
        $message = 'Xóa bản ghi thất bại!';
        // session()->flash('error', $message);
        \toastr()->error($message, 'Thông báo');
        return response()->json([
            'error' => true,
            'message' => $message
        ]);
    }
    // Hàm xóa hàng loạt
    public function deletemany(Request $request)
    {
        //xử lý xóa
        // dd($request->input('ids'));
        $result = $this->dangKyHocPhanService->deletemany($request);
        $message = '';
        if ($result) {
            $message = 'Xóa nhiều bản ghi thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } else {
            $message = 'Xóa nhiều bản ghi thất bại!';
            // session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        }
    }
}
