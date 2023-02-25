<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
        return view('layouts.backend.partial.new_blank_page');
        return redirect()->route('admin.product.stock.index');
        return view('home');
    }
    public function test(Request $request)
    {
        return "yes";
    }
}
