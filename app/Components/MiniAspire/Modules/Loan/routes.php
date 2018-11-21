<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\MiniAspire\Modules\Loan\LoanController";
Route::get('/loans/get', $controller . '@getLoan')->name('loans.get');
Route::get('/loans/crate', $controller . '@createLoan')->name('loans.create');
Route::post('/loans/crate', $controller . '@doCreateLoan')->name('loans.create');
