<?php

use App\Http\Controllers\DepartmentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
// use App\Actions\Fortify\PasswordController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PhotosController;

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


// Route::resource('/users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);

// Route::resource('/password', PasswordController::class,['only' => ['show', 'edit', 'update']]);

// 部署関係のページ 従業員関係のページなど、ログインしていないと、いけない
Route::group(['middleware' => 'auth'], function() {

    Route::resource('/users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);

    Route::resource('/password', PasswordController::class,['only' => ['show', 'edit', 'update']]);

    Route::get('/departments',  [ DepartmentsController::class, 'index'] )->name('departments.index');

    Route::get('/departments/dep_get',  [ DepartmentsController::class, 'depGet'] )->name('departments.dep_get');
    Route::post('/departments/dep_get',  [ DepartmentsController::class, 'depPost'] )->name('departments.dep_post');

    Route::get('/photos/show', [ PhotosController::class, 'show'])->name('photos.show');


    Route::get('/employees', [ EmployeesController::class, 'index' ] )->name('employees.index');

    Route::get('/employees/emp_get',  [ EmployeesController::class, 'empGet'] )->name('employees.emp_get');
    Route::post('/employees/emp_get',  [ EmployeesController::class, 'empPost'] )->name('employees.emp_post');

});