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
        $clients = new LengthAwarePaginator(new Collection(), 0, 1, null);
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/get";
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
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
        return View::make($this->toViewFullPath('get-client'), [
            'clients' => $clients,
        ])->with('error', $message);
    }

    /**
     * Get create client view
     *
     * @param \Illuminate\Http\Request $request
     */
    public function createClient(Request $request)
    {
        return View::make($this->toViewFullPath('create-client'), []);
    }
    /**
     * Do creating clients
     *
     * @param \Illuminate\Http\Request $request
     */
    public function doCreateClient(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/clients/create";
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->all(),
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                return View::make($this->toViewFullPath('create-client'), [
                    'client' => new Client($jsonResponse['client']),
                ]);
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
                if ($res->getStatusCode() == 400) {
                    $body = $res->getBody();
                    $jsonResponse = \json_decode($body->getContents(), true);
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
        }
        return back()->with('error', 'Create fail', [])->withInput();
    }
}