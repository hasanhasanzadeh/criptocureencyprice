<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function index(): View|Factory|Application
    {
        $cryptocurrencies = Cryptocurrency::orderBy('price', 'desc')->take(10)->get();
        return view('welcome', compact('cryptocurrencies'));
    }
}
