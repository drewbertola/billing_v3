<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Mauricius\LaravelHtmx\Http\HtmxRequest;

class AuthController extends Controller
{
    public function login(HtmxRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($email) || empty($password)) {
            return response('Please enter both email and password.', 200);
        }

        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            return response('Invalid credentials.', 200);
        }

        return response(
            view('components.loginResult', [
                'loginMessage' => 'Success.'
            ]), 200, ['HX-Redirect' => $request->input('referrer')]
        );
    }

    public function logout(HtmxRequest $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response(
            view('components.loginResult', [
                'loginMessage' => 'Success.'
            ]), 200, ['HX-Redirect' => '/']
        );
    }
}
