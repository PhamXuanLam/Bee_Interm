<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\SendLinkResetPassword;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function Symfony\Component\String\u;

class AuthController extends Controller
{
    public function show()
    {
        return view("user.auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function forgotPassword()
    {
        return view('user.auth.forgot-password');
    }

    public function mailForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(64);
            dispatch(new SendLinkResetPassword($user, $token));
            $user->remember_token = $token;
            $user->token_expires_at = now()->addHours(3);
            $user->save();
            return redirect()->route('forgot-password')->with('success', "Đã gửi thành công vui lòng kiểm tra mail");
        }

        return redirect()->route('forgot-password')->with('success', 'Thành công');
    }

    public function resetPassword(string $token)
    {
        return view('user.auth.reset-password', ['token' => $token]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::query()->select(['*'])->where('remember_token', $request->token)->first();
        if (!$user)
            return redirect()->route('login')->with('error', 'Đổi mật khẩu thất bại');

        if (now() < $user->token_expires_at) {
            $user->password = bcrypt($request->password);
            $user->save();
            Auth::login($user, true);
            return redirect('/');
        } else {
            return redirect()->route('login')->with('error', 'Hết thời gian đổi mật khẩu');
        }
    }
}
