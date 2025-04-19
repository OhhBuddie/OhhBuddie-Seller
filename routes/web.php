<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Sellers\SellerController;
use App\Http\Controllers\Sellers\ContactController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;



Route::get('/colors', [HomeController::class, 'showColors']);
Route::get('/get-sizes/{categoryId}', [HomeController::class, 'getSizes']);

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/', [HomeController::class, 'landingpage']);


Route::get('/product', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/listing', [App\Http\Controllers\ProductController::class,'listing1']);
// Route::get('/listing1', [App\Http\Controllers\ProductController::class,'listing1']);
Route::get('/product-listing', [App\Http\Controllers\ProductController::class,'form']);
Route::get('/get-subcategories/{id}', [ProductController::class, 'getSubcategories']);
Route::get('/get-sub-subcategories/{id}', [ProductController::class, 'getSubSubcategories']);


Route::controller(App\Http\Controllers\UserController::class)->group(function(){

    Route::get('profileedit/{id}', 'edit')->name('user.edit');
    Route::post('name/update', 'nameupdate')->name('name.update');
    Route::post('profileupdate/{id}', 'update')->name('user.update');

});

Auth::routes();

Route::controller(LoginController::class)->group(function () {
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/accounts', [HomeController::class, 'account']);

Route::get('/account', [HomeController::class, 'account'])->middleware('auth');

Auth::routes();

// Route::get('/seller', [App\Http\Controllers\SellerController::class, 'index']);

Route::get('/seller', [SellerController::class, 'index']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [SellerController::class, 'dashboard'])->name('seller.dashboard');


Route::get('2fa', [App\Http\Controllers\TwoFAController::class, 'index'])->name('2fa.index');

Route::post('2fa', [App\Http\Controllers\TwoFAController::class, 'store'])->name('2fa.post');

Route::get('2fa/reset', [App\Http\Controllers\TwoFAController::class, 'resend'])->name('2fa.resend');

// Seller Portal

Route::get('/seller/login', [SellerController::class, 'login'])->name('seller.login');
Route::post('/seller/submit-phone', [SellerController::class, 'submitPhone'])->name('seller.submit.phone');

Route::get('/seller/enter-otp', [SellerController::class, 'enterOtp'])->name('seller.enter-otp');
Route::post('/seller/submit-otp', [SellerController::class, 'submitOtp'])->name('seller.submit.otp');

Route::get('/seller/enter-email', [SellerController::class, 'enterEmail'])->name('seller.enter-email');
Route::post('/seller/submit-email', [SellerController::class, 'submitEmail'])->name('seller.submit.email');

Route::get('/seller/enter-email-otp', [SellerController::class, 'enterEmailOtp'])->name('seller.enter-email-otp');
Route::post('/seller/submit-email-otp', [SellerController::class, 'submitEmailOtp'])->name('seller.submit.email.otp');

Route::get('/seller/registration', [SellerController::class, 'registration'])->name('seller.registration');

Route::post('/submitform/{id}', [SellerController::class, 'submitform'])->name('seller.submitform');

Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

Route::get('/seller/profileedit', [SellerController::class, 'profileedit'])->name('seller.profileedit');

Route::post('/editform/{id}', [SellerController::class, 'editform'])->name('seller.submitform');

Route::get('/profile', [SellerController::class, 'profile']);

Route::get('/payments', [SellerController::class, 'loading']);

Route::get('/reports', [SellerController::class, 'loading']);


Route::controller(App\Http\Controllers\Sellers\AuthOtpController::class)->group(function(){

    Route::get('sellerotp/login', 'login')->name('sellerotp.login');

    Route::post('sellerotp/generate', 'generate')->name('sellerotp.generate');

    Route::get('sellerotp/verification/{user_id}', 'verification')->name('sellerotp.verification');

    Route::post('sellerotp/login', 'loginWithOtp')->name('sellerotp.getlogin');
    
});

Route::resource('products', ProductController::class);

Route::resource('contacts', ContactController::class);

Route::resource('warehouses', WarehouseController::class);

Route::resource('brands', BrandController::class);


Route::controller(App\Http\Controllers\ProductController::class)->group(function(){

    Route::get('product/sellerproduct', 'sellerproduct')->name('product.sellerproduct');

});

Route::post('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');


// Route::post('/save-images', [ProductController::class, 'saveImages'])->name('saveImages');
Route::post('/save-product-data', [App\Http\Controllers\ProductController::class, 'saveProductData'])->name('save.product.data');
Route::get('/get-product-images', [ProductController::class, 'getProductImages']);



Route::get('/allorders', [OrderController::class, 'allorders']);
Route::get('/allorderdetails/{id}', [OrderController::class, 'allorderdetails']);