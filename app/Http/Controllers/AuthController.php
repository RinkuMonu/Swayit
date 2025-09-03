<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dashboard()
{
    $self = Auth::user();

    if ($self->user_role === 'influencer' && $self->role_id == 3) {
        return redirect()->route('influencer.dashboard');
    } elseif ($self->user_role === 'business' && $self->role_id == 4) {
        return redirect()->route('business.dashboard');
    } elseif ($self->user_role === 'admin' && $self->role_id == 2) {
        return redirect()->route('admin.dashboard');
    } else {
        abort(403);
    }
}

 public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Login success
            return redirect()->intended('/dashboard'); // or route('dashboard')
        }

        // Login failed
        return redirect()->route('login')->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->except('password'));
    }
}
