<?php

namespace App\Components\CoreComponent\Modules\Loan;

use App\Components\CoreComponent\Modules\Client\Client;
use App\Components\CoreComponent\Modules\Repayment\Repayment;
use App\Components\CoreComponent\Modules\Repayment\RepaymentFrequency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
 * Author: Raksa Eng
 */
class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::paginate();
        return $this->view('index', [
            'loans' => $loans,
        ]);
    }
    public function create(Request $request)
    {
        $client = Client::find($request->get('client_id'));
        $freqTypes = RepaymentFrequency::getFreqType();
        return $this->view('create', [
            'freqTypes' => $freqTypes,
            'client' => $client,
        ]);
    }
    public function store(Request $request)
    {
        $loan = new Loan();
        $loan->fill($request->except('_token'));
        if ($loan->save()) {
            return redirect()->route('clients.show', $loan->client_id)->withSuccess('new loan have been created');
        }
        return back()->withError("new loan can't be created")->withInput();
    }
    public function show(Request $request, $id)
    {
        $loan = Loan::find($id);
        return $this->view('show', [
            'loan' => $loan,
        ]);
    }
    public function edit(Request $request, $id)
    {
        $freqTypes = RepaymentFrequency::getFreqType();
        $loan = Loan::find($id);
        return $this->view('edit', [
            'freqTypes' => $freqTypes,
            'loan' => $loan,
        ]);
    }
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);
        $loan->fill($request->all());
        if ($loan->save()) {
            return redirect()->route('clients.show', $loan->client_id)->withSuccess('loan have been updated');
        }
        return back()->withError("loan can't be updated")->withInput();
    }
    public function destroy(Request $request, $id)
    {
        $loan = Loan::find($id);
        if ($loan->delete()) {
            return redirect()->route('loans.index')->withSuccess('loan have been deleted');
        }
        return back()->withError("loan can't be deleted");
    }

    public function pay(Request $request, $id)
    {
        if (Repayment::pay($id)) {
            return back()->withSuccess("repayment id $id has been paid");
        }
        return back()->withError("paid fail for repayment id $id");
    }
}
