<?php

use App\Http\Controllers\products_controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('create');
});

// Route::get('/edit', [products_controller::class, 'edit'])->name('edit');

Route::post('/create/product', [products_controller::class, 'create_product'])->name('create_product');

Route::get('/show/products', [products_controller::class, 'show'])->name('show_products');
Route::get('/delete/product/{id}', [products_controller::class, 'delete'])->name('delete_product');

Route::get('/edit/product/{id}', [products_controller::class, 'edit_product'])->name('edit_product');
Route::post('/update/product/{id}', [products_controller::class, 'update_product'])->name('update_product');
