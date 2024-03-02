<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::post('/register', [AuthController::class, 'register']);
//Route::post('/login', [AuthController::class, 'login']);
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    echo '<pre>'.print_r($request,1);die();
//    return $request->user();
//});
//
//Route::group(['middleware' => ['auth:sanctum']], function () {
//    Route::get('/products', [ProductController::class, 'index']);
//    Route::post('/products', [ProductController::class, 'store']);
//
//});

Route::get('/roles', function () {
    return \App\Models\Role::all();
});

Route::get('/all_users', function () {
    return \App\Models\User::all();
});

Route::get('/trashed', function () {
    return \App\Models\User::withTrashed()->find(4);
});



Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);
//    Route::post('register', [AuthController::class, 'register']);


    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('logout', [AuthController::class, 'logout']);

        Route::post('register', [UserController::class, 'register']); //admin can register(create) user
        Route::get('users', [UserController::class, 'index']); //admin can get all(read) users
        Route::get('user/{id}', [UserController::class, 'get_user']); //admin can get specific user
        Route::put('user/{id}', [UserController::class, 'update']); //admin can update user
        Route::delete('user-soft-delete/{id}', [UserController::class, 'soft_delete']); //admin can soft delete user
        Route::delete('user-delete/{id}', [UserController::class, 'delete']); //admin can delete user
        Route::get('is-user/{id}', [UserController::class, 'check_user']); //admin check user is available


        Route::get('/products', [ProductController::class, 'index']); //get all products
        Route::post('/product', [ProductController::class, 'store']); //create a new product
        Route::get('/product/{id}', [ProductController::class, 'get_product']); //get a specific product
        Route::put('/product/{id}', [ProductController::class, 'update']); //update a product
        Route::delete('product-soft-delete/{id}', [ProductController::class, 'soft_delete']); //soft delete product
        Route::delete('product-delete/{id}', [ProductController::class, 'delete']); //delete product
        Route::get('is-product/{id}', [ProductController::class, 'check_product']); //check product is available


        Route::get('/customers', [CustomerController::class, 'index']); //get all customers
        Route::post('/customer', [CustomerController::class, 'store']); //create a new customer
        Route::get('/customer/{id}', [CustomerController::class, 'get_customer']); //get a specific customer
        Route::put('/customer/{id}', [CustomerController::class, 'update']); //update a customer
        Route::delete('customer-soft-delete/{id}', [CustomerController::class, 'soft_delete']); //soft delete customer
        Route::delete('customer-delete/{id}', [CustomerController::class, 'delete']); //delete customer
        Route::get('is-customer/{id}', [CustomerController::class, 'check_customer']); //check customer is available
    });
});
