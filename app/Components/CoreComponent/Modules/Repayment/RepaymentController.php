<?php

namespace App\Components\CoreComponent\Modules\Repayment;

use App\Components\CoreComponent\Modules\Client\Client;
use App\Components\CoreComponent\Modules\Loan\Loan;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
 * Author: Raksa Eng
 */
class RepaymentController extends Controller
{
    /**
     * Create loan
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\CoreComponent\Modules\Loan\Loan::ID $id
     */
    public function getRepayment(Request $request, $id)
    {
        $loan = Loan::getById($bag, $id);
        if ($loan) {
            $client = Client::getById($bag, $loan->getClientId());
            return View::make($this->toViewFullPath('get-repayment'), [
                'client' => $client,
                'loan' => $loan,
            ]);
        }
        return View::make($this->toViewFullPath('get-repayment'), [
            'loans' => null,
        ])->with('error', $bag['message']);
    }

    /**
     * Do paying for repayment
     *
     * @param \Illuminate\Http\Request $request
     * @param \Repayment::ID $id
     */
    public function doPayRepayment(Request $request, $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/repayments/pay/" . $id;
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->except('_token'),
            ], 'json'));
            $status = $res->getStatusCode();
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                $repayment = new Repayment($jsonResponse['repayment']);
                return back()->with('success', 'Success for repayment id:' . $repayment->getId());
            }
            $message = 'Fail with status code ' . $status;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                if ($res->getStatusCode() == 400) {
                    $body = $res->getBody();
                    $jsonResponse = \json_decode($body->getContents(), true);
                    $message = $jsonResponse['message'];
                } else {
                    $message = 'Exception occurred during payment';
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during payment';
        }
        return back()->with('error', $message)->withInput();
    }
}
