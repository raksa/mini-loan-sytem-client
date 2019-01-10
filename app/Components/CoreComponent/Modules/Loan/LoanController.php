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
    protected function getRequiredData()
    {
        return [
            'clientModelClass' => Client::class,
            'loanModelClass' => Loan::class,
            'repaymentModelClass' => Repayment::class,
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('view', Loan::class);
        $loans = Loan::paginate();
        return $this->view('index', [
            'loans' => $loans,
        ], $this->getRequiredData());
    }
    public function create(Request $request)
    {
        $this->authorize('create', Loan::class);
        $client = Client::find($request->get('client_id'));
        $freqTypes = RepaymentFrequency::getFreqType();
        return $this->view('create', [
            'freqTypes' => $freqTypes,
            'client' => $client,
        ], $this->getRequiredData());
    }
    public function store(Request $request)
    {
        $this->authorize('create', Loan::class);
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
        $this->authorize('view', Loan::class);
        return $this->view('show', [
            'loan' => $loan,
        ], $this->getRequiredData());
    }
    public function edit(Request $request, $id)
    {
        $freqTypes = RepaymentFrequency::getFreqType();
        $loan = Loan::find($id);
        $this->authorize('update', $loan);
        return $this->view('edit', [
            'freqTypes' => $freqTypes,
            'loan' => $loan,
        ], $this->getRequiredData());
    }
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);
        $this->authorize('update', $loan);
        $loan->fill($request->all());
        if ($loan->save()) {
            return redirect()->route('clients.show', $loan->client_id)->withSuccess('loan have been updated');
        }
        return back()->withError("loan can't be updated")->withInput();
    }
    public function destroy(Request $request, $id)
    {
        $loan = Loan::find($id);
        $this->authorize('delete', $loan);
        if ($loan->delete()) {
            return redirect()->route('loans.index')->withSuccess('loan have been deleted');
        }
        return back()->withError("loan can't be deleted");
    }

    public function pay(Request $request, $id)
    {
        $repayment = Repayment::find($id);
        $this->authorize('pay', $repayment);
        if ($repayment->pay()) {
            return back()->withSuccess("repayment id $id has been paid");
        }
        return back()->withError("paid fail for repayment id $id");
    }
}
