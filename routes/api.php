<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\FrontendController;


//
// =========== All Admin Dashboard Route Starts Form Here ============
//

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAuthenticated', function(){
        return response()->json(["message"=>"You are in", "status" => 200]);
    });

    // Category
     Route::post('store-category', [CategoryController::class, 'store']);
     Route::get('view-category', [CategoryController::class, 'index']);
     Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
     Route::post('update-category/{id}', [CategoryController::class, 'update']);
     Route::post('delete-category/{id}', [CategoryController::class, 'delete']);

     Route::get('all-category', [CategoryController::class, 'allcategory']);

    // Orders
    Route::get('admin/orders', [OrderController::class, 'index']);

    // Products
    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('view-product', [ProductController::class, 'index']);
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::post('update-product/{id}', [ProductController::class, 'update']);

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


//
// =========== All Admin Dashboard Route Ends Form Here ============
//



//
// =========== All Frontend Route Starts Form Here ============
//

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('getCategory', [FrontendController::class, 'category']);
Route::get('fetchproducts/{slug}', [FrontendController::class, 'product']);
Route::get('viewproductdetail/{category_slug}/{product_slug}', [FrontendController::class, 'viewproduct']);

Route::post('add-to-cart', [CartController::class, 'addtocart']);
Route::get('cart', [CartController::class, 'viewcart']);
Route::post('cart-updatequantity/{cart_id}/{scope}', [CartController::class, 'updatequantity']);
Route::post('delete-cartitem/{cart_id}', [CartController::class, 'deleteCartitem']);

Route::post('validate-order', [CheckoutController::class, 'validateOrder']);
Route::post('place-order', [CheckoutController::class, 'placeorder']);

//
// =========== All Frontend Route Ends Form Here ============
//















