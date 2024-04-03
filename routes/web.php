<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConverterController;


Route::get('/', function () {
    return view('converter');
});

Route::post('/convert', [ConverterController::class, 'convert']);
