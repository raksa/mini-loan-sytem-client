<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\MiniAspire\Modules\Repayment\RepaymentController";
Route::get('/repayments/get', $controller . '@getRepayment')->name('repayments.get');
Route::get('/repayments/crate', $controller . '@createRepayment')->name('repayments.create');
Route::post('/repayments/crate', $controller . '@doCreateRepayment')->name('repayments.create');
