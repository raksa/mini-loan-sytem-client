<?php

namespace App\Components\MiniAspire\Modules\User;

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
class UserController extends Controller
{
    /**
     * Create user
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getUser(Request $request)
    {
        $users = new LengthAwarePaginator(new Collection(), 0, 1, null);
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/users/get";
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
                $usersArray = [];
                foreach ($data as $userData) {
                    $usersArray[] = new User($userData);
                }
                $collection = new Collection($usersArray);
                $meta = (array) $jsonResponse['meta'];
                $users = new LengthAwarePaginator($collection, $meta['total'], $meta['per_page'],
                    $meta['current_page'], ['path' => route('users.get')]);
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
        return View::make($this->toViewFullPath('get-user'), [
            'users' => $users,
        ])->with('error', $message);
    }

    /**
     * Get create user view
     *
     * @param \Illuminate\Http\Request $request
     */
    public function createUser(Request $request)
    {
        return View::make($this->toViewFullPath('create-user'), []);
    }
    /**
     * Do creating users
     *
     * @param \Illuminate\Http\Request $request
     */
    public function doCreateUser(Request $request)
    {
        $client = new Client();
        $url = config('app.api_url') . "/api/v1/users/create";
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => $request->all(),
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                return View::make($this->toViewFullPath('create-user'), [
                    'user' => new User($jsonResponse['user']),
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
