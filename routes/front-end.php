<?php

use App\Http\Controllers\WebsiteControllers\PageController;
use App\Http\Controllers\WebsiteControllers\ProductController;
use App\Http\Controllers\WebsiteControllers\CartController;
use App\Http\Controllers\WebsiteControllers\WishlistController;
use App\Http\Controllers\WebsiteControllers\ReviewController;
use App\Http\Controllers\WebsiteControllers\ContactFormController;
use App\Http\Controllers\WebsiteControllers\BlogController;
use App\Http\Controllers\WebsiteControllers\TipsController;
use App\Http\Controllers\WebsiteControllers\ProfileController;
use App\Http\Controllers\WebsiteControllers\OrderController;
use App\Http\Controllers\WebsiteControllers\LogViewerController;
use App\Http\Controllers\Auth\ClientLoginController;
use App\Http\Controllers\Auth\ClientRegisterController;
use App\Http\Controllers\Auth\ClientPasswordResetController;
use Illuminate\Support\Facades\Route;


// Authentication Routes
Route::middleware('guest:client')->group(function () {
    Route::get('/client/login'                         , [ClientLoginController::class,               'showLoginForm'])->name('client.login');
    Route::post('/client/login'                        , [ClientLoginController::class,                       'login'])->name('client.login.post');
    Route::get('/client/register'                      , [ClientRegisterController::class,     'showRegistrationForm'])->name('client.register');
    Route::post('/client/register'                     , [ClientRegisterController::class,                 'register'])->name('client.register.post');
    Route::get('/client/forgot-password'               , [ClientPasswordResetController::class, 'showLinkRequestForm'])->name('client.password.request');
    Route::post('/client/forgot-password'              , [ClientPasswordResetController::class,  'sendResetLinkEmail'])->name('client.password.email');
});

Route::middleware(['auth:client'])->group(function ()     {
    Route::get('/client/dashboard'                     , [ProfileController::class,                       'dashboard'])->name('client.dashboard');
    Route::get('/client/orders'                        , [ProfileController::class,                          'orders'])->name('client.orders');
    Route::get('/client/addresses'                     , [ProfileController::class,                       'addresses'])->name('client.addresses');
    Route::get('/client/addresses/add'                 , [ProfileController::class,                      'addAddress'])->name('client.addresses.add');
    Route::post('/client/addresses'                    , [ProfileController::class,                     'storeAddress'])->name('client.addresses.store');
    Route::get('/client/addresses/edit'                , [ProfileController::class,                     'editAddress'])->name('client.addresses.edit');
    Route::delete('/client/addresses/delete'           , [ProfileController::class,                   'deleteAddress'])->name('client.addresses.delete');
    Route::get('/client/profile/edit'                  , [ProfileController::class,                            'edit'])->name('profile.edit');
    Route::patch('/client/profile/edit'                , [ProfileController::class,                          'update'])->name('client.profile.update');
    Route::delete('/client/profile/delete'             , [ProfileController::class,                         'destroy'])->name('client.profile.destroy');
});

Route::post('/client/logout'                                  , [ClientLoginController::class,                      'logout'])->name('client.logout')->middleware('auth:client');

// Public Location AJAX endpoints for cascade dropdowns
Route::get('/locations/zones/{cityId}'                 , [\App\Http\Controllers\AdminControllers\AddressController::class, 'getZonesByCity'])->name('public.locations.zones');
Route::get('/locations/districts/{zoneId}'             , [\App\Http\Controllers\AdminControllers\AddressController::class, 'getDistrictsByZone'])->name('public.locations.districts');
Route::get('/shipping/rate/{cityId}'                   , [\App\Http\Controllers\WebsiteControllers\CartController::class, 'getShippingRate'])->name('public.shipping.rate');

Route::get('/'                                         , [PageController::class,                           'homePage'])->name('home');
Route::get('/about'                                    , [PageController::class,                          'aboutPage'])->name('about');
Route::get('/contact'                                  , [PageController::class,                        'contactPage'])->name('contact');
Route::post('/contact'                                 , [ContactFormController::class,                'contactStore'])->name('contact.store');
Route::get('/blogs/all'                                , [BlogController::class,                           'blogPage'])->name('blogs');
Route::get('/blogs/topic/{slug}'                       , [BlogController::class,                        'blogByTopic'])->name('topic.blogs');
Route::get('/blogs/single/{slug}'                      , [BlogController::class,                         'singleBlog'])->name('blog.single');
Route::get('/tips/all'                                 , [TipsController::class,                           'tipsPage'])->name('tips');
Route::get('/tips/playlist/{slug}'                     , [TipsController::class,                   'videosByPlaylist'])->name('playlist.videos');
Route::get('/tips/video/{slug}'                        , [TipsController::class,                        'singleVideo'])->name('video.single');

Route::get('/shop/brand/{slug}'                        , [PageController::class,                        'shopByBrand'])->name('shop.brand');
Route::get('/shop/all'                                 , [PageController::class,                            'shopAll'])->name('shop.all');
Route::get('/shop/category/{slug}'                     , [PageController::class,                     'shopByCategory'])->name('shop.category');
Route::get('/shop/gender/{slug}'                       , [PageController::class,                       'shopByGender'])->name('shop.gender');
Route::get('/product/{slug}'                           , [ProductController::class,                     'productShow'])->name('product.show');

Route::get('cart/get/html'                             , [CartController::class,                        'getCartHtml'])->name('cart.get.html');
Route::get('cart/page'                                 , [CartController::class,                           'cartPage'])->name('cart.page');
Route::post('cart/'                                    , [CartController::class,                              'store'])->name('cart.store');
Route::delete('cart/clear'                             , [CartController::class,                              'clear'])->name('cart.clear');
Route::put('cart/{id}'                                 , [CartController::class,                             'update'])->name('cart.update');
Route::delete('cart/{id}'                              , [CartController::class,                            'destroy'])->name('cart.destroy');
Route::get('/checkout'                                 , [CartController::class,                           'checkout'])->name('checkout.page');
Route::post('/cart/checkout/process'                   , [OrderController::class,                   'processCheckout'])->name('checkout.process');
Route::get('/order/success/{order}'                    , [OrderController::class,                      'orderSuccess'])->name('order.success');
Route::post('/order/payment/{order}'                   , [OrderController::class,                    'processPayment'])->name('order.payment');
// single product
Route::get('/wishlist'                                 , [WishlistController::class,                          'index'])->name('wishlist.index');
Route::post('/wishlist'                                , [WishlistController::class,                          'store'])->name('wishlist.store');
Route::post('/wishlist/toggle'                         , [WishlistController::class,                         'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/check'                          , [WishlistController::class,                          'check'])->name('wishlist.check');
Route::delete('/wishlist/{productId}'                  , [WishlistController::class,                        'destroy'])->name('wishlist.destroy');

// Reviews
Route::post('/reviews'                                 , [ReviewController::class,                            'store'])->name('reviews.store');
Route::get('/reviews/product/{productId}'              , [ReviewController::class,                'getProductReviews'])->name('reviews.product');

Route::get('/terms'                                   , [PageController::class,                            'termsPage'])->name('terms');

// Log Viewer Routes (For Development)
Route::get('/dev/logs'                                , [LogViewerController::class,                             'index'])->name('logs.viewer');
Route::post('/dev/logs/clear'                         , [LogViewerController::class,                             'clear'])->name('logs.clear');

// Route::middleware(['auth:client'])->prefix('client')->group(function ()     {
//     // Route::get('/dashboard', function () { return view('client.profile.index'); })->name('dashboard');
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('client.profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('client.profile.destroy');
// });
