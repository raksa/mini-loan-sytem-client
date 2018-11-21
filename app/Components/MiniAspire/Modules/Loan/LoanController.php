<?php

namespace App\Components\MiniAspire\Modules\Loan;

use App\Components\MiniAspire\Modules\User\User;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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
     * @param \App\Components\MiniAspire\Modules\User\User::ID $id
     */
    public function getLoan(Request $request, $id)
    {
        $request->session()->forget('error');
        $user = User::getById($bag, $id);
        if (!$user) {
            $request->session()->flash('error', $bag['message']);
            return View::make($this->toViewFullPath('get-loan'), [
                'user' => null,
            ]);
        }
        $loans = new LengthAwarePaginator(new Collection(), 0, 1, null);
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get/" . $id;
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'perPage' => 20,
                    'page' => $request->input('page'),
                ],
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                $data = $jsonResponse['data'];
                $loansArray = [];
                foreach ($data as $loanData) {
                    $loansArray[] = new Loan($loanData);
                }
                $collection = new Collection($loansArray);
                $meta = (array) $jsonResponse['meta'];
                $loans = new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                    $meta['current_page'], ['path' => route('loans.get', $id)]);
            }
            $message = 'Error with status: ' . $status;
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
        return View::make($this->toViewFullPath('get-loan'), [
            'user' => $user,
            'loans' => $loans,
        ])->with('error', $message);
    }

    /**
     * Get create loan view
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\MiniAspire\Modules\User\User::ID $id
     */
    public function createLoan(Request $request, $id)
    {
        $request->session()->forget('error');
        $user = User::getById($bag, $id);
        if (!$user) {
            $request->session()->flash('error', $bag['message']);
            return View::make($this->toViewFullPath('create-loan'), [
                'user' => null,
            ]);
        }
        return View::make($this->toViewFullPath('create-loan'), [
            'user' => $user,
            'freqTypes' => Loan::getFreqType($bag),
        ]);
    }
    /**
     * Do creating loans
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\MiniAspire\Modules\User\User::ID $id
     */
    public function doCreateLoan(Request $request, $id)
    {
        $client = new Client();
        $url = config('app.api_url') . "/api/v1/loans/create/" . $id;
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->all(),
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                return View::make($this->toViewFullPath('create-loan'), [
                    'loan' => new Loan($jsonResponse['loan']),
                ]);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                if ($res->getStatusCode() == 400) {
                    $body = $res->getBody();
                    $jsonResponse = \json_decode($body->getContents(), true);
                    return back()->with('error', $jsonResponse['message'], [])->withInput();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
        }
        return back()->with('error', 'Create fail', [])->withInput();
    }
}
