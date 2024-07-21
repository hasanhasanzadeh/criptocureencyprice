<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crypto\CryptoController;


Route::get('/', [CryptoController::class, 'index']);
