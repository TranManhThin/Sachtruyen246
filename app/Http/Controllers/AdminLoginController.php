<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function login(){
        if (Auth::check() && Auth::user()->id != null) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }
    public function authenticate(Request $request){

        $validate = Validator::make($request->all(),[
            'email' => 'required|Email',
            'password' => 'required'
        ],[
            'email.required' => 'Bạn phải nhập email',
            'email.Email' => 'Không đúng định dạng email',
            'password.required' => 'Bạn phải nhập mật khẩu'
        ]);

        if ($validate->passes()) {
            if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
                $admin = Auth::user();
                if ($admin->id == 1) {
                    return redirect()->route('admin.dashboard')->with('success','Đăng nhập thành công!');
                }
                else{
                    return redirect()->back()->with('error', 'You are not authorized');
                }
            }
            else{
                return redirect()->back()->with('error', 'Email or Password is incorrect!');
            }
        }else{
            return redirect()->back()->with('error', 'Bạn phải nhập thông tin');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
