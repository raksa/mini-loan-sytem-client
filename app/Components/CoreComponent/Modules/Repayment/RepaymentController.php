<?php

namespace App\Components\CoreComponent\Modules\Repayment;

use App\Components\CoreComponent\Modules\Client\Client;
use App\Components\CoreComponent\Modules\Loan\Loan;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

// TODO: make repository
/*
 * Author: Raksa Eng
 */
class RepaymentController extends Controller
{
    /**
     * Create loan
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\CoreComponent\Modules\Loan\Loan::id $id
     */
    public function getRepayment(Request $request, $id)
    {
        $request->session()->forget('error');
        $loan = Loan::find($id, $bag);
        if ($loan) {
            $client = Client::find($loan->client_id, $bag);
            return $this->view('get-repayment', [
                'client' => $client,
                'loan' => $loan,
            ]);
        }
        $request->session()->flash('error', $message);
        return $this->view('get-repayment', [
            'loans' => null,
        ]);
    }

    /**
     * Do paying for repayment
     *
     * @param \Illuminate\Http\Request $request
     * @param \Repayment::ID $id
     */
    public function doPayRepayment(Request $request, $id)
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/repayments/pay/" . $id;
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->except('_token'),
            ], 'json'));
            $status = $res->getStatusCode();
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                $repayment = new Repayment($jsonResponse['repayment']);
                return back()->with('success', 'Success for repayment id:' . $repayment->getId());
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during payment';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                if ($res->getStatusCode() == 400) {
                    $body = $res->getBody();
                    $jsonResponse = \json_decode($body->getContents(), true);
                    if ($jsonResponse && isset($jsonResponse['message'])) {
                        $message = $jsonResponse['message'];
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during payment';
        }
        return back()->with('error', $message)->withInput();
    }
}
