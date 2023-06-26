<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LopMonHoc;
use Illuminate\Http\Request;
use App\Http\Services\LopMonHocService;
use App\Http\Requests\LopCreateRequest;

class LopMonHocController extends Controller
{
    //
    protected $lopmonhocService;

    public function __construct(LopMonHocService $lopmonhocService)
    {
        $this->lopmonhocService = $lopmonhocService;
    }

    public function create()
    {
        return view('admin.lopmonhoc.add', [
            'title' => 'Thêm mới lớp môn học'
        ]);
    }

    public function store(Request $request)
    {
        //xu ly them moi lop mon hoc
        //dd($request->input());
        $result = $this->lopmonhocService->create($request);
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $optionSearch = $request->query('optionSearch') ?? 'malop';
        $search = $request->query('search');
        $perPage = $request->query('perPage') ?? 10;

        return view('admin.lopmonhoc.list', [
            'title' => 'Danh sách lớp môn học',
            'lopmonhocs' => $this->lopmonhocService->getAll($search, $optionSearch, $perPage),
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function delete(Request $request)
    {
        //xử lý xóa
        $result = $this->lopmonhocService->delete($request);
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
            'error' => 'true',
            'message' => $message
        ]);
    }
    // Hàm xóa hàng loạt
    public function deletemany(Request $request)
    {
        //xử lý xóa
        // dd($request->input('ids'));
        $result = $this->lopmonhocService->deletemany($request);
        $message = '';
        if ($result) {
            $message = 'Xóa bản ghi thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } else {
            $message = 'Xóa bản ghi thất bại!';
            // session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        }
    }
    public function show(LopMonHoc $lop)
    {
        return view('admin.lopquanly.edit', [
            'title' => "Sửa lớp môn học",
            'lop' => $lop
        ]);
    }

    public function edit(Request $request, LopMonHoc $lop)
    {
        $result = $this->lopmonhocService->edit($request, $lop);
        if ($result) {
            return redirect()->route('admin.lopmonhoc.list');
        }
        return redirect()->back();
    }
}