<?php
namespace App\Components\CoreComponent\Modules\Loan;

use App\Components\CoreComponent\Modules\Client\Client;
use App\Components\CoreComponent\Modules\Repayment\Repayment;
use App\Helpers\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

// TODO: make good model pattern
/*
 * Author: Raksa Eng
 */
class Loan
{
    public $id;
    public $client_id;
    public $amount;
    public $duration;
    public $repayment_frequency;
    public $interest_rate;
    public $arrangement_fee;
    public $remarks;
    public $date_contract_start;
    public $date_contract_end;
    public $updated_at;
    public $created_at;

    public $repayments = [];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'amount' => $this->amount,
            'duration' => $this->duration,
            'repayment_frequency' => $this->repayment_frequency,
            'interest_rate' => $this->interest_rate,
            'arrangement_fee' => $this->arrangement_fee,
            'remarks' => $this->remarks,
            'date_contract_start' => $this->date_contract_start . '',
            'date_contract_end' => $this->date_contract_end . '',
            'updated_at' => $this->updated_at . '',
            'created_at' => $this->created_at . '',
        ];
    }

    public function fill($data = [])
    {
        if (isset($data['repayments'])) {
            foreach ($data['repayments'] as $repaymentData) {
                $repayment = new Repayment();
                $repayment->fill($repaymentData);
                $this->repayments[] = $repayment;
            }
        }
        isset($data['id']) && ($this->id = $data['id']);
        $this->client_id = $data['client_id'];
        $this->amount = $data['amount'];
        $this->duration = $data['duration'];
        $this->repayment_frequency = $data['repayment_frequency'];
        $this->interest_rate = $data['interest_rate'];
        $this->arrangement_fee = $data['arrangement_fee'];
        $this->remarks = $data['remarks'];
        if (isset($data['date_contract_start'])) {
            $this->date_contract_start = new Carbon($data['date_contract_start']);
        }
        if (isset($data['date_contract_end'])) {
            $this->date_contract_end = new Carbon($data['date_contract_end']);
        }
        if (isset($data['updated_at'])) {
            $this->updated_at = new Carbon($data['updated_at']);
        }
        if (isset($data['created_at'])) {
            $this->created_at = new Carbon($data['created_at']);
        }
    }

    public static function ofClient($client_id)
    {
        $loan = new self();
        $loan->client_id = $client_id;
        return $loan;
    }
    public function paginate(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'client_id' => $this->client_id,
                    'perPage' => 20,
                    'page' => request()->input('page'),
                ],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            $data = $jsonResponse['data'];
            $loansArray = [];
            foreach ($data as $loanData) {
                $loan = new self();
                $loan->fill($loanData);
                $loansArray[] = $loan;
            }
            $collection = new Collection($loansArray);
            $meta = (array) $jsonResponse['meta'];
            return new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                $meta['current_page'], ['path' => route('loans.index')]);
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
        return new LengthAwarePaginator(new Collection(), 0, 1, null);
    }

    public function save(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/create";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $this->toArray(),
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                $this->fill($jsonResponse['loan']);
                return true;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during payment';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    $message = $jsonResponse['message'];
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during payment';
        }
        $bag['message'] = $message;
        return false;
    }

    public static function find($id, &$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get/" . $id;
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

    public function delete(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/delete/" . $this->id;
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                return true;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during request';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    $response = back()->withError($jsonResponse['message'], []);
                    if (isset($jsonResponse['errors'])) {
                        $errors = new MessageBag();
                        foreach ($jsonResponse['errors'] as $field => $messages) {
                            foreach ($messages as $message) {
                                $errors->add($field, $message);
                            }
                        }
                        $bag['errors'] = $errors;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during request';
        }
        $bag['message'] = $message;
        return false;
    }
}
