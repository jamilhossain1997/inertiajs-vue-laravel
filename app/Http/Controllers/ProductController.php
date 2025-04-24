<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::all()
        ]);
    }


    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
      $_product=  $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($_product);

        return redirect()->route('products.index')->with('message', 'Product created');
    }
}
