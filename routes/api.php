<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Models\Company;
// use DataTables;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [CrudController::class, 'index']);
Route::get('crud', [CrudController::class, 'index']);
Route::post('store-company', [CrudController::class, 'store']);
Route::post('edit-company', [CrudController::class, 'edit']);
Route::post('delete-company', [CrudController::class, 'destroy']);
Route::get('all-company', [CrudController::class, 'all']);
Route::post('import-companies', [CrudController::class, 'import']);
