<?php
namespace App\Components\CoreComponent\Modules\Client;

use App\Components\CoreComponent\Modules\Loan\Loan;
use App\Helpers\Util;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

// TODO: make delete and update
/*
 * Author: Raksa Eng
 */
class Client
{
    public $id;
    public $client_code;
    public $first_name;
    public $last_name;
    public $phone_number;
    public $address;
    public $updated_at;
    public $created_at;

    public $loans = [];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'client_code' => $this->client_code,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'updated_at' => $this->updated_at . '',
            'created_at' => $this->created_at . '',
        ];
    }

    public function fill($data = [])
    {
        if (isset($data['loans'])) {
            foreach ($data['loans'] as $loanData) {
                $loan = new Loan();
                $loan->fill($loanData);
                $this->loans[] = $loan;
            }
        }
        isset($data['id']) && ($this->id = $data['id']);
        isset($data['client_code']) && ($this->client_code = $data['client_code']);
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone_number = $data['phone_number'];
        $this->address = $data['address'];
        if (isset($data['updated_at'])) {
            $this->updated_at = new Carbon($data['updated_at']);
        }
        if (isset($data['created_at'])) {
            $this->created_at = new Carbon($data['created_at']);
        }
    }

    public static function paginate(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/get";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'perPage' => 5,
                    'page' => request()->input('page'),
                ],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            $data = $jsonResponse['data'];
            $clientsArray = [];
            foreach ($data as $clientData) {
                $client = new Client($clientData);
                $client->fill($clientData);
                $clientsArray[] = $client;
            }
            $collection = new Collection($clientsArray);
            $meta = (array) $jsonResponse['meta'];
            return new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                $meta['current_page'], ['path' => route('clients.index')]);
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
        return new LengthAwarePaginator(new Collection(), 0, 1, null);
    }

    public function save(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/create";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $this->toArray(),
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                $this->fill($jsonResponse['client']);
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

    public static function find($id, &$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/get/" . $id;
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            $data = $jsonResponse['data'];
            $client = new self();
            $client->fill($data);
            return $client;
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
        $url = config('app.api_url') . "/api/v1/clients/delete/" . $this->id;
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
