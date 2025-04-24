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
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $User = User::where('email', $credentials['email'])->first();
        if ($User && Hash::check($credentials['password'], $User->password)) {
            Auth::login($User);
            $request->session()->regenerate();
            return redirect()->route('products.index');
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 422);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
