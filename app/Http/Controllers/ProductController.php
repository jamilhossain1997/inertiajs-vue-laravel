<?php

namespace App\Http\Controllers;
use app\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(){
        $user = Auth::user();

        dd($user);
        if ($user) {
            return Inertia::render('Products/Index', [
                'products' => Product::all(),
                'user' => $user
            ]);
        } else {
            return redirect('/login')->with('error', 'login failed. Please try again.');
        }
    }

}
