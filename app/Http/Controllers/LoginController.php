<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only('email', 'password'), ['status' => 1]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'These credentials do not match our records.']);
        }

        if ($user->status == 0) {
            return back()->withErrors(['email' => 'Your account is deactivated. Please contact the administrator.']);
        }
        
        if (auth()->attempt($request->only('email', 'password'))) {
            // This is where we need to handle the redirect based on role
            if (auth()->user()->role === 'user') {
                return redirect('/products-list')->with('success', 'Welcome back!');
            }
            return redirect()->route('products.index')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['password' => 'Invalid password.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully');
    }
}