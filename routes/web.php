<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

Route::get('/', [CrudController::class, 'index']);
Route::get('crud', [CrudController::class, 'index']);
Route::get('list', [CrudController::class, 'list']);
Route::post('store-company', [CrudController::class, 'store']);
Route::post('edit-company', [CrudController::class, 'edit']);
Route::post('delete-company', [CrudController::class, 'destroy']);
Route::get('companies/export/', [CrudController::class, 'export']);

Route::post('dropzone/upload', [CrudController::class, 'import'])->name('dropzone.upload');
Route::get('dropzone/fetch', [CrudController::class, 'fetch'])->name('dropzone.fetch');
Route::get('dropzone/delete', [CrudController::class, 'delete'])->name('dropzone.delete');
