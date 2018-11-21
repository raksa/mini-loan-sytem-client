<?php
namespace App\Components\MiniAspire\Modules\User;

use Carbon\Carbon;

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

    public function __construct($data)
    {
        $this->{self::ID} = $data[self::ID];
        $this->{self::FIRST_NAME} = $data[self::FIRST_NAME];
        $this->{self::LAST_NAME} = $data[self::LAST_NAME];
        $this->{self::PHONE_NUMBER} = $data[self::PHONE_NUMBER];
        $this->{self::ADDRESS} = $data[self::ADDRESS];
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
}
