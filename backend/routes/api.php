<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->prefix('expense-categories')->group(function () {
    Route::get("/get", "ExpenseCategoryController@get");
    Route::get("/all", "ExpenseCategoryController@all");
    Route::post("/save", "ExpenseCategoryController@save");
    Route::delete("/delete", "ExpenseCategoryController@delete");

});
Route::middleware(['auth:api'])->prefix('expenses')->group(function () {
    Route::get("/get", "ExpenseController@get");
    Route::get("/all", "ExpenseController@all");
    Route::post("/save", "ExpenseController@save");
    Route::delete("/delete", "ExpenseController@delete");

});
Route::middleware(['auth:api'])->prefix('roles')->group(function () {
    Route::get("/get", "RoleController@get");
    Route::get("/all", "RoleController@all");
    Route::post("/save", "RoleController@save");
    Route::delete("/delete", "RoleController@delete");
});
Route::middleware(['auth:api'])->prefix('users')->group(function () {
    Route::get("/get", "UserController@get");
    Route::get("/all", "UserController@all");
    Route::post("/save", "UserController@save");
    Route::delete("/delete", "UserController@delete");


    Route::post("/change-password", "UserController@changePassword");

});
Route::middleware(['auth:api'])->prefix('permissions')->group(function () {
    Route::get("/all", "PermissionController@all");

});
Route::post('oauth/token', 'AuthController@auth');