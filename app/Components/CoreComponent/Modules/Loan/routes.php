<?php
/*
 * Author: Raksa Eng
 */

$controller = "\App\Components\CoreComponent\Modules\Loan\LoanController";
Route::resource('loans', $controller);
Route::post('loans/pay/{id}', $controller . '@pay')->name('loans.pay');
