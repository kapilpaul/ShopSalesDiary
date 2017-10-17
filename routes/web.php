<?php

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






Route::middleware(['visitors'])->group(function () {

    /* Register Routes */

//    Route::get('/register', 'RegistrationController@register')->name('register');
//    Route::post('/register', 'RegistrationController@postRegister')->name('postRegister');

    /* Login Routes */

    Route::get('/', 'LoginController@login')->name('login');
    Route::post('/login', 'LoginController@postLogin')->name('postLogin');

    /* Activation by email Routes */

    Route::get('/activation/{email}/{activationcode}', 'ActivationController@activateUser');

    /* Forgot Password Routes */

    Route::get('/forgotpassword', 'ForgetPasswordController@forgotPasword')->name('forgotpassword');
    Route::post('/forgotpassword', 'ForgetPasswordController@postForgotPassword')->name('postForgotpassword');

    /* Reset Routes */

    Route::get('/reset/{email}/{code}', 'ForgetPasswordController@resetPassword')->name('resetPassword');
    Route::post('/reset/{email}/{code}', 'ForgetPasswordController@postResetPassword')->name('postResetPassword');

});

Route::middleware('admin')->group(function(){

    Route::get('/index', 'homecontroller@index')->name('home');

    /* Users Controller Routes */

    Route::resource('admin/users', 'AdminUserController');
    Route::post('admin/users/inactive/{id}', 'AdminUserController@inactive');
    Route::post('admin/users/active/{id}', 'AdminUserController@active');


    /* Category Controller Routes */

    Route::resource('admin/category', 'CategoryController');

    Route::get('/deletedcategory/', 'CategoryController@deletedCategory')->name('deletedCategory');
    Route::get('/restoreall-Category/', 'CategoryController@restoreallCategory')->name('restoreallCategory');
    Route::post('/category/{id}/restore', 'CategoryController@restore')->name('restoreCategory');

    /* Products Controller Routes */

    Route::resource('products', 'ProductsController');

    /* Suppliers Controller Routes */

    Route::resource('suppliers', 'SuppliersController');

    /* Brands Controller Routes */

    Route::resource('brands', 'BrandsController');

    /* Brands Controller Routes */

    Route::resource('expenses', 'ExpenseController');
    Route::delete('expenses/deleteall', 'ExpenseController@deleteAll')->name('expenses.deleteall');

    /* Stock Controller Routes */

    Route::resource('stocks', 'StockController');
    Route::get('stocks/find/sellingprice', 'StockController@findSellingPrice')->name('findsellingprice');
    Route::get('stocks/available/items', 'StockController@availableStocks')->name('availableStock');
    Route::get('stocks/{id}/imeis/', 'StockController@imeis')->name('stock.imeis');
    Route::get('stocks/imei/{imei}/edit', 'imeiController@edit')->name('imei.edit');
    Route::patch('stocks/imei/{imei}', 'imeiController@update')->name('imei.update');
    Route::get('stocks-search/', 'StockController@postDataSearch')->name('stocks.search');

    /* Sell Controller Routes */

    Route::delete('sells/{sells}', 'SellsController@destroy')->name('sells.destroy');
    Route::get('sells/currentmonth/sell', 'SellsController@currentMonthSell')->name('currentmonth.sell');
    Route::get('sells/search/monthrange', 'SellsController@searchMonthRange')->name('searchMonthRange.sell');
    Route::post('sells/search/monthrange/', 'SellsController@PostsearchMonthRange')->name('PostsearchMonthRange.sell');


    /* Reports Controller Routes */

    Route::get('reports/sells', 'ReportsController@sells')->name('sellsReport');
    Route::get('reports/expense', 'ReportsController@expense')->name('expenseReport');
    Route::get('reports/sellsVsexpense', 'ReportsController@sellsVsExpense')->name('sellsVsexpenseReport');


});

Route::middleware('adminManager')->group(function(){

    /* Sell Controller Routes */

    Route::get('sells/create/', 'SellsController@create')->name('sells.create');
    Route::get('sells/search', 'SellsController@search')->name('sells.search');
    Route::post('sells/', 'SellsController@store')->name('sells.store');
    Route::get('sells', 'SellsController@index')->name('sells.index');
    Route::get('sells/{sells}/edit', 'SellsController@edit')->name('sells.edit');
    Route::get('sells/{sells}/invoice', 'SellsController@invoice')->name('sells.invoice');
    Route::patch('sells/{sells}', 'SellsController@update')->name('sells.update');
    Route::post('sells/search/customer/', 'SellsController@searchingSells')->name('searchingSells');
    Route::get('sells/invoice/email/{invoice}', 'SellsController@invoiceEmail')->name('invoiceEmail');



});

Route::post('/logout', 'LoginController@logout')->name('logout');

