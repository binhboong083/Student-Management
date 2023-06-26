<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\LopQuanLyService;
use App\Models\LopQuanLy;
use App\Http\Requests\LopQuanLyCreateRequest;

class LopQuanLyController extends Controller
{
    //
    protected $lopQuanLyService;

    public function __construct(LopQuanLyService $lopQuanLyService)
    {
        $this->lopQuanLyService = $lopQuanLyService;
    }

    public function create()
    {
        return view('admin.lopquanly.add', [
            'title' => 'Thêm mới lớp quản lý'
        ]);
    }

    public function store(Request $request)
    {
        //xu ly them moi lop mon hoc
        //dd($request->input());
        $result = $this->lopQuanLyService->create($request);
        return redirect()->back();
    }
    public function index(Request $request)
    {
        $optionSearch = $request->query('optionSearch') ?? 'malop';
        $search = $request->query('search');
        $perPage = $request->query('perPage') ?? 10;

        return view('admin.lopquanly.list', [
            'title' => 'Danh sách lớp học',
            'lopquanlys' => $this->lopQuanLyService->getAll($search, $optionSearch, $perPage),
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function delete(Request $request)
    {
        //xử lý xóa
        $result = $this->lopQuanLyService->delete($request);
        $message = '';
        if ($result) {
            $message = 'Xóa bản ghi thành công!';
            // session()->flash('success', $message);
            toastr()->success($message, 'Thông báo');
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
        $result = $this->lopQuanLyService->deletemany($request);
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
    public function show(LopQuanLy $lop)
    {
        return view('admin.lopquanly.edit', [
            'title' => "Sửa lớp quản lý",
            'lop' => $lop
        ]);
    }

    public function edit(Request $request, LopQuanLy $lop)
    {
        $result = $this->lopQuanLyService->edit($request, $lop);
        if ($result) {
            return redirect()->route('admin.lopquanly.list');
        }
        return redirect()->back();
    }
}
