<?php

// new routes
Route::get('/viplist', 'HomeController@viplist');
Route::get('/viplist2', 'HomeController@viplist2');

Route::group(['prefix' => 'raf'], function() {
    Route::get('{page}', 'HomeController@rafPages');
});

//Home routes...
Route::get('/', 'HomeController@index');
Route::get('/homepage2', 'HomeController@newHomePage');
Route::get('/about', 'HomeController@about');
Route::get('/reviews', 'HomeController@reviews');
Route::get('/faqs', 'HomeController@faqs');
Route::get('/contact', 'HomeController@contact');
Route::get('/returnpolicy', 'HomeController@returnpolicy');
Route::get('/subscriptionpolicy', 'HomeController@subscriptionPolicy');
Route::get('/privacypolicy', 'HomeController@privacyPolicy');
Route::get('/terms', 'HomeController@terms');
Route::get('/thankyou', 'HomeController@thankyou');

//new product page route
Route::get('new_product_page/{id_or_slug}', ['as' => 'store_product', 'uses' => 'StoreController@newProductPage']);

// Viplist form
Route::get('/vipreview', 'FormController@vipreview');
Route::post('/vipreview', 'FormController@postVipreview');
Route::get('/vipreview/submitted', 'FormController@vipreviewThankyou');

// Wholesale form
Route::get('/wholesale', 'FormController@wholesale');
Route::post('/wholesale', 'FormController@postWholesale');
Route::get('/wholesale/submitted', 'FormController@wholesaleThankyou');

//Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
//Authentication Routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/socialredirect/{code}', 'Auth\AuthController@socialredirect');
//Social Registration / Authentication routes
Route::get('{provider}/authorize/{code}', 'Auth\AuthController@socialAuthorize');
Route::get('{provider}/login', 'Auth\AuthController@socialLogin');
Route::post('auth/members/confirm', 'Auth\AuthController@emailConfirm');
//Members/customers area routes
Route::get('members/profile', 'ProfileController@show'); //http://flavorgod.foo/raf/page3
Route::get('members/profile/edit', 'ProfileController@edit'); //http://flavorgod.foo/raf/page6
Route::put('members/profile/edit', 'ProfileController@update');
Route::post('members/profile/edit/imageupload', 'ProfileController@profileImageUpload');

Route::get('members/address/shipping', 'AddressController@shippingIndex');
Route::get('members/address/billing', 'AddressController@billingIndex');
Route::get('members/address/billing/edit', 'AddressController@billingedit');
Route::get('members/address/{id}/billing/default', 'AddressController@billingDefault')->where('id', '[0-9]+');
Route::get('members/address/{id}/shipping/default', 'AddressController@shippingDefault')->where('id', '[0-9]+');
Route::get('members/address/{id}/delete', 'AddressController@deleteAddress')->where('id', '[0-9]+');
Route::get('members/address/{id}/edit', 'AddressController@edit')->where('id', '[0-9]+');
Route::patch('members/address/{id}/update', 'AddressController@update')->where('id', '[0-9]+');
Route::get('members/address/create', 'AddressController@create');
Route::post('members/address/store', 'AddressController@store');

Route::get('members/orders', 'OrderController@index');
Route::get('members/orders/{id}', 'OrderController@getOrderDetails')->where('id', '[0-9]+');

Route::get('members/referralprogram', 'ReferralsController@index');

// Password reset link request routes...
Route::post('password/email', 'Auth\PasswordController@postEmail');
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
//Email verification routes
Route::post('email/verify', 'Auth\AuthController@postVerifyEmail');
Route::get('email/verify/{token}', 'Auth\AuthController@getVerifyEmail');
Route::get('email/sendverify/{email}', 'Auth\AuthController@resendVerifyEmail');
//Shop Routes...
Route::get('shop', ['as' => 'store_main', 'uses' => 'StoreController@index']);
Route::get('shop/product/{id_or_slug}', ['as' => 'store_product', 'uses' => 'StoreController@show']);
Route::get('shop/product/category/{product_set_name}', ['as' => 'by_product_set_name', 'uses' => 'StoreController@byProductSetName']);
//Vip List Routes
Route::get('vip', ['as' => 'vip_form', 'uses' => 'VipListController@create']);
Route::post('vip', ['as' => 'vip_form_submit', 'uses' => 'VipListController@store']);
//Out of stock vip Routes
Route::post('outofstock', ['as' => 'vip_out_of_stock', 'uses' => 'OutOfStockController@store']);
//Support Message Routes...
Route::post('support', ['as' => 'support_form_submit', 'uses' => 'SupportMessagesController@store']);
//Shopping cart Routes...
Route::group(['prefix' => 'cart', 'middleware' => 'nocache'], function () {
    Route::get('', ['as' => 'cart_view_cart', 'uses' => 'ShoppingCartController@index']);
    Route::post('', ['as' => 'cart_submit_view_cart', 'uses' => 'ShoppingCartController@postIndex']);
    Route::get('contact', ['as' => 'cart_view_contact', 'uses' => 'ShoppingCartController@getContact']);
    Route::post('contact', ['as' => 'cart_submit_contact', 'uses' => 'ShoppingCartController@postContact']);
    Route::get('payment', ['as' => 'cart_view_payment', 'uses' => 'ShoppingCartController@getPayment']);
    Route::post('payment', ['as' => 'cart_submit_payment', 'uses' => 'ShoppingCartController@postPayment']);
    Route::post('payment/storecredit', ['as' => 'apply_store_credit', 'uses' => 'ShoppingCartController@recordStoreCreditTransaction']);
    Route::delete('payment/storecredit', ['as' => 'apply_store_credit', 'uses' => 'ShoppingCartController@removeStoreCreditTransaction']);
    Route::get('paypal', ['as' => 'cart_paypal_checkout', 'uses' => 'ShoppingCartController@getPaypal']);
    Route::get('callback/{token}', ['as' => 'cart_paypal_callback', 'uses' => 'ShoppingCartController@getCallback']);
    Route::get('callback', ['as' => 'cart_paypal_callback', 'uses' => 'ShoppingCartController@getCallback']);
    Route::get('success', ['as' => 'cart_success', 'uses' => 'ShoppingCartController@getSuccess']);
    Route::get('failed', ['as' => 'cart_failed_page', 'uses' => 'ShoppingCartController@getFailed']);
    Route::get('error', ['as' => 'cart_error_page', 'uses' => 'ShoppingCartController@getError']);
    Route::get('discounts/remove/{code}', ['uses' => 'ShoppingCartController@removeDiscountFromLink']);
});
