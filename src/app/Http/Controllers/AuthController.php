<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\AttendanceController;


class AuthController extends Controller
{
    // ログインフォームの表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        // バリデーション済みのデータを取得
        $credentials = $request->validated();

        // 認証を試行
        if (Auth::attempt($credentials)) {
            // 認証に成功した場合、ユーザーをダッシュボードなどにリダイレクト
            return redirect()->action([AttendanceController::class, 'index']);
        }
        else {
            back()->withInput();
        }

        // 認証に失敗した場合、エラーメッセージを表示
        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ])->withInput();
    }

    // ユーザー登録フォームの表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ユーザー登録処理
    public function register(RegisterRequest $request)
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();

        // 新しいユーザーを作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ユーザーをログインさせる
        Auth::login($user);

        // ダッシュボードにリダイレクト
        return redirect()->action([AttendanceController::class, 'index']);
    }

}
