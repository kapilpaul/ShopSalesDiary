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


use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['visitors'])->group(function () {

    /* Register Routes */

    Route::get('/register', 'RegistrationController@register')->name('register');
    Route::post('/register', 'RegistrationController@postRegister')->name('postRegister');

    /* Login Routes */

    Route::get('/login', 'LoginController@login')->name('login');
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

    Route::get('/index', function () { return view('index'); })->name('home');

    /* Users Controller Routes */

    Route::resource('admin/users', 'AdminUserController');
    Route::post('admin/users/inactive/{id}', 'AdminUserController@inactive');
    Route::post('admin/users/active/{id}', 'AdminUserController@active');


    /* Category Controller Routes */

    Route::resource('admin/category', 'CategoryController');

    /* Products Controller Routes */

    Route::resource('products', 'ProductsController');

    /* Suppliers Controller Routes */

    Route::resource('suppliers', 'SuppliersController');

    /* Brands Controller Routes */

    Route::resource('brands', 'BrandsController');

    /* Stock Controller Routes */

    Route::resource('stocks', 'StockController');



});

Route::get('/logout', 'LoginController@logout')->name('logout');

