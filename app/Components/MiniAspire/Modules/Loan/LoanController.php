<?php

namespace App\Components\MiniAspire\Modules\Loan;

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
     */
    public function getLoan(Request $request)
    {
        $loans = new LengthAwarePaginator(new Collection(), 0, 1, null);
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get";
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
                    $loan = new Loan();
                    $loan->setProps($loanData);
                    $loansArray[] = $loan;
                }
                $collection = new Collection($loansArray);
                $meta = (array) $jsonResponse->meta;
                $loans = new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                    $meta['current_page'], ['path' => route('player.transaction.trans.history')]);
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
            'loans' => $loans,
        ])->with('error', $message);
    }

    /**
     * Get create loan view
     *
     * @param \Illuminate\Http\Request $request
     */
    public function createLoan(Request $request)
    {
        return View::make($this->toViewFullPath('create-loan'), []);
    }
    /**
     * Do creating loans
     *
     * @param \Illuminate\Http\Request $request
     */
    public function doCreateLoan(Request $request)
    {
        return response()->with('error', 'Create fail', []);
        $client = new Client();
        $url = config('app.api_url') . "/api/v1/loans/create";
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->all(),
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                return back()->with('success', 'Create success', [
                    'loans' => $jsonResponse['loan'],
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
            \Log::error('Creating player');
            \Log::info($url);
            \Log::error($e);
        }
        return back()->with('error', 'Create fail', [])->withInput();
    }
}
