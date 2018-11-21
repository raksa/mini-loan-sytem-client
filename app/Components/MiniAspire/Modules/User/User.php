<?php
namespace App\Components\MiniAspire\Modules\User;

use App\Components\MiniAspire\Modules\Loan\Loan;
use App\Helpers\Util;
use Carbon\Carbon;
use GuzzleHttp\Client;

/*
 * Author: Raksa Eng
 */
class User
{
    const ID = 'id';
    const USER_CODE = 'user_code'; //special string to make unique identify user
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const PHONE_NUMBER = 'phone_number';
    const ADDRESS = 'address';
    const LAST_UPDATED = 'last_updated';
    const CREATED = 'created';

    public $loans = [];

    public function __construct($data)
    {
        if (isset($data['loans'])) {
            foreach ($data['loans'] as $loanData) {
                $this->loans[] = new Loan($loanData);
            }
        }
        $this->{self::ID} = $data[self::ID];
        $this->{self::USER_CODE} = $data[self::USER_CODE];
        $this->{self::FIRST_NAME} = $data[self::FIRST_NAME];
        $this->{self::LAST_NAME} = $data[self::LAST_NAME];
        $this->{self::PHONE_NUMBER} = $data[self::PHONE_NUMBER];
        $this->{self::ADDRESS} = $data[self::ADDRESS];
        $this->{self::LAST_UPDATED} = $data[self::LAST_UPDATED];
        $this->{self::CREATED} = $data[self::CREATED];
    }

    public function getId()
    {
        return $this->{self::ID};
    }
    public function getUserCode()
    {
        return $this->{self::USER_CODE};
    }
    public function getFirstName()
    {
        return $this->{self::FIRST_NAME};
    }
    public function getLastName()
    {
        return $this->{self::LAST_NAME};
    }
    public function getPhoneNumber()
    {
        return $this->{self::PHONE_NUMBER};
    }
    public function getAddress()
    {
        return $this->{self::ADDRESS};
    }
    public function getLastUpdatedTime()
    {
        return new Carbon($this->{self::LAST_UPDATED});
    }
    public function getCreatedTime()
    {
        return new Carbon($this->{self::CREATED});
    }

    public static function getById(&$bag, $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/users/get/" . $id;
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [],
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                $data = $jsonResponse['data'];
                return new self($data);
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
        $bag = ['message' => $message];
        return null;
    }
}
