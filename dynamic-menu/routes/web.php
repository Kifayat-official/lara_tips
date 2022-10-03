<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Heirarchy;

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

Route::get('/mega-menu', function () {
    return view('mega-menu', [
        'categories' => Category::tree()
    ]);
})->name('mega-menu');

Route::get('/heirarchy', function () {
    return view('heirarchy', [
        'categories' => Heirarchy::tree()
    ]);
})->name('heirarchy');

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
