<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/addCategory', CategoryController::class);
Route::put('/updateCategory/{category}', [CategoryController::class, 'update']);
Route::delete('/deleteCategory/{category}', [CategoryController::class, 'destroy']);
Route::Get('/category/{category}', [CategoryController::class, 'show']);
Route::Get('/category', [CategoryController::class, 'index']);

Route::post('/updateProduct/{product}', [ProductController::class, 'update']);
Route::delete('/deleteProduct/{product}', [ProductController::class, 'destroy']);
Route::Get('/product/{product}', [ProductController::class, 'show']);
Route::Get('/product', [ProductController::class, 'index']);
Route::Get('/product/category/{id}', [ProductController::class, 'getByCategoryId']);
Route::Post('/addProduct', [ProductController::class, 'store']);


Route::put('/updateSubCategory/{subCategory}', [SubCategoryController::class, 'update']);
Route::delete('/deleteSubCategory/{subCategory}', [SubCategoryController::class, 'destroy']);
Route::Get('/subCategory/{subCategory}', [SubCategoryController::class, 'show']);
Route::Get('/subCategory', [SubCategoryController::class, 'index']);
Route::resource('/addsubCategory', SubCategoryController::class);

Route::put('/updateFacture/{facture}', [FactureController::class, 'update']);
Route::delete('/deleteFacture/{facture}', [FactureController::class, 'destroy']);
Route::Get('/facture/{facture}', [FactureController::class, 'show']);
Route::Get('/facture', [FactureController::class, 'index']);
Route::resource('/addFacture', FactureController::class);

Route::put('/updateCommande/{commande}', [CommandeController::class, 'update']);
Route::delete('/deleteCommande/{commande}', [CommandeController::class, 'destroy']);
Route::Get('/commande/{commande}', [CommandeController::class, 'show']);
Route::Get('/commande', [CommandeController::class, 'index']);
Route::resource('/addCommande', CommandeController::class);
Route::Get('/commande/customer/{id}', [CommandeController::class, 'getCommandeByIdCustomer']);

Route::put('/updateOrder/{order}', [OrderController::class, 'update']);
Route::delete('/deleteOrder/{order}', [OrderController::class, 'destroy']);
Route::Get('/order/{order}', [OrderController::class, 'show']);
Route::Get('/order', [OrderController::class, 'index']);
Route::resource('/addOrder', OrderController::class);



Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/registerCustomer', [AuthController::class, 'registerCustomer']);
    Route::post('/registerAdmin', [AuthController::class, 'registerAdmin']);
    Route::post('/registerProvider', [AuthController::class, 'registerProvider']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);
    Route::post('/forgetPasswordCode', [AuthController::class, 'forgetPasswordCode']);
    Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
    Route::post('/verifyEmailCode', [AuthController::class, 'verifyEmailCode']);
});

Route::get('/user-profile', [AuthController::class, 'userProfile']);
Route::post('/updateUser', [UserController::class, 'updateUser']);
Route::delete('/deleteUser/{user}', [UserController::class, 'deleteUser']);
Route::get('/getAllUserByRole', [UserController::class, 'getAllUserByRole']);
Route::post('/changePassword', [UserController::class, 'changePassword']);

Route::post('/status/{user}', [UserController::class, 'status']);
