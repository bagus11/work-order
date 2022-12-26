<?php

use App\Http\Controllers\MenusController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserAccessController;
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

Route::group(['middleware' => ['permission:view-dashboard']], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});
Route::group(['middleware' => ['permission:view-menus']], function () {
    Route::get('menus', [MenusController::class, 'index'])->name('menus');
});
Route::post('save_menus', [MenusController::class, 'save_menus'])->name('save_menus');
Route::get('get_menus', [MenusController::class, 'get_menus'])->name('get_menus');
Route::get('get_menus_name', [MenusController::class, 'get_menus_name'])->name('get_menus_name');
Route::post('save_submenus', [MenusController::class, 'save_submenus'])->name('save_submenus');
Route::get('get_submenus', [MenusController::class, 'get_submenus'])->name('get_submenus');
Route::get('getDetailMenus', [MenusController::class, 'getDetailMenus'])->name('getDetailMenus');
Route::post('update_menus', [MenusController::class, 'update_menus'])->name('update_menus');
Route::get('deleteMenus', [MenusController::class, 'deleteMenus'])->name('deleteMenus');
Route::get('deleteSubmenus', [MenusController::class, 'deleteSubmenus'])->name('deleteSubmenus');
Route::get('getDetailSubmenus', [MenusController::class, 'getDetailSubmenus'])->name('getDetailSubmenus');
Route::post('update_submenus', [MenusController::class, 'update_submenus'])->name('update_submenus');

Route::group(['middleware' => ['permission:view-role_permission']], function () {
    Route::get('role_permission', [RolePermissionController::class, 'index'])->name('role_permission');
});

Route::get('get_role', [RolePermissionController::class, 'get_role'])->name('get_role');
Route::get('get_permission', [RolePermissionController::class, 'get_permission'])->name('get_permission');
Route::post('save_role', [RolePermissionController::class, 'save_role'])->name('save_role');
Route::get('getDetailRoles', [RolePermissionController::class, 'getDetailRoles'])->name('getDetailRoles');
Route::post('update_role', [RolePermissionController::class, 'update_role'])->name('update_role');
Route::get('delete_role', [RolePermissionController::class, 'delete_role'])->name('delete_role');
Route::get('permission_menus_name', [RolePermissionController::class, 'permission_menus_name'])->name('permission_menus_name');
Route::post('save_permission', [RolePermissionController::class, 'save_permission'])->name('save_permission');
Route::get('delete_permission', [RolePermissionController::class, 'delete_permission'])->name('delete_permission');
Route::get('user_access', [UserAccessController::class, 'index'])->name('user_access');
Route::get('get_role_user', [UserAccessController::class, 'get_role_user'])->name('get_role_user');
Route::get('get_username', [UserAccessController::class, 'get_username'])->name('get_username');
Route::post('save_role_user', [UserAccessController::class, 'save_role_user'])->name('save_role_user');
Route::get('detail_role_user', [UserAccessController::class, 'detail_role_user'])->name('detail_role_user');
Route::post('update_roles_user', [UserAccessController::class, 'update_roles_user'])->name('update_roles_user');
Route::get('get_permisssion', [UserAccessController::class, 'get_permisssion'])->name('get_permisssion');
Route::post('add_role_permission', [UserAccessController::class, 'add_role_permission'])->name('add_role_permission');
Route::get('delete_role_permission', [UserAccessController::class, 'delete_role_permission'])->name('delete_role_permission');

Route::get('setting', [SettingController::class, 'index'])->name('setting');
Route::post('update_user', [SettingController::class, 'update_user'])->name('update_user');
Route::post('change_password', [SettingController::class, 'change_password'])->name('change_password');