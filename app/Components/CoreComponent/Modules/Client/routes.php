<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\CoreComponent\Modules\Client\ClientController";
Route::get('/clients/get', $controller . '@getClient')->name('clients.get');
Route::get('/clients/crate', $controller . '@createClient')->name('clients.create');
Route::post('/clients/crate', $controller . '@doCreateClient')->name('clients.create');
