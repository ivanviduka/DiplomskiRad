<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('authentication.login');
    }

    public function customLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect("/");
        }

        return redirect()->back()->withErrors(['invalid_data' => 'Email or password is invalid']);
    }

    public function registration()
    {
        return view('authentication.registration');
    }

    public function customRegistration(RegistrationRequest $request)
    {
         User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'is_admin' => 0,
        ]);

        return redirect("login");
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}