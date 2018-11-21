<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\MiniAspire\Modules\User\UserController";
Route::get('/users/get', $controller . '@getUser')->name('users.get');
Route::get('/users/crate', $controller . '@createUser')->name('users.create');
Route::post('/users/crate', $controller . '@doCreateUser')->name('users.create');
