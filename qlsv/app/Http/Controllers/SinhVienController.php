<?php

namespace App\Http\Controllers;

use App\Http\Services\SinhVienService;
use App\Http\Requests\SinhVienCreateRequest;
use App\Models\SinhVien;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class SinhVienController extends Controller
{
    protected $sinhvienService;

    public function __construct(SinhVienService $sinhvienService)
    {
        $this->sinhvienService = $sinhvienService;
    }


    public function create()
    {
        return view('admin.sinhvien.add', [
            'title' => 'Thêm mới sinh viên',
            'lops' => $this->sinhvienService->getClass()
        ]);
    }
    public function check(Request $request)
    {
        $message = "";
        $mssv = $request->input('mssv');
        $name = $request->input('name');
        $class_id = $request->input('class_id');
        $date = $request->input('date');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $file = $request->file('file');
        $check = true;
        while (true) {
            if (!empty($mssv)) {
                if (!preg_match("/^[0-9]+$/", $mssv)) {
                    $message = "MSSV phải là số";
                    $check = false;
                    break;
                }
            } else {
                $message = "MSSV không được để trống";
                $check = false;
                break;
            }
            if (!empty($name)) {
                if (strlen($name) > 24) {
                    $message = "Họ và tên không được quá 24 ký tự";
                    $check = false;
                    break;
                }
            } else {
                $message = "Họ và tên không được để trống";
                $check = false;
                break;
            }
            if (empty($class_id)) {
                $message = "Lớp môn học không được để trống";
                $check = false;
                break;
            }
            if (empty($date)) {
                $message = "Ngày sinh không được để trống";
                $check = false;
                break;
            }
            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $message = "Email sai định dạng";
                    $check = false;
                    break;
                }
            } else {
                $message = "Email không được để trống";
                $check = false;
                break;
            }
            if (!empty($phone)) {
                if (!preg_match("/^[0-9]{10}+$/", $phone)) {
                    $message = "Số điện thoại sai định dạng";
                    $check = false;
                    break;
                }
            } else {
                $message = "Phone không được để trống";
                $check = false;
                break;
            }
            // File
            if (!$file) {
                $message = "Vui lòng chọn file ảnh";
                $check = false;
            }

            // Kiểm tra định dạng file
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $allowedExtensions)) {
                $message = "Định dạng file không hợp lệ";
                $check = false;
            }

            // Kiểm tra dung lượng file
            $maxSize = 5 * 1024 * 1024; // Giới hạn dung lượng là 5MB
            if ($file->getSize() > $maxSize) {
                $message = "Dung lượng file vượt quá 5MB";
                $check = false;
            }
            break;
        }
        if ($check) {
            self::store($request);
            return redirect()->back();
        } else {
            $check = true;
            return redirect()->back()->withErrors(['error' => $message]);
        }
    }
    public function store(Request $request)
    {
        // Xử lý thêm mới sinh viên
        $result = $this->sinhvienService->create($request);
        $message = '';
        if ($result) {
            $message = 'Thêm mới sinh viên thành công!';
            // \session()->flash('success', $message');
            \toastr()->success($message, 'Thông báo');
        } else {
            $message = 'Thêm mới sinh viên thất bại!';
            // \session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
        }
        return redirect()->back();
    }
    // public function index()
    // {
    //     return view('admin.sinhvien.list', [
    //         'title' => 'Danh sách sinh viên',
    //         'svs' => $this->sinhvienService->getAll()
    //     ]);
    // }
    public function index(Request $request)
    {
        $sort = $request->query('sort') ?? 'id';
        $order = $request->query('order') ?? 'asc';
        $optionSearch = $request->query('optionSearch') ?? 'mssv';
        $search = $request->query('search');
        $perPage = $request->query('perPage') ?? 10;

        return view('admin.sinhvien.list', [
            'title' => 'Danh sách sinh viên',
            'svs' => $this->sinhvienService->getAll($sort, $order, $search, $optionSearch, $perPage),
            'sort' => $sort,
            'order' => $order,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }
    public function delete(Request $request)
    {
        //xử lý xóa
        $result = $this->sinhvienService->delete($request);
        $message = '';
        if ($result) {
            $message = 'Xóa sinh viên thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' =>  $message
            ]);
        }
        $message = 'Xóa sinh viên thất bại!';
        // session()->flash('error', $message);
        \toastr()->error($message, 'Thông báo');
        return response()->json([
            'error' => true,
            'message' =>  $message
        ]);
    }
    // Hàm xóa hàng loạt
    public function deletemany(Request $request)
    {
        //xử lý xóa
        // dd($request->input('ids'));
        $result = $this->sinhvienService->deletemany($request);
        $message = '';
        if ($result) {
            $message = 'Xóa nhiều sinh viên thành công!';
            // session()->flash('success', $message);
            \toastr()->success($message, 'Thông báo');
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } else {
            $message = 'Xóa nhiều sinh viên thất bại!';
            // session()->flash('error', $message);
            \toastr()->error($message, 'Thông báo');
            return response()->json([
                'error' => true,
                'message' => $message
            ]);
        }
    }
    public function show(SinhVien $sinhvien)
    {
        return view('admin.sinhvien.edit', [
            'title' => "Sửa thông tin sinh vien",
            'sinhvien' => $sinhvien,
            'lops' => $this->sinhvienService->getClass()
        ]);
    }

    public function edit(Request $request, SinhVien $sinhvien)
    {
        $result = $this->sinhvienService->edit($request, $sinhvien);
        return redirect()->to('/admin/sinhvien/list');
    }
}
