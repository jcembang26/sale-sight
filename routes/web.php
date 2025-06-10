<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome');  // or your main blade file where Vue is mounted
})->where('any', '.*');
