<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'index'])->name('dashboard');

Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('categories');
Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('add.categories');
Route::post('/admin/categories/edit', [CategoriesController::class, 'update'])->name('edit.categories');
Route::get('/admin/categories/{id}', [CategoriesController::class, 'destroy'])->name('delete.categories');

Route::get('/admin/products', [ProductController::class, 'index'])->name('products');
Route::post('/admin/products', [ProductController::class, 'store'])->name('add.products');
Route::post('/admin/products/edit', [ProductController::class, 'update'])->name('edit.products');
Route::get('/admin/products/{code}', [ProductController::class, 'destroy'])->name('delete.products');

Route::get('/admin/addstock', [ProductController::class, 'addstock'])->name('addstock');
Route::get('/admin/addstock/fill/{code}', [ProductController::class, 'fill'])->name('autofill');
Route::post('/admin/addstock/add', [ProductController::class, 'add'])->name('add.action');
