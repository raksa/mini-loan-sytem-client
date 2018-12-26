<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\CoreComponent\Modules\Repayment\RepaymentController";
Route::get('/repayments/get/{id}', $controller . '@getRepayment')->name('repayments.get');
Route::post('/repayments/pay/{id}', $controller . '@doPayRepayment')->name('repayments.pay');
