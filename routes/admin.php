<?php

Route::get('/home', 'Admin\HomeController@index')->name('home');

/**
 * ROLES
 */
 Route::get('/role/{role}/permissions','Admin\RoleController@permissions');
 Route::get('/rolePermissions','Admin\RoleController@rolePermissions')->name('myrolepermission');
 Route::get('/roles/all','Admin\RoleController@all');
 Route::post('/assignPermission','Admin\RoleController@attachPermission');
 Route::post('/detachPermission','Admin\RoleController@detachPermission');
 Route::resource('/roles','Admin\RoleController');

 /**
  * PERMISSIONs
  */
 Route::get('/permissions/all','Admin\PermissionController@all');
 Route::resource('/permissions','Admin\PermissionController');


 /**
 * ADMINs
 */
Route::get('/profile','Admin\AdminController@profileEdit');
Route::put('/profile/{admin}','Admin\AdminController@profileUpdate');
Route::put('/changepassword/{admin}','Admin\AdminController@changePassword');
Route::put('/administrator/status','Admin\AdminController@switchStatus');
Route::post('/administrator/removeBulk','Admin\AdminController@destroyBulk');
Route::put('/administrator/statusBulk','Admin\AdminController@switchStatusBulk');
Route::resource('/administrator','Admin\AdminController');

/**
 * USERS
 */
Route::put('/user/status','Admin\UserController@switchStatus');
Route::post('/user/removeBulk','Admin\UserController@destroyBulk');
Route::put('/user/statusBulk','Admin\UserController@switchStatusBulk');
Route::get('/user/{id}/cellar','Admin\UserController@showUserCellar');
Route::resource('/user','Admin\UserController');


Route::post('/adddriver','Admin\HomeController@adddriver');
Route::get('/deldriver/{id}/','Admin\HomeController@deldriver');
Route::post('/editdriver','Admin\HomeController@editdriver');
Route::get('/driver', 'Admin\HomeController@driver');
Route::get('/passenger', 'Admin\HomeController@passenger');

Route::post('/addpassenger','Admin\HomeController@addpassenger');
Route::get('/delpassenger/{id}','Admin\HomeController@delpassenger');


Route::post('/addtour','Admin\HomeController@addtour');
Route::get('/deltour/{id}/','Admin\HomeController@deltour');
Route::get('/tour', 'Admin\HomeController@tour');

Route::post('/addpt','Admin\HomeController@addpt');
Route::get('/delpt/{id}/','Admin\HomeController@delpt');
Route::get('/today', 'Admin\HomeController@today');

Route::get('/push', 'Admin\HomeController@push');