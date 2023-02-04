<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Categories::all();
        $empty = Product::where('stock', 0)->get();
        return view('admin.dashboard', ['active' => 'dashboard', 'title' => 'Dashboard', 'products' => $products, 'categories' => $categories, 'empty' => $empty]);
    }
}
