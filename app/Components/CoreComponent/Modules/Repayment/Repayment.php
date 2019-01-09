<?php
namespace App\Components\CoreComponent\Modules\Repayment;

use App\Components\CoreComponent\Modules\Loan\Loan;
use App\Helpers\Util;
use Carbon\Carbon;
use Illuminate\Support\Collection;

// TODO: make good model pattern
/*
 * Author: Raksa Eng
 */
class Repayment
{
    public $id;
    public $loan_id;
    public $amount;
    public $payment_status;
    public $due_date;
    public $date_of_payment;
    public $remarks;
    public $updated_at;
    public $created_at;

    public $loan = null;

    public function fill($data)
    {
        if (isset($data['loan'])) {
            $loan = new Loan();
            $loan->fill($data['loan']);
            $this->loan = $loan;
        }
        isset($data['id']) && ($this->id = $data['id']);
        $this->loan_id = $data['loan_id'];
        $this->amount = $data['amount'];
        $this->payment_status = RepaymentStatus::getPaymentStatusName($data['payment_status']);
        $this->due_date = $data['due_date'];
        $this->date_of_payment = $data['date_of_payment'];
        $this->remarks = $data['remarks'];
        if (isset($data['updated_at'])) {
            $this->updated_at = new Carbon($data['updated_at']);
        }
        if (isset($data['created_at'])) {
            $this->created_at = new Carbon($data['created_at']);
        }
    }

    public static function find($id, &$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/repayments/get/" . $id;
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            $data = $jsonResponse['data'];
            $loan = new self();
            $loan->fill($data);
            return $loan;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during payment';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents());
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    $message = $jsonResponse['message'];
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during payment';
        }
        $bag = ['message' => $message];
        return null;
    }

    public static function pay($repaymentId)
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/repayments/pay/" . $repaymentId;
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            return $jsonResponse && $jsonResponse["status"] == "success";
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
        $bag['message'] = $message;
        return false;
    }

    public static function ofClient($loan_id)
    {
        $repayment = new self();
        $repayment->loan_id = $loan_id;
        return $repayment;
    }
    public function get(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/repayments/get";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'loan_id' => $this->loan_id,
                ],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            $data = $jsonResponse['data'];
            $loansArray = [];
            foreach ($data as $loanData) {
                $repayment = new self();
                $repayment->fill($loanData);
                $loansArray[] = $repayment;
            }
            return new Collection($loansArray);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during payment';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents());
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    $message = $jsonResponse['message'];
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during payment';
        }
        $bag['message'] = $message;
        return new Collection();
    }
}
