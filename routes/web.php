<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Products;
use App\Http\Livewire\Pos;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/blank', function () {
    return view('livewire.blank');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('categories', Categories::class)->name('categories');
Route::get('products', Products::class)->name('products');
Route::get('coins', Coins::class)->name('coins');
Route::get('pos', Pos::class)->name('pos');