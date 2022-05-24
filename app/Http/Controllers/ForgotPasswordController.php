<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('authentication.forgot-password');
    }

    public function submitForgotPassword(EmailRequest $request)
    {

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.password-reset-email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');

    }

    public function showResetPasswordForm($token)
    {
        return view('authentication.new-password-reset', ['token' => $token]);
    }

    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
        $updatePassword = DB::table('password_resets')->where(
            [
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->with('message', 'Invalid token!');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');

    }
}
