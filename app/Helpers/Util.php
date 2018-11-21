<?php
namespace App\Helpers;

use App\Http\Middleware\AuthenticateAPIOnce;
use Illuminate\Http\Request;

/*
 * Author: Raksa Eng
 */

class Util
{
    /**
     * Get header information for api check
     */
    public static function getHeaderAuthentication(Request $request)
    {
        $auth = '';
        if ($request->header('Authorization')) {
            $auth = $request->header('Authorization');
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
        } else if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } else if (isset($_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'])) {
            $auth = $_SERVER['REDIRECT_REDIRECT_HTTP_AUTHORIZATION'];
        }
        return $auth;
    }

    /**
     * Get api salt key
     */
    public static function getApiSaltKey()
    {
        $salt = config('app.api_salt_key');
        return $salt;
    }

    /**
     * This function help add authorization for api request
     */
    public static function addAPIAuthorizationHash($requestData, $dataIndex = '')
    {
        $salt = config('app.api_salt_key');
        if (!isset($requestData['headers'])) {
            $requestData['headers'] = [];
        }
        $data = isset($requestData[$dataIndex]) ? $requestData[$dataIndex] : [];
        $hash = AuthenticateAPIOnce::dataToTokenHash($data, $salt);
        $requestData['headers']['Authorization'] = AuthenticateAPIOnce::AUTH_HASH_PREFIX . $hash;
        return $requestData;
    }
}
