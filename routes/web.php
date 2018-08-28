<?php
Auth::routes();

Route::get('/', 'StoreController@indexProducts');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/help', function () {
    return view('help')->with('user', Auth::user());
})->name('help');

Route::get('/location', function () {
    return view('location');
});

Route::get('/terms', function() {
    return view('terms');
});

Route::get('/privacy', function() {
    return view('privacy');
});

Route::get('/guarantee', function() {
    return view('guarantee');
});

Route::get('/security', function() {
    return view('security');
})->name('security');
/* *****************************
 * PROFILE ROUTES
 * ****************************/
 
Route::get('/profile', 'UserController@showProfile')->name('profile')->middleware('auth');

Route::get('/profile/shipping-address', 'UserController@showShippingAddress')->name('shipping-address')->middleware('auth');
Route::post('/profile/shipping-address', 'UserController@editShippingAddress')->name('shipping-address')->middleware('auth');

Route::get('/profile/billing-address', 'UserController@showBillingAddress')->name('billing-address')->middleware('auth');
Route::post('/profile/billing-address', 'UserController@editBillingAddress')->name('billing-address')->middleware('auth');

//orders routes
Route::get('/profile/orders/completed', 'OrderController@showCompleted')->name('completed-orders')->middleware('auth');
Route::get('/profile/orders/active', 'OrderController@showActive')->name('active-orders')->middleware('auth');
Route::get('/profile/order/show/{order}', 'OrderController@showOrder')->name('order')->middleware('auth');


Route::get('/panel/delivery', function () {
    return view ('delivery'); 
})->middleware('auth', 'delivery');

/* *****************************
 * STORE ROUTES
 * -----------------------------
 * Remember: store is divided in product types sections. 
 * Each product type has many categories, and each category has many 
 * subcategories, which we also call filters. 
 * FOR MORE, READ: StoreController
 * ****************************/
 
 /// productType URLparam uses the 'slug' column in the table 'product_types'
 /// route model binding customization (see: https://laravel.com/docs/5.4/routing#route-model-binding)
Route::get('/store/{productType}/{page?}', 'StoreController@index')->name('store');
Route::post('/store/catalog', 'StoreController@showCatalog');
Route::get('/product/{product}', 'ProductController@index')->name('product-page');


/* *****************************
 * STORE CART ROUTES
 * ****************************/
Route::post('/cart/new', 'CartController@newItem');
Route::get('/cart/show', 'CartController@showItems');
Route::post('/cart/delete', 'CartController@deleteItem');
Route::post('/cart/quantity', 'CartController@updateQuantityOfItems');


/* *****************************
 * SEARCH RESULTS
 * ****************************/
Route::get('/search', 'SearchController@showResults')->name('search');
 

/* *****************************
 * CHECKOUT ROUTES
 * ****************************/
Route::get('/checkout', 'CheckoutController@showCheckout')->name('checkout')->middleware('auth');
Route::post('/checkout', 'CheckoutController@confirmCheckout')->name('checkout')->middleware('auth');

Route::get('/checkout/pay', 'CheckoutController@payOrder')->name('checkout-payment')->middleware('auth');
Route::post('/checkout/pay', 'CheckoutController@cardPaymentConfirmation')->middleware('auth');
Route::post('/checkout/paypal/success', 'CheckoutController@paypalSuccess')->middleware('auth');

/* *****************************
 * HOUSEKEEPING ROUTES
 * ****************************/
 
//// ADMIN MIDDLEWARE ONLY ROUTES
 Route::group(['middleware' => ['admin']], function () {
     
    Route::get('/housekeeping', function() {
        return view('hk.index');
    })->name('hkindex');
    
    // store settings go here mainly
    Route::get('/housekeeping/store', 'StoreSettingsController@show')->name('hkstore');
    Route::post('/housekeeping/store', 'StoreSettingsController@update')->name('hkstore');
    
    // ** Step 1 of loading products
    Route::get('/housekeeping/products/load', 'LoadProductsController@showLoadProductsPage')->name('hkload-step1');
    Route::post('/housekeeping/products/load', 'LoadProductsController@createProductType');
    // next route sets session for next step to be accesible
    Route::post('/housekeeping/products/load/set', 'LoadProductsController@setProductTypeSession')->name('hkload-step1-session');
    
    // ** Step where user will decide wether to load products or categories/subcategories
    Route::get('/housekeeping/products/pick', 'LoadProductsController@showStepPick')->name('hkload-step-pick');
    
    // ** Step of loading product categories
    Route::get('/housekeeping/products/load/categories', 'LoadProductsController@showSelectProductCategory')->name('hkload-categories');
    Route::post('/housekeeping/products/load/categories', 'LoadProductsController@createProductCategory');
    // next route sets session for next step to be accesible
    Route::post('/housekeeping/products/load/categories/set', 'LoadProductsController@setProductCategorySession')->name('hkload-categories-session');
    
    // ** Step of loading product subcategories
    Route::get('/housekeeping/products/load/subcategories', 'LoadProductsController@showSelectProductSubcategory')->name('hkload-subcategories');
    Route::post('/housekeeping/products/load/subcategories', 'LoadProductsController@createProductSubcategory');
    
    
    // ** This unsets every Product type, Category and Subcategory sessions created before
    Route::get('/housekeeping/products/load/unset', 'LoadProductsController@unsetSessions')->name('hkload-unset-sessions');
    
    // ** Step of loading products
    Route::get('/housekeeping/products/load/products', 'LoadProductsController@showLoadProduct')->name('hkload-products');
    Route::get('/housekeeping/products/delete/products', 'LoadProductsController@showDeleteProduct')->name('hkload-delete-products');
    Route::post('/housekeeping/products/delete/products', 'LoadProductsController@deleteProduct')->name('hkload-delete-products');
    Route::post('/housekeeping/products/load/products', 'LoadProductsController@loadProduct');

    Route::get('/housekeeping/orders', function() { return view('hk.orders.index'); })->name('hkorders');

    Route::get('/housekeeping/orders/search', function() { return view('hk.orders.search'); })->name('hkorder-search');
    Route::post('/housekeeping/orders/search', 'HKOrdersController@search');
    
    Route::get('/housekeeping/orders/active', 'HKOrdersController@showActive')->name('hkorders-active');
    Route::get('/housekeeping/orders/completed', 'HKOrdersController@showCompleted')->name('hkorders-completed');

    Route::post('/housekeeping/orders/update/status', 'HKOrdersController@updateStatus')->name('hkorders-update-status');
    
    Route::get('/housekeeping/orders/show/{order}', 'HKOrdersController@showOrder')->name('hkorder');
    
});
















