<?php

use App\Http\Controllers\DepartmentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
// use App\Actions\Fortify\PasswordController;
use App\Http\Controllers\PasswordController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('/users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);

Route::resource('/password', PasswordController::class,['only' => ['show', 'edit', 'update']]);

// 部署一覧ページなど、ログインしていないと、いけない
Route::group(['middleware' => 'auth'], function() {
    Route::get('/departments',  [ DepartmentsController::class, 'index'] )->name('departments.index');

    Route::get('/departments/dep_get',  [ DepartmentsController::class, 'dep_get'] )->name('departments.dep_get');
    Route::post('/departments/dep_get',  [ DepartmentsController::class, 'dep_post'] )->name('departments.dep_post');

    //   Route::resource('/departments', DepartmentsController::class, ['except' => ['show']]);

});