<?php

use App\Http\Controllers\Admin\Users\HomeController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\DangKyHocPhanController;
use App\Http\Controllers\LopMonHocController;
use App\Http\Controllers\LopQuanLyController;
use App\Http\Controllers\SinhVienController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', [UserController::class, 'index']);
//Route::get('/user','App\Http\Controllers\UserController@index');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/admin/users/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('admin');
    Route::prefix('admin')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin');

        #Lớp quản lý
        Route::prefix('lopquanly')->group(function () {
            Route::prefix('add')->group(function () {
                Route::get('/', [LopQuanLyController::class, 'create']);
                Route::post('/store', [LopQuanLyController::class, 'store']);
            });
            Route::get('/', [LopQuanLyController::class, 'index']);
            Route::get('/list', [LopQuanLyController::class, 'index'])->name('admin.lopquanly.list');
            Route::get('/edit/{lop}', [LopQuanLyController::class, 'show']);
            Route::post('/edit/{lop}', [LopQuanLyController::class, 'edit']);
            Route::DELETE('/delete', [LopQuanLyController::class, 'delete']);
            Route::DELETE('/deletemany', [LopQuanLyController::class, 'deletemany'])->name('admin.lopquanly.deletemany');
        });
        #Lớp môn học
        Route::prefix('lopmonhoc')->group(function () {
            Route::prefix('add')->group(function () {
                Route::get('/', [LopMonHocController::class, 'create']);
                Route::post('/store', [LopMonHocController::class, 'store']);
            });
            Route::get('/', [LopMonHocController::class, 'index']);
            Route::get('/list', [LopMonHocController::class, 'index'])->name('admin.lopmonhoc.list');
            Route::get('/edit/{lop}', [LopMonHocController::class, 'show']);
            Route::post('/edit/{lop}', [LopMonHocController::class, 'edit']);
            Route::DELETE('/delete', [LopMonHocController::class, 'delete']);
            Route::DELETE('/deletemany', [LopMonHocController::class, 'deletemany'])->name('admin.lopmonhoc.deletemany');
        });
        #Sinh viên
        Route::prefix('sinhvien')->group(function () {
            Route::prefix('add')->group(function () {
                Route::get('/', [SinhVienController::class, 'create'])->name('admin.sinhvien.add');
                Route::post('/check', [SinhVienController::class, 'check']);
                Route::post('/store', [SinhVienController::class, 'store']);
            });
            Route::get('/', [SinhVienController::class, 'index']);
            Route::get('/list', [SinhVienController::class, 'index'])->name('admin.sinhvien.list');
            Route::get('/edit/{sinhvien}', [SinhVienController::class, 'show']);
            Route::post('/edit/{sinhvien}', [SinhVienController::class, 'edit']);
            Route::DELETE('/delete', [SinhVienController::class, 'delete']);
            Route::DELETE('/deletemany', [SinhVienController::class, 'deletemany'])->name('admin.sinhvien.deletemany');
        });

        #Đăng ký sinh viên vào lớp học phần (lớp môn học)
        Route::prefix('dkhocphan')->group(function () {
            Route::get('/list', [DangKyHocPhanController::class, 'index'])->name('admin.dkhocphan.list');
            Route::post('/store', [DangKyHocPhanController::class, 'store'])->name('admin.dkhocphan.store');
            Route::post('/storemany', [DangKyHocPhanController::class, 'storemany'])->name('admin.dkhocphan.storemany');
            Route::DELETE('/delete', [DangKyHocPhanController::class, 'delete'])->name('admin.dkhocphan.delete');
            Route::DELETE('/deletemany', [DangKyHocPhanController::class, 'deletemany'])->name('admin.dkhocphan.deletemany');
        });

        #Upload file
        Route::post('upload/services', [UploadController::class, 'store']);
        // Xóa file cũ đã upload khi bắt sự kiện onchange upload file mới
        Route::DELETE('/delete-file', function (Request $request) {
            $path = $request->input('path');
            $path = str_replace('storage', 'public', $path);

            if (Storage::exists($path)) {
                Storage::delete($path);
                return response()->json(['message' => 'Đã cập nhật file mới']);
            } else {
                return response()->json(['message' => 'Không tìm thấy file cũ']);
            }
        })->name('delete-file');
    });
});
