<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function create()
    {
        return Inertia::render('Auth/Login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Login successful'
                ]);
            }

            return redirect()->route('products.index');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
