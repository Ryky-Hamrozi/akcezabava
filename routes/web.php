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

Route::middleware(['auth'])->prefix('admin')->namespace('Admin')->group(function(){
    Route::get('dashboard','AdminController@dashboard');
    Route::resource('district', 'DistrictController');
    Route::post('/getDistrictPlaces', 'DistrictController@getDistrictPlaces')->name('getDistrictPlaces');
    Route::resource('place', 'PlaceController');
    Route::resource('category', 'CategoryController');
    Route::resource('contact', 'ContactController');
    Route::resource('banner', 'BannerController');
    Route::get('event','EventController@index')->name('event.index');
    Route::post('event','EventController@store')->name('event.store');
    Route::put('event/{event}','EventController@update')->name('event.update');
    Route::get('event/for-approval','EventController@forApproval');
    Route::get('event/finished','EventController@finished');
    Route::get('event/upcoming','EventController@upcoming');
    Route::post('approve','EventController@approve')->name('approve');

    Route::post('/getModalContent','AjaxController@getModalContent');
    Route::post('/removeModel','AjaxController@removeModel');
    Route::post('/changePieChart','AjaxController@changePieChart')->name('changePieChart');
    Route::post('/groupAction','AdminController@proceedGroupAction')->name('groupAction');
});

Route::namespace('Front')->group(function(){
    Route::get('/','FrontController@index')->name('home');
    Route::get('/o-nas','FrontController@aboutUs')->name('about-us');
    Route::get('/jak-to-funguje','FrontController@howItWorks')->name('how-it-works');
    Route::get('/reklama-na-webu','FrontController@advertising')->name('advertising');
    Route::post('/zpracuj-reklamu','FrontController@processAdvertising')->name('process-advertising');
    Route::get('/nova-udalost','EventController@create')->name('new-event');
    Route::post('/zpracuj-udalost','EventController@store')->name('process-event');
    Route::get('/uspesne-odeslano','EventController@success')->name('success-event');
    Route::get('/detail-akce/{event}','EventController@detail')->name('detail-event');
});

Route::namespace('Auth')->group(function(){
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::post('login','LoginController@login')->name('processLogin');
});

