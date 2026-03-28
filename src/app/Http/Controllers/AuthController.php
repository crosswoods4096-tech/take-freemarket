<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 会員登録処理
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // 認証を試みる
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // セッション固定攻撃対策
            return redirect()->route('products.index'); // ログイン後の遷移先（例）
        }

        // 認証失敗時
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ])->onlyInput('email');
    }

    public function logout(LoginRequest $request)
    {
        Auth::logout(); // ログアウト

        // セッション無効化
        $request->session()->invalidate();

        // セッションID再生成（セキュリティ対策）
        $request->session()->regenerateToken();

        // ログイン画面へリダイレクト
        return redirect()->route('login');
    }
}
