<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProducts(){
        $products = Product::all(); // Traemos a todos los productos
        return view('products', compact('products')); 
    }
}
