<?php

use App\Http\Controllers\MenusController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('menus', [MenusController::class, 'index'])->name('menus');
Route::post('save_menus', [MenusController::class, 'save_menus'])->name('save_menus');
Route::get('get_menus', [MenusController::class, 'get_menus'])->name('get_menus');
Route::get('get_menus_name', [MenusController::class, 'get_menus_name'])->name('get_menus_name');
Route::post('save_submenus', [MenusController::class, 'save_submenus'])->name('save_submenus');
Route::get('get_submenus', [MenusController::class, 'get_submenus'])->name('get_submenus');
