<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nickname' => ['required', 'string', 'max:255', 'unique:user,nickname'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'nickname' => $validated['nickname'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
