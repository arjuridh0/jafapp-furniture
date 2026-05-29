<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->active()
            ->latest()
            ->take(6)
            ->get();
            
        return view('public.home', compact('featuredProducts'));
    }
}
