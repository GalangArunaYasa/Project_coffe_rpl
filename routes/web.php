<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home.index');
});

Route::get('/menu', function () {
    return view('menu.index');
});
Route::get('/payment', function () {
    return view('payment.index');
});
