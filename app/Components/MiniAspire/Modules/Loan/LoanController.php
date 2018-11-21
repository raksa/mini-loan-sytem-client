<?php

namespace App\Components\MiniAspire\Modules\Loan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
 * Author: Raksa Eng
 */
class LoanController extends Controller
{
    /**
     * Create loan
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getLoan(Request $request)
    {
        return View::make($this->toViewFullPath('get-loan'), []);
    }

    /**
     * Get loans
     *
     * @param \Illuminate\Http\Request $request
     */
    public function createLoan(Request $request)
    {
        return response()->with('success', 'Created');
    }
}
