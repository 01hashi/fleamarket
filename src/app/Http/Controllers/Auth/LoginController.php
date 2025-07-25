<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            //認証成功
            return redirect()->route('dashboard');
        } else {
            //認証失敗
            return back()->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ]);

        }


    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

}
