<?php

namespace App\Components\CoreComponent\Modules\Client;

use App\Helpers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;

/*
 * Author: Raksa Eng
 */
class ClientController extends Controller
{
    /**
     * Create client
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getClient(Request $request)
    {
        $request->session()->forget('error');
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/get";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'perPage' => 5,
                    'page' => $request->input('page'),
                ],
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                $data = $jsonResponse['data'];
                $clientsArray = [];
                foreach ($data as $clientData) {
                    $clientsArray[] = new Client($clientData);
                }
                $collection = new Collection($clientsArray);
                $meta = (array) $jsonResponse['meta'];
                $clients = new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                    $meta['current_page'], ['path' => route('clients.get')]);
                return $this->view('get-client', [
                    'clients' => $clients,
                ]);
            }
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
        $request->session()->flash('error', $message);
        return $this->view('get-client', [
            'clients' => new LengthAwarePaginator(new Collection(), 0, 1, null),
        ]);
    }

    /**
     * Get create client view
     *
     * @param \Illuminate\Http\Request $request
     */
    public function createClient(Request $request)
    {
        return $this->view('create-client');
    }
    /**
     * Do creating clients
     *
     * @param \Illuminate\Http\Request $request
     */
    public function doCreateClient(Request $request)
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/create";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->except('_token'),
            ], 'json'));
            $status = $res->getStatusCode();
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            if ($jsonResponse && $jsonResponse["status"] == "success") {
                return $this->view('create-client', [
                    'client' => new Client($jsonResponse['client']),
                ]);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $message = 'Exception occurred during request';
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                if ($jsonResponse && isset($jsonResponse['message'])) {
                    $response = back()->with('error', $jsonResponse['message'], []);
                    if (isset($jsonResponse['errors'])) {
                        $errors = new MessageBag();
                        foreach ($jsonResponse['errors'] as $field => $messages) {
                            foreach ($messages as $message) {
                                $errors->add($field, $message);
                            }
                        }
                        $response->withErrors($errors);
                    }
                    return $response->withInput();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $message = 'Exception occurred during request';
        }
        return back()->with('error', $message)->withInput();
    }
}
