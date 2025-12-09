<?php

use App\Http\Controllers\AdminControllers\AddressController;
use App\Http\Controllers\AdminControllers\AttributeController;
use App\Http\Controllers\AdminControllers\BankAccountController;
use App\Http\Controllers\AdminControllers\BrandController;
use App\Http\Controllers\AdminControllers\CategoryController;
use App\Http\Controllers\AdminControllers\CityController;
use App\Http\Controllers\AdminControllers\ClientController;
use App\Http\Controllers\AdminControllers\ConcernController;
use App\Http\Controllers\AdminControllers\CouponController;
use App\Http\Controllers\AdminControllers\DistrictController;
use App\Http\Controllers\AdminControllers\GenderController;
use App\Http\Controllers\AdminControllers\LocationController;
use App\Http\Controllers\AdminControllers\OrderController;
use App\Http\Controllers\AdminControllers\OrderStatusController;
use App\Http\Controllers\AdminControllers\PaymentMethodController;
use App\Http\Controllers\AdminControllers\PickupLocationController;
use App\Http\Controllers\AdminControllers\ProductController;
use App\Http\Controllers\AdminControllers\ReturnOrderController;
use App\Http\Controllers\AdminControllers\ReturnReasonController;
use App\Http\Controllers\AdminControllers\ShipmentController;
use App\Http\Controllers\AdminControllers\ShipperController;
use App\Http\Controllers\AdminControllers\ShippingRateController;
use App\Http\Controllers\AdminControllers\SkinToneController;
use App\Http\Controllers\AdminControllers\SkinTypeController;
use App\Http\Controllers\AdminControllers\StockController;
use App\Http\Controllers\AdminControllers\SupplierController;
use App\Http\Controllers\AdminControllers\SupplyController;
use App\Http\Controllers\AdminControllers\TagController;
use App\Http\Controllers\AdminControllers\TopicController;
use App\Http\Controllers\AdminControllers\BlogController;
use App\Http\Controllers\AdminControllers\PlaylistController;
use App\Http\Controllers\AdminControllers\VideoController;
use App\Http\Controllers\AdminControllers\NewsletterController;
use App\Http\Controllers\AdminControllers\SettingController;
use App\Http\Controllers\AdminControllers\ReviewController;
use App\Http\Controllers\AdminControllers\QuestionController;
use App\Http\Controllers\AdminControllers\PosController;
use App\Http\Controllers\AdminControllers\VariantController;
use App\Http\Controllers\AdminControllers\WarehouseController;
use App\Http\Controllers\AdminControllers\ZoneController;
use App\Http\Controllers\AdminControllers\ContactFormController;
use App\Http\Controllers\AdminControllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth:web'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard'                                          , [PageController::class,                              'dashboard'])->name('dashboard');
    Route::get('/'                                                   , [PageController::class,                              'dashboard'])->name('admin');

    Route::get   ('/clients'                                         ,[ClientController::class,                                 'index'])->name('clients.index');
    Route::post  ('/clients/store'                                   ,[ClientController::class,                                 'store'])->name('clients.store');
    Route::get   ('/clients/{id}/profile'                            ,[ClientController::class,                                  'show'])->name('clients.profile');
    Route::get   ('/clients/{id}/edit'                               ,[ClientController::class,                                  'edit'])->name('clients.edit');
    Route::put   ('/clients/{id}'                                    ,[ClientController::class,                                'update'])->name('clients.update');
    Route::delete('/clients/{id}'                                    ,[ClientController::class,                               'destroy'])->name('clients.destroy');
    Route::post  ('/clients/{id}/block'                              ,[ClientController::class,                                 'block'])->name('clients.block');
    Route::put   ('/clients/{id}/skin-profile'                       ,[ClientController::class,                     'updateSkinProfile'])->name('clients.update-skin-profile');
    Route::put   ('/clients/{id}/concerns'                           ,[ClientController::class,                        'updateConcerns'])->name('clients.update-concerns');
    Route::post  ('/clients/{id}/manage-points'                      ,[ClientController::class,                          'managePoints'])->name('clients.manage-points');

    // Orders Management
    Route::get   ('/orders'                                          ,[OrderController::class,                                  'index'])->name('orders.index');
    Route::get   ('/orders/{id}'                                     ,[OrderController::class,                                   'show'])->name('orders.show');
    Route::get   ('/orders/{orderId}/details'                        ,[ClientController::class,                       'getOrderDetails'])->name('orders.details');
    Route::post  ('/orders/{id}/update-status'                       ,[OrderController::class,                           'updateStatus'])->name('orders.update-status');
    Route::post  ('/orders/{id}/toggle-paid'                         ,[OrderController::class,                             'togglePaid'])->name('orders.toggle-paid');
    Route::post  ('/orders/{id}/toggle-done'                         ,[OrderController::class,                             'toggleDone'])->name('orders.toggle-done');
    Route::post  ('/orders/{id}/cancel'                              ,[OrderController::class,                                 'cancel'])->name('orders.cancel');
    Route::post  ('/orders/{id}/add-payment'                         ,[OrderController::class,                             'addPayment'])->name('orders.add-payment');
    Route::post  ('/orders/{id}/update-notes'                        ,[OrderController::class,                            'updateNotes'])->name('orders.update-notes');

    // Payment Management
    Route::put   ('/orders/payments/{paymentId}/approve'             ,[OrderController::class,                        'approvePayment'])->name('orders.payments.approve');
    Route::put   ('/orders/payments/{paymentId}/reject'              ,[OrderController::class,                         'rejectPayment'])->name('orders.payments.reject');

    Route::post  ('/addresses/store'                                 ,[AddressController::class,                                'store'])->name('addresses.store');
    Route::get   ('/addresses/{id}/edit'                             ,[AddressController::class,                                 'edit'])->name('addresses.edit');
    Route::put   ('/addresses/{id}'                                  ,[AddressController::class,                               'update'])->name('addresses.update');
    Route::delete('/addresses/{id}'                                  ,[AddressController::class,                              'destroy'])->name('addresses.destroy');
    Route::post  ('/addresses/{id}/set-default'                      ,[AddressController::class,                           'setDefault'])->name('addresses.setDefault');

    // Location AJAX endpoints
    Route::get   ('/locations/zones/{cityId}'                        ,[AddressController::class,                       'getZonesByCity'])->name('locations.zones');
    Route::get   ('/locations/districts/{zoneId}'                    ,[AddressController::class,                   'getDistrictsByZone'])->name('locations.districts');

    // Unified Locations Management
    Route::get   ('/locations'                                       ,[LocationController::class,                               'index'])->name('locations.index');
    Route::post  ('/locations/store'                                 ,[LocationController::class,                               'store'])->name('locations.store');
    Route::get   ('/locations/{id}'                                  ,[LocationController::class,                                'show'])->name('locations.show');
    Route::get   ('/locations/{id}/data'                             ,[LocationController::class,                                'view'])->name('locations.view');
    Route::get   ('/locations/{id}/edit'                             ,[LocationController::class,                                'edit'])->name('locations.edit');
    Route::put   ('/locations/{id}'                                  ,[LocationController::class,                              'update'])->name('locations.update');
    Route::delete('/locations/{id}'                                  ,[LocationController::class,                             'destroy'])->name('locations.destroy');
    Route::post  ('/locations/import-json'                           ,[LocationController::class,                          'importJson'])->name('locations.import-json');

    // Zone Management within Locations
    Route::post  ('/locations/zones/create'                          ,[LocationController::class,                          'createZone'])->name('locations.zones.create');
    Route::put   ('/locations/zones/{id}'                            ,[LocationController::class,                          'updateZone'])->name('locations.zones.update');
    Route::delete('/locations/zones/{id}'                            ,[LocationController::class,                         'destroyZone'])->name('locations.zones.destroy');

    // District Management within Locations
    Route::post  ('/locations/districts/create-multiple'             ,[LocationController::class,             'createMultipleDistricts'])->name('locations.districts.create-multiple');
    Route::put   ('/locations/districts/{id}'                        ,[LocationController::class,                      'updateDistrict'])->name('locations.districts.update');
    Route::delete('/locations/districts/{id}'                        ,[LocationController::class,                     'destroyDistrict'])->name('locations.districts.destroy');

    // Cities Management
    Route::get   ('/cities'                                          ,[CityController::class,                                   'index'])->name('cities.index');
    Route::post  ('/cities/store'                                    ,[CityController::class,                                   'store'])->name('cities.store');
    Route::put   ('/cities/{id}'                                     ,[CityController::class,                                  'update'])->name('cities.update');
    Route::delete('/cities/{id}'                                     ,[CityController::class,                                 'destroy'])->name('cities.destroy');
    Route::post  ('/locations/import-json'                           ,[CityController::class,                              'importJson'])->name('locations.import-json');

    // Zones Management
    Route::get   ('/zones'                                           ,[ZoneController::class,                                   'index'])->name('zones.index');
    Route::post  ('/zones/store'                                     ,[ZoneController::class,                                   'store'])->name('zones.store');
    Route::put   ('/zones/{id}'                                      ,[ZoneController::class,                                  'update'])->name('zones.update');
    Route::delete('/zones/{id}'                                      ,[ZoneController::class,                                 'destroy'])->name('zones.destroy');

    // Districts Management
    Route::get   ('/districts'                                       ,[DistrictController::class,                               'index'])->name('districts.index');
    Route::post  ('/districts/store'                                 ,[DistrictController::class,                               'store'])->name('districts.store');
    Route::put   ('/districts/{id}'                                  ,[DistrictController::class,                              'update'])->name('districts.update');
    Route::delete('/districts/{id}'                                  ,[DistrictController::class,                             'destroy'])->name('districts.destroy');

    // Shippers Management
    Route::get   ('/shippers'                                        ,[ShipperController::class,                                'index'])->name('shippers.index');
    Route::post  ('/shippers/store'                                  ,[ShipperController::class,                                'store'])->name('shippers.store');
    Route::get   ('/shippers/{id}/edit'                              ,[ShipperController::class,                                 'edit'])->name('shippers.edit');
    Route::put   ('/shippers/{id}'                                   ,[ShipperController::class,                               'update'])->name('shippers.update');
    Route::delete('/shippers/{id}'                                   ,[ShipperController::class,                              'destroy'])->name('shippers.destroy');

    // Shipments Management
    Route::get   ('/shipments'                                       ,[ShipmentController::class,                               'index'])->name('shipments.index');
    Route::post  ('/shipments/store'                                 ,[ShipmentController::class,                               'store'])->name('shipments.store');
    Route::get   ('/shipments/{id}'                                  ,[ShipmentController::class,                                'show'])->name('shipments.show');
    Route::get   ('/shipments/{id}/edit'                             ,[ShipmentController::class,                                'edit'])->name('shipments.edit');
    Route::put   ('/shipments/{id}'                                  ,[ShipmentController::class,                              'update'])->name('shipments.update');
    Route::delete('/shipments/{id}'                                  ,[ShipmentController::class,                             'destroy'])->name('shipments.destroy');
    Route::post  ('/shipments/{id}/tracking-events'                  ,[ShipmentController::class,                  'storeTrackingEvent'])->name('shipments.tracking-events.store');
    Route::delete('/shipments/{shipmentId}/tracking-events/{eventId}',[ShipmentController::class,                'destroyTrackingEvent'])->name('shipments.tracking-events.destroy');

    // Shipping Rates Management
    Route::get   ('/shipping-rates'                                  ,[ShippingRateController::class,                           'index'])->name('shipping-rates.index');
    Route::post  ('/shipping-rates/store'                            ,[ShippingRateController::class,                           'store'])->name('shipping-rates.store');
    Route::get   ('/shipping-rates/{id}/edit'                        ,[ShippingRateController::class,                            'edit'])->name('shipping-rates.edit');
    Route::put   ('/shipping-rates/{id}'                             ,[ShippingRateController::class,                          'update'])->name('shipping-rates.update');
    Route::delete('/shipping-rates/{id}'                             ,[ShippingRateController::class,                         'destroy'])->name('shipping-rates.destroy');

    // Order Statuses Management
    Route::get   ('/order-statuses'                                  ,[OrderStatusController::class,                            'index'])->name('order-statuses.index');
    Route::post  ('/order-statuses/store'                            ,[OrderStatusController::class,                            'store'])->name('order-statuses.store');
    Route::get   ('/order-statuses/{id}/edit'                        ,[OrderStatusController::class,                             'edit'])->name('order-statuses.edit');
    Route::put   ('/order-statuses/{id}'                             ,[OrderStatusController::class,                           'update'])->name('order-statuses.update');
    Route::delete('/order-statuses/{id}'                             ,[OrderStatusController::class,                          'destroy'])->name('order-statuses.destroy');

    // Payment Methods Management
    Route::get   ('/payment-methods'                                 ,[PaymentMethodController::class,                          'index'])->name('payment-methods.index');
    Route::post  ('/payment-methods/store'                           ,[PaymentMethodController::class,                          'store'])->name('payment-methods.store');
    Route::get   ('/payment-methods/{id}/edit'                       ,[PaymentMethodController::class,                           'edit'])->name('payment-methods.edit');
    Route::put   ('/payment-methods/{id}'                            ,[PaymentMethodController::class,                         'update'])->name('payment-methods.update');
    Route::delete('/payment-methods/{id}'                            ,[PaymentMethodController::class,                        'destroy'])->name('payment-methods.destroy');

    // Bank Accounts Management
    Route::get   ('/bank-accounts'                                   ,[BankAccountController::class,                            'index'])->name('bank-accounts.index');
    Route::post  ('/bank-accounts/store'                             ,[BankAccountController::class,                            'store'])->name('bank-accounts.store');
    Route::get   ('/bank-accounts/{id}/edit'                         ,[BankAccountController::class,                             'edit'])->name('bank-accounts.edit');
    Route::put   ('/bank-accounts/{id}'                              ,[BankAccountController::class,                           'update'])->name('bank-accounts.update');
    Route::delete('/bank-accounts/{id}'                              ,[BankAccountController::class,                          'destroy'])->name('bank-accounts.destroy');

    // Warehouses Management
    Route::get   ('/warehouses'                                      ,[WarehouseController::class,                              'index'])->name('warehouses.index');
    Route::post  ('/warehouses/store'                                ,[WarehouseController::class,                              'store'])->name('warehouses.store');
    Route::get   ('/warehouses/{id}/edit'                            ,[WarehouseController::class,                               'edit'])->name('warehouses.edit');
    Route::put   ('/warehouses/{id}'                                 ,[WarehouseController::class,                             'update'])->name('warehouses.update');
    Route::delete('/warehouses/{id}'                                 ,[WarehouseController::class,                            'destroy'])->name('warehouses.destroy');

    // Pickup Locations Management
    Route::get   ('/pickup-locations'                                ,[PickupLocationController::class,                         'index'])->name('pickup-locations.index');
    Route::post  ('/pickup-locations/store'                          ,[PickupLocationController::class,                         'store'])->name('pickup-locations.store');
    Route::get   ('/pickup-locations/{id}/edit'                      ,[PickupLocationController::class,                          'edit'])->name('pickup-locations.edit');
    Route::put   ('/pickup-locations/{id}'                           ,[PickupLocationController::class,                        'update'])->name('pickup-locations.update');
    Route::delete('/pickup-locations/{id}'                           ,[PickupLocationController::class,                       'destroy'])->name('pickup-locations.destroy');
    Route::get   ('/pickup-locations/zones/{cityId}'                 ,[PickupLocationController::class,                'getZonesByCity'])->name('pickup-locations.zones-by-city');
    Route::get   ('/pickup-locations/districts/{zoneId}'             ,[PickupLocationController::class,            'getDistrictsByZone'])->name('pickup-locations.districts-by-zone');

    // Stocks Management
    Route::get   ('/stocks'                                          ,[StockController::class,                                  'index'])->name('stocks.index');
    Route::post  ('/stocks/store'                                    ,[StockController::class,                                  'store'])->name('stocks.store');
    Route::get   ('/stocks/variants/{productId}'                     ,[StockController::class,                   'getVariantsByProduct'])->name('stocks.variants-by-product');
    Route::get   ('/stocks/{id}'                                     ,[StockController::class,                                   'show'])->name('stocks.show');
    Route::get   ('/stocks/{id}/edit'                                ,[StockController::class,                                   'edit'])->name('stocks.edit');
    Route::put   ('/stocks/{id}'                                     ,[StockController::class,                                 'update'])->name('stocks.update');
    Route::delete('/stocks/{id}'                                     ,[StockController::class,                                'destroy'])->name('stocks.destroy');
    Route::post  ('/stocks/{id}/logs'                                ,[StockController::class,                               'storeLog'])->name('stocks.logs.store');
    Route::delete('/stocks/{stockId}/logs/{logId}'                   ,[StockController::class,                             'destroyLog'])->name('stocks.logs.destroy');

    // Suppliers Management
    Route::get   ('/suppliers'                                       ,[SupplierController::class,                               'index'])->name('suppliers.index');
    Route::post  ('/suppliers/store'                                 ,[SupplierController::class,                               'store'])->name('suppliers.store');
    Route::get   ('/suppliers/{id}/edit'                             ,[SupplierController::class,                                'edit'])->name('suppliers.edit');
    Route::put   ('/suppliers/{id}'                                  ,[SupplierController::class,                              'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}'                                  ,[SupplierController::class,                             'destroy'])->name('suppliers.destroy');

    // Supplies Management
    Route::get   ('/supplies'                                        ,[SupplyController::class,                                 'index'])->name('supplies.index');
    Route::get   ('/supplies/create'                                 ,[SupplyController::class,                                'create'])->name('supplies.create');
    Route::post  ('/supplies/store'                                  ,[SupplyController::class,                                 'store'])->name('supplies.store');
    Route::get   ('/supplies/variants/{productId}'                   ,[SupplyController::class,                  'getVariantsByProduct'])->name('supplies.variants-by-product');
    Route::get   ('/supplies/{id}'                                   ,[SupplyController::class,                                  'show'])->name('supplies.show');
    Route::get   ('/supplies/{id}/edit'                              ,[SupplyController::class,                                  'edit'])->name('supplies.edit');
    Route::put   ('/supplies/{id}'                                   ,[SupplyController::class,                                'update'])->name('supplies.update');
    Route::delete('/supplies/{id}'                                   ,[SupplyController::class,                               'destroy'])->name('supplies.destroy');
    Route::post  ('/supplies/{id}/items'                             ,[SupplyController::class,                               'addItem'])->name('supplies.items.store');
    Route::delete('/supplies/{supplyId}/items/{itemId}'              ,[SupplyController::class,                            'deleteItem'])->name('supplies.items.destroy');
    Route::post  ('/supplies/{id}/complete'                          ,[SupplyController::class,                        'completeSupply'])->name('supplies.complete');

    // Coupons Management
    Route::get   ('/coupons'                                         ,[CouponController::class,                                 'index'])->name('coupons.index');
    Route::post  ('/coupons/store'                                   ,[CouponController::class,                                 'store'])->name('coupons.store');
    Route::get   ('/coupons/generate-code'                           ,[CouponController::class,                          'generateCode'])->name('coupons.generate-code');
    Route::get   ('/coupons/{id}'                                    ,[CouponController::class,                                  'show'])->name('coupons.show');
    Route::get   ('/coupons/{id}/edit'                               ,[CouponController::class,                                  'edit'])->name('coupons.edit');
    Route::put   ('/coupons/{id}'                                    ,[CouponController::class,                                'update'])->name('coupons.update');
    Route::delete('/coupons/{id}'                                    ,[CouponController::class,                               'destroy'])->name('coupons.destroy');

    // Return Orders Management
    Route::get   ('/return-orders'                                   ,[ReturnOrderController::class,                            'index'])->name('return-orders.index');
    Route::get   ('/return-orders/create'                            ,[ReturnOrderController::class,                           'create'])->name('return-orders.create');
    Route::post  ('/return-orders/store'                             ,[ReturnOrderController::class,                            'store'])->name('return-orders.store');

    // AJAX endpoints (must be before {id} routes)
    Route::get   ('/return-orders/client/{clientId}/orders'          ,[ReturnOrderController::class,                  'getClientOrders'])->name('return-orders.client-orders');
    Route::get   ('/return-orders/order/{orderId}/items'             ,[ReturnOrderController::class,                    'getOrderItems'])->name('return-orders.order-items');
    Route::get   ('/return-orders/client/{clientId}/addresses'       ,[ReturnOrderController::class,           'getClientAddresses'])->name('return-orders.client-addresses');

    // Item actions (must be before {id} routes)
    Route::post  ('/return-orders/items/{id}/approve'                ,[ReturnOrderController::class,                       'approveItem'])->name('return-orders.items.approve');
    Route::post  ('/return-orders/items/{id}/reject'                 ,[ReturnOrderController::class,                        'rejectItem'])->name('return-orders.items.reject');
    Route::post  ('/return-orders/items/{id}/refund'                 ,[ReturnOrderController::class,                        'refundItem'])->name('return-orders.items.refund');

    // Bulk actions (must be before {id} routes)
    Route::post  ('/return-orders/{id}/approve-all'                  ,[ReturnOrderController::class,                       'approveAll'])->name('return-orders.approve-all');
    Route::post  ('/return-orders/{id}/refund-all'                   ,[ReturnOrderController::class,                        'refundAll'])->name('return-orders.refund-all');

    // Standard CRUD with {id} parameter (must be last)
    Route::get   ('/return-orders/{id}'                              ,[ReturnOrderController::class,                             'show'])->name('return-orders.show');
    Route::put   ('/return-orders/{id}'                              ,[ReturnOrderController::class,                           'update'])->name('return-orders.update');
    Route::delete('/return-orders/{id}'                              ,[ReturnOrderController::class,                          'destroy'])->name('return-orders.destroy');

    // Return Reasons Management
    Route::get   ('/return-reasons'                                  ,[ReturnReasonController::class,                           'index'])->name('return-reasons.index');
    Route::post  ('/return-reasons/store'                            ,[ReturnReasonController::class,                           'store'])->name('return-reasons.store');
    Route::get   ('/return-reasons/{id}/edit'                        ,[ReturnReasonController::class,                            'edit'])->name('return-reasons.edit');
    Route::put   ('/return-reasons/{id}'                             ,[ReturnReasonController::class,                          'update'])->name('return-reasons.update');
    Route::delete('/return-reasons/{id}'                             ,[ReturnReasonController::class,                         'destroy'])->name('return-reasons.destroy');

    Route::get   ('/skin-tones'                                      ,[SkinToneController::class,                               'index'])->name('skin-tones.index');
    Route::post  ('/skin-tones/store'                                ,[SkinToneController::class,                               'store'])->name('skin-tones.store');
    Route::get   ('/skin-tones/{id}/edit'                            ,[SkinToneController::class,                                'edit'])->name('skin-tones.edit');
    Route::put   ('/skin-tones/{id}'                                 ,[SkinToneController::class,                              'update'])->name('skin-tones.update');
    Route::delete('/skin-tones/{id}'                                 ,[SkinToneController::class,                             'destroy'])->name('skin-tones.destroy');

    Route::get   ('/skin-types'                                      ,[SkinTypeController::class,                               'index'])->name('skin-types.index');
    Route::post  ('/skin-types/store'                                ,[SkinTypeController::class,                               'store'])->name('skin-types.store');
    Route::get   ('/skin-types/{id}/edit'                            ,[SkinTypeController::class,                                'edit'])->name('skin-types.edit');
    Route::put   ('/skin-types/{id}'                                 ,[SkinTypeController::class,                              'update'])->name('skin-types.update');
    Route::delete('/skin-types/{id}'                                 ,[SkinTypeController::class,                             'destroy'])->name('skin-types.destroy');

    Route::get   ('/concerns'                                        ,[ConcernController::class,                                'index'])->name('concerns.index');
    Route::post  ('/concerns/store'                                  ,[ConcernController::class,                                'store'])->name('concerns.store');
    Route::get   ('/concerns/{id}/edit'                              ,[ConcernController::class,                                 'edit'])->name('concerns.edit');
    Route::put   ('/concerns/{id}'                                   ,[ConcernController::class,                               'update'])->name('concerns.update');
    Route::delete('/concerns/{id}'                                   ,[ConcernController::class,                              'destroy'])->name('concerns.destroy');

    Route::get   ('/genders'                                         ,[GenderController::class,                                 'index'])->name('genders.index');
    Route::post  ('/genders/store'                                   ,[GenderController::class,                                 'store'])->name('genders.store');
    Route::get   ('/genders/{id}/edit'                               ,[GenderController::class,                                  'edit'])->name('genders.edit');
    Route::put   ('/genders/{id}'                                    ,[GenderController::class,                                'update'])->name('genders.update');
    Route::delete('/genders/{id}'                                    ,[GenderController::class,                               'destroy'])->name('genders.destroy');

    Route::get   ('/categories'                                      ,[CategoryController::class,                               'index'])->name('categories.index');
    Route::post  ('/categories/store'                                ,[CategoryController::class,                               'store'])->name('categories.store');
    Route::get   ('/categories/{id}/edit'                            ,[CategoryController::class,                                'edit'])->name('categories.edit');
    Route::put   ('/categories/{id}'                                 ,[CategoryController::class,                              'update'])->name('categories.update');
    Route::delete('/categories/{id}'                                 ,[CategoryController::class,                             'destroy'])->name('categories.destroy');

    Route::get   ('/brands'                                          ,[BrandController::class,                                  'index'])->name('brands.index');
    Route::post  ('/brands/store'                                    ,[BrandController::class,                                  'store'])->name('brands.store');
    Route::get   ('/brands/{id}/edit'                                ,[BrandController::class,                                   'edit'])->name('brands.edit');
    Route::put   ('/brands/{id}'                                     ,[BrandController::class,                                 'update'])->name('brands.update');
    Route::delete('/brands/{id}'                                     ,[BrandController::class,                                'destroy'])->name('brands.destroy');

    Route::get   ('/attributes'                                      ,[AttributeController::class,                              'index'])->name('attributes.index');
    Route::post  ('/attributes/store'                                ,[AttributeController::class,                              'store'])->name('attributes.store');
    Route::get   ('/attributes/{id}/edit'                            ,[AttributeController::class,                               'edit'])->name('attributes.edit');
    Route::put   ('/attributes/{id}'                                 ,[AttributeController::class,                             'update'])->name('attributes.update');
    Route::delete('/attributes/{id}'                                 ,[AttributeController::class,                            'destroy'])->name('attributes.destroy');

    Route::get   ('/tags'                                            ,[TagController::class,                                    'index'])->name('tags.index');
    Route::post  ('/tags/store'                                      ,[TagController::class,                                    'store'])->name('tags.store');
    Route::post  ('/tags/quick-create'                               ,[TagController::class,                              'quickCreate'])->name('tags.quick-create');
    Route::get   ('/tags/{id}/edit'                                  ,[TagController::class,                                     'edit'])->name('tags.edit');
    Route::put   ('/tags/{id}'                                       ,[TagController::class,                                   'update'])->name('tags.update');
    Route::delete('/tags/{id}'                                       ,[TagController::class,                                  'destroy'])->name('tags.destroy');

    Route::get   ('/products'                                        ,[ProductController::class,                                'index'])->name('products.index');
    Route::get   ('/products/search'                                 ,[ProductController::class,                       'searchProducts'])->name('products.search');
    Route::get   ('/products/create'                                 ,[ProductController::class,                               'create'])->name('products.create');
    Route::post  ('/products/store'                                  ,[ProductController::class,                                'store'])->name('products.store');
    Route::get   ('/products/{id}'                                   ,[ProductController::class,                                 'show'])->name('products.show');
    Route::get   ('/products/{id}/edit'                              ,[ProductController::class,                                 'edit'])->name('products.edit');
    Route::put   ('/products/{id}'                                   ,[ProductController::class,                               'update'])->name('products.update');
    Route::delete('/products/{id}'                                   ,[ProductController::class,                              'destroy'])->name('products.destroy');
    Route::get   ('/products/{id}/set-variant-prices'                ,[ProductController::class,                     'setVariantPrices'])->name('products.set-variant-prices');
    Route::post  ('/products/{id}/update-variant-prices'             ,[ProductController::class,                  'updateVariantPrices'])->name('products.update-variant-prices');
    Route::post  ('/products/{id}/generate-variants'                 ,[ProductController::class,                     'generateVariants'])->name('products.generate-variants');
    Route::post  ('/products/{id}/save-barcode'                      ,[ProductController::class,                          'saveBarcode'])->name('products.save-barcode');

    Route::get   ('/variants/{id}/edit'                              ,[VariantController::class,                                 'edit'])->name('variants.edit');
    Route::put   ('/variants/{id}'                                   ,[VariantController::class,                               'update'])->name('variants.update');
    Route::delete('/variants/{id}'                                   ,[VariantController::class,                              'destroy'])->name('variants.destroy');

    // Topics Management
    Route::get   ('/topics'                                          ,[TopicController::class,                                  'index'])->name('topics.index');
    Route::post  ('/topics/store'                                    ,[TopicController::class,                                  'store'])->name('topics.store');
    Route::get   ('/topics/{id}/edit'                                ,[TopicController::class,                                   'edit'])->name('topics.edit');
    Route::put   ('/topics/{id}'                                     ,[TopicController::class,                                 'update'])->name('topics.update');
    Route::delete('/topics/{id}'                                     ,[TopicController::class,                                'destroy'])->name('topics.destroy');

    // Blogs Management
    Route::get   ('/blogs'                                           ,[BlogController::class,                                   'index'])->name('blogs.index');
    Route::get   ('/blogs/create'                                    ,[BlogController::class,                                  'create'])->name('blogs.create');
    Route::post  ('/blogs/store'                                     ,[BlogController::class,                                   'store'])->name('blogs.store');
    Route::get   ('/blogs/{id}'                                      ,[BlogController::class,                                    'show'])->name('blogs.show');
    Route::get   ('/blogs/{id}/edit'                                 ,[BlogController::class,                                    'edit'])->name('blogs.edit');
    Route::put   ('/blogs/{id}'                                      ,[BlogController::class,                                  'update'])->name('blogs.update');
    Route::delete('/blogs/{id}'                                      ,[BlogController::class,                                 'destroy'])->name('blogs.destroy');

    // Playlists Management
    Route::get   ('/playlists'                                       ,[PlaylistController::class,                               'index'])->name('playlists.index');
    Route::post  ('/playlists/store'                                 ,[PlaylistController::class,                               'store'])->name('playlists.store');
    Route::get   ('/playlists/{id}/edit'                             ,[PlaylistController::class,                                'edit'])->name('playlists.edit');
    Route::put   ('/playlists/{id}'                                  ,[PlaylistController::class,                              'update'])->name('playlists.update');
    Route::delete('/playlists/{id}'                                  ,[PlaylistController::class,                             'destroy'])->name('playlists.destroy');

    // Videos Management
    Route::get   ('/videos'                                          ,[VideoController::class,                                  'index'])->name('videos.index');
    Route::get   ('/videos/create'                                   ,[VideoController::class,                                 'create'])->name('videos.create');
    Route::post  ('/videos/store'                                    ,[VideoController::class,                                  'store'])->name('videos.store');
    Route::get   ('/videos/{id}'                                     ,[VideoController::class,                                   'show'])->name('videos.show');
    Route::get   ('/videos/{id}/edit'                                ,[VideoController::class,                                   'edit'])->name('videos.edit');
    Route::put   ('/videos/{id}'                                     ,[VideoController::class,                                 'update'])->name('videos.update');
    Route::delete('/videos/{id}'                                     ,[VideoController::class,                                'destroy'])->name('videos.destroy');

    // Newsletter Management
    Route::get   ('/newsletters'                                     ,[NewsletterController::class,                             'index'])->name('newsletters.index');
    Route::post  ('/newsletters/store'                               ,[NewsletterController::class,                             'store'])->name('newsletters.store');
    Route::get   ('/newsletters/export'                              ,[NewsletterController::class,                            'export'])->name('newsletters.export');
    Route::get   ('/newsletters/{id}/edit'                           ,[NewsletterController::class,                              'edit'])->name('newsletters.edit');
    Route::put   ('/newsletters/{id}'                                ,[NewsletterController::class,                            'update'])->name('newsletters.update');
    Route::delete('/newsletters/{id}'                                ,[NewsletterController::class,                           'destroy'])->name('newsletters.destroy');

    // Settings Management
    Route::get   ('/settings'                                        ,[SettingController::class,                                'index'])->name('settings.index');
    Route::post  ('/settings/store'                                  ,[SettingController::class,                                'store'])->name('settings.store');
    Route::get   ('/settings/{id}/edit'                              ,[SettingController::class,                                 'edit'])->name('settings.edit');
    Route::put   ('/settings/{id}'                                   ,[SettingController::class,                               'update'])->name('settings.update');
    Route::delete('/settings/{id}'                                   ,[SettingController::class,                              'destroy'])->name('settings.destroy');

    // Reviews Management (embedded in product/client page           s)
    Route::post  ('/reviews/store'                                   ,[ReviewController::class,                                 'store'])->name('reviews.store');
    Route::get   ('/reviews/{id}/edit'                               ,[ReviewController::class,                                  'edit'])->name('reviews.edit');
    Route::put   ('/reviews/{id}'                                    ,[ReviewController::class,                                'update'])->name('reviews.update');
    Route::delete('/reviews/{id}'                                    ,[ReviewController::class,                               'destroy'])->name('reviews.destroy');

    // Questions Management (embedded in product pages)
    Route::post  ('/questions/store'                                 ,[QuestionController::class,                               'store'])->name('questions.store');
    Route::get   ('/questions/{id}/edit'                             ,[QuestionController::class,                                'edit'])->name('questions.edit');
    Route::put   ('/questions/{id}'                                  ,[QuestionController::class,                              'update'])->name('questions.update');
    Route::delete('/questions/{id}'                                  ,[QuestionController::class,                             'destroy'])->name('questions.destroy');

    // Contact Form Management
    Route::get   ('/contact-forms'                                   ,[ContactFormController::class,                            'index'])->name('contact-forms.index');
    Route::delete('/contact-forms/{id}'                              ,[ContactFormController::class,                          'destroy'])->name('contact-forms.destroy');

    // POS System
    Route::get   ('/pos'                                             ,[PosController::class,                                    'index'])->name('pos.index');
    Route::post  ('/pos/session/open'                                ,[PosController::class,                              'openSession'])->name('pos.session.open');
    Route::post  ('/pos/session/close'                               ,[PosController::class,                             'closeSession'])->name('pos.session.close');
    Route::get   ('/pos/session/active'                              ,[PosController::class,                         'getActiveSession'])->name('pos.session.active');
    Route::get   ('/pos/products/search'                             ,[PosController::class,                           'searchProducts'])->name('pos.products.search');
    Route::get   ('/pos/products/{id}/details'                       ,[PosController::class,                        'getProductDetails'])->name('pos.products.details');
    Route::post  ('/pos/orders'                                      ,[PosController::class,                              'createOrder'])->name('pos.orders.create');
    Route::get   ('/pos/orders/{id}/receipt'                         ,[PosController::class,                             'printReceipt'])->name('pos.orders.receipt');
    Route::post  ('/pos/cart/save'                                   ,[PosController::class,                                 'saveCart'])->name('pos.cart.save');
    Route::get   ('/pos/cart/get'                                    ,[PosController::class,                                  'getCart'])->name('pos.cart.get');
    Route::delete('/pos/cart/clear'                                  ,[PosController::class,                                'clearCart'])->name('pos.cart.clear');

    Route::get('/profile'                                            ,[ProfileController::class,                                 'edit'])->name('profile.edit');
    Route::post('/profile'                                           ,[ProfileController::class,                               'update'])->name('profile.update');
    Route::post('/profile'                                           ,[ProfileController::class,                              'destroy'])->name('profile.destroy');
});

require __DIR__.'/front-end.php';
require __DIR__.'/auth.php';
