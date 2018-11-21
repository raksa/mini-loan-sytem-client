<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\MiniAspire\Modules\Loan\LoanController";
Route::get('/loans/get/{id}', $controller . '@getLoan')->name('loans.get');
Route::get('/loans/crate/{id}', $controller . '@createLoan')->name('loans.create');
Route::post('/loans/crate/{id}', $controller . '@doCreateLoan')->name('loans.create');
