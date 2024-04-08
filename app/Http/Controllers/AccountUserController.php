<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountUserController extends Controller
{
    public function dangKy(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        return view('users.dangky', compact('danhmucTruyen','theLoai'));
    }

    public function dangNhap(){
        $danhmucTruyen = Category::all();
        $theLoai = Genre::all();
        return view('users.dangnhap', compact('danhmucTruyen','theLoai'));
    }

    public function dangKyTaiKhoan(Request $request){
        $validator = Validator::make($request->all(),[
            'fullname'=>'required',
            'phone' => 'required',
            'email' => 'required|unique:accounts,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ],[
            'fullname.required'=> 'Cần nhập tên đăng ký!',
            'phone.required' => 'Cần nhập số điện thoại!',
            'email.required' => 'Cần nhập email đăng ký!',
            'email.unique' => 'Email đã bị trùng!',
            'password.required' => 'Cần nhập mật khẩu',
            'password_confirmation.same' => 'Mật khẩu nhập lại không đúng!',
            'password_confirmation.required' => 'Cần nhập lại mật khẩu!'
        ]);

        if ($validator->passes()) {
           $data = [
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)
           ];

           Account::create($data);
           return response()->json([
            'status' => true,
            'message' => 'Đăng ký tài khoản thành công!'
           ]);
        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()

            ]);
        }


    }

    public function dangXuat(){
        Session::forget('login_session');
        Session::forget('user_id');
        Session::forget('user_fullname');
        Session::forget('user_email');
        return redirect()->back()->with('success', 'Đăng xuất thành công!');
    }

    public function dangNhapTaiKhoan(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'Cần nhập email!',
            'password.required' => 'Cần nhập mật khẩu!'
        ]);

        if ($validator->passes()) {
            $dataInput = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $account = Account::where('email', $dataInput['email'])->first();
            if ($account && Hash::check($dataInput['password'], $account->password)) {
                $request->session()->put('login_session', true);
                $request->session()->put('user_id', $account->id);
                $request->session()->put('user_fullname', $account->fullname);
                $request->session()->put('user_email', $account->email);

                return response()->json([
                    'status'=>true,
                    'code' => 200,
                    'message'=>'Đăng nhập thành công!'
                ]);
            }else{
                return response()->json([
                    'status'=>true,
                    'code' => 400,
                    'message'=>'Sai password!'
                ]);
            }
        }
        else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

}
