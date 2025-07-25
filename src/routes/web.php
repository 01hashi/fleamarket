<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ShopOwnerController;
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

// 認証が必要なルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    // マイページ関連
    Route::prefix('mypage')->group(function () {
        Route::get('/', [MypageController::class, 'index']);
        Route::get('/profile', [MypageController::class, 'profile']);
        Route::post('/profile/update', [MypageController::class, 'update']);
    });

    // 購入関連
    Route::prefix('purchase')->group(function () {
        Route::get('/{item_id}', [PurchaseController::class, 'index']);
        Route::get('/address/{item_id}', [PurchaseController::class, 'address']);
        Route::post('/address/update/{item_id}', [PurchaseController::class, 'updateAddress']);
        Route::get('/payment/{item_id}', [PurchaseController::class, 'payment']);
        Route::post('/payment/select/{item_id}', [PurchaseController::class, 'selectPayment']);
        Route::post('/decide/{item_id}', [PurchaseController::class, 'decidePurchase']);
    });

    // 商品関連
    Route::prefix('item')->group(function () {
        Route::get('/comment/{item_id}', [ItemController::class, 'comment']);
        Route::post('/comment/store/{item_id}', [ItemController::class, 'store']);
        Route::post('/like/{item_id}', [ItemController::class, 'like']);
        Route::delete('/unlike/{item_id}', [ItemController::class, 'unlike']);
    });

    // 出品関連
    Route::get('/sell', [SellController::class, 'index']);
    Route::get('/sell/{item_id}', [SellController::class, 'index']);
    Route::post('/sell', [SellController::class, 'create']);
    Route::post('/sell/{item_id}', [SellController::class, 'edit']);

    // role:Admin
    Route::middleware(['role:Admin'])->prefix('admin')->group(function () {
        Route::get('/show-users', [AdminController::class, 'showUsers']);
        Route::get('/show-shops', [AdminController::class, 'showShops']);
        Route::delete('/delete-user', [AdminController::class, 'deleteUser']);
        Route::get('/interactions/{shop_id}', [AdminController::class, 'interactions']);
        Route::view('/notification', 'notification');
        Route::post('/send-notification', [AdminController::class, 'sendNotification']);
    });

    Route::middleware(['role:ShopOwner'])->prefix('shop-owner')->group(function () {
        Route::get('/manage-shop-staff/{shop_id}', [ShopOwnerController::class, 'showStaff']);
        Route::delete('/delete-shop-staff', [ShopOwnerController::class, 'deleteStaff']);
        Route::post('/invite-shop-staff', [ShopOwnerController::class, 'inviteStaff']);
    });
});

// 認証が不要なルート

Route::get('/search', [IndexController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'index']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
// 会員登録ページの表示
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// 登録処理
Route::post('/register', [RegisterController::class, 'register']);