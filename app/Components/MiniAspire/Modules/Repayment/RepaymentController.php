<?php

namespace App\Components\MiniAspire\Modules\Repayment;

use App\Components\MiniAspire\Modules\Loan\Loan;
use App\Components\MiniAspire\Modules\User\User;
use App\Helpers\Util;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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
     * @param \App\Components\MiniAspire\Modules\Loan\Loan::ID $id
     */
    public function getRepayment(Request $request, $id)
    {
        $loan = Loan::getById($bag, $id);
        if ($loan) {
            $user = User::getById($bag, $loan->getUserId());
            return View::make($this->toViewFullPath('get-repayment'), [
                'user' => $user,
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
        $client = new Client();
        $url = config('app.api_url') . "/api/v1/repayments/pay/" . $id;
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->all(),
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
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
