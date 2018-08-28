<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    function index( Product $product ) {
        
        return view('product')->with( 'product', $product );
    }
}

