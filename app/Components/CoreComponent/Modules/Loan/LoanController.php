<?php

namespace App\Components\CoreComponent\Modules\Loan;

use App\Components\CoreComponent\Modules\Client\Client;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
     * @param \App\Components\CoreComponent\Modules\Client\Client::ID $id
     */
    public function getLoan(Request $request, $id)
    {
        $request->session()->forget('error');
        $client = Client::getById($bag, $id);
        $loans = new LengthAwarePaginator(new Collection(), 0, 1, null);
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get";
        $message = null;
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'clientId' => $id,
                    'perPage' => 20,
                    'page' => $request->input('page'),
                ],
            ], 'json'));
            $status = $res->getStatusCode();
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse) {
                $data = $jsonResponse['data'];
                $loansArray = [];
                foreach ($data as $loanData) {
                    $loansArray[] = new Loan($loanData);
                }
                $collection = new Collection($loansArray);
                $meta = (array) $jsonResponse['meta'];
                $loans = new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                    $meta['current_page'], ['path' => route('loans.get', $id)]);
            } else {
                $message = 'Error with status: ' . $status;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents());
                $message = $jsonResponse['message'];
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = $e->getMessage();
        }
        if ($message) {
            $request->session()->flash('error', 'error');
        }
        return View::make($this->toViewFullPath('get-loan'), [
            'client' => $client,
            'loans' => $loans,
        ]);
    }

    /**
     * Get create loan view
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\CoreComponent\Modules\Client\Client::ID $id
     */
    public function createLoan(Request $request, $id)
    {
        $client = Client::getById($bag, $id);
        if (!$client) {
            $request->session()->flash('error', $bag['message']);
            return View::make($this->toViewFullPath('create-loan'), [
                'client' => null,
            ]);
        }
        $loan = $request->has('loanId') ? Loan::getById($bag, $request->get('loanId')) : null;
        return View::make($this->toViewFullPath('create-loan'), [
            'client' => $client,
            'loan' => $loan,
            'freqTypes' => Loan::getFreqType($bag),
        ]);
    }
    /**
     * Do creating loans
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\CoreComponent\Modules\Client\Client::ID $id
     */
    public function doCreateLoan(Request $request, $id)
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/create";
        try {
            $data = $request->except('_token');
            $data['clientId'] = $id;
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $data,
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                $loan = new Loan($jsonResponse['loan']);
                return redirect()->route('loans.create', [
                    'id' => $id,
                    'loanId' => $loan->getId(),
                ]);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    return back()->with('error', $jsonResponse['message'], [])->withInput();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
        }
        return back()->with('error', 'Create fail')->withInput();
    }
}
