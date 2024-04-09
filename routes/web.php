<?php

use App\Http\Controllers\CrudController;
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
    return view('crud');
});
Route::get('/',[CrudController::class,'showUsers'])->name('show');
Route::get('/add',[CrudController::class,'add'])->name('add');
Route::post('/add',[CrudController::class,'postAdd'])->name('post-add');
Route::get('/edit/{id}',[CrudController::class,'edit'])->name('edit');
Route::post('/edit',[CrudController::class,'postEdit'])->name('post-edit');
Route::get('/delete/{id}',[CrudController::class,'deleteUser'])->name('delete');