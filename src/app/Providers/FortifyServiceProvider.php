<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit as RateLimit;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // ログイン画面の表示
        Fortify::loginView(function () {
            return view('auth.login'); // login.blade.php のパス
        });

        // 会員登録画面の表示
        Fortify::registerView(function () {
            return view('auth.register'); // register.blade.php のパス
        });

        // ログイン処理の定義
        Fortify::authenticateUsing(function ($request) {
            Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスの形式が正しくありません',
                'password.required' => 'パスワードを入力してください',
            ])->validate();

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            throw ValidationException::withMessages([
                'email' => ['ログイン情報が登録されていません'],
            ]);
        });

        RateLimiter::for('login', function (Request $request) {
            return RateLimit::perMinute(20)->by($request->ip());
        });
    }
}

