<?php
namespace App\Components\CoreComponent\Modules\Repayment;

use App\Helpers\Util;

/*
 * Author: Raksa Eng
 */
class RepaymentFrequency
{
    public static function getFreqType(&$bag = [])
    {
        $guzzleClient = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get_freq_type";
        $message = 'Unknown error';
        try {
            $res = $guzzleClient->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [],
            ], 'json'));
            $body = $res->getBody();
            $jsonResponse = \json_decode($body->getContents(), true);
            return $jsonResponse['types'];
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
        return [];
    }
}
