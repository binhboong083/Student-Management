<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;
//
use Illuminate\Support\Facades\Session;
// \session_start();
class LoginController extends Controller
{
    //
    public function index()
    {
        return view('admin.users.login', ['title' => 'Đăng nhập']);
    }
    public function login(Request $request)
    {
        //dd($request->input());
        $this->validate(
            $request,
            [
                'email' => 'required|email:filter',
                'password' => 'required',
            ]
        );
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])) {
            // session()->flash('success', 'Đăng nhập thành công!');
            Toastr::success('Đăng nhập thành công!', 'Thông báo', ['timeOut' => 2000]);
            return redirect()->route('admin');
        }
        // session()->flash('warning', 'Sai tên đăng nhập hoặc mật khẩu!');
        toastr()->error('Sai tên đăng nhập hoặc mật khẩu!', 'Thông báo');

        return redirect()->back();
    }
}
