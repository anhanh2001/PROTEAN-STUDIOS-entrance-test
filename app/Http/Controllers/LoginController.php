<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('login_token')->plainTextToken;
            return response()->json(["success"=>"Đăng nhập thành công","token"=>$token]);
        }
        return response()->json(['error'=>"Email hoặc mật khẩu không chính xác !"]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(["success"=>"Đã đăng xuất"]);
    }
}
