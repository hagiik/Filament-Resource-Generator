<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\ResourceGenerator;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/admin/resource-generator', ResourceGenerator::class);