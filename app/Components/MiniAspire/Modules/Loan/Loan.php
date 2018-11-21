<?php
namespace App\Components\MiniAspire\Modules\Loan;

use App\Components\MiniAspire\Modules\Repayment\Repayment;
use App\Components\MiniAspire\Modules\User\User;
use App\Helpers\Util;
use Carbon\Carbon;

/*
 * Author: Raksa Eng
 */
class Loan
{
    const ID = 'id';
    const USER_ID = 'user_id';
    const AMOUNT = 'amount';
    const DURATION = 'duration';
    const REPAYMENT_FREQUENCY = 'repayment_frequency';
    const INTEREST_RATE = 'interest_rate';
    const ARRANGEMENT_FEE = 'arrangement_fee';
    const REMARKS = 'remarks';
    const DATE_CONTRACT_START = 'date_contract_start';
    const DATE_CONTRACT_END = 'date_contract_end';
    const LAST_UPDATED = 'last_updated';
    const CREATED = 'created';

    public $repayments = [];
    public $user = null;

    public function __construct($data)
    {
        if (isset($data['user'])) {
            $this->user = new User($data['user']);
        }
        if (isset($data['repayments'])) {
            foreach ($data['repayments'] as $repaymentData) {
                $this->repayments[] = new Repayment($repaymentData);
            }
        }
        $this->{self::ID} = $data[self::ID];
        $this->{self::USER_ID} = $data[self::USER_ID];
        $this->{self::AMOUNT} = $data[self::AMOUNT];
        $this->{self::DURATION} = $data[self::DURATION];
        $this->{self::REPAYMENT_FREQUENCY} = $data[self::REPAYMENT_FREQUENCY];
        $this->{self::INTEREST_RATE} = $data[self::INTEREST_RATE];
        $this->{self::ARRANGEMENT_FEE} = $data[self::ARRANGEMENT_FEE];
        $this->{self::REMARKS} = $data[self::REMARKS];
        $this->{self::DATE_CONTRACT_START} = $data[self::DATE_CONTRACT_START];
        $endDate = $this->getDateContractStart()->copy()->addMonth($this->getMonthsDuration());
        $this->{self::DATE_CONTRACT_END} = $endDate;
        $this->{self::LAST_UPDATED} = $data[self::LAST_UPDATED];
        $this->{self::CREATED} = $data[self::CREATED];
    }

    public function getId()
    {
        return $this->{self::ID};
    }
    public function getAmount()
    {
        return $this->{self::AMOUNT};
    }
    public function getMonthsDuration()
    {
        return $this->{self::DURATION};
    }
    public function getRepaymentFrequencyTypeId()
    {
        return $this->{self::REPAYMENT_FREQUENCY};
    }
    public function getMonthlyInterestRate()
    {
        return $this->{self::INTEREST_RATE};
    }
    public function getArrangementFee()
    {
        return $this->{self::ARRANGEMENT_FEE};
    }
    public function getRemarks()
    {
        return $this->{self::REMARKS};
    }
    public function getDateContractStart()
    {
        return new Carbon($this->{self::DATE_CONTRACT_START});
    }
    public function getDateContractEnd()
    {
        return new Carbon($this->{self::DATE_CONTRACT_END});
    }

    public function getLastUpdatedTime()
    {
        return new Carbon($this->{self::LAST_UPDATED});
    }
    public function getCreatedTime()
    {
        return new Carbon($this->{self::CREATED});
    }

    public static function getFreqType(&$bag)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get_freq_type";
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [],
            ], 'json'));
            $status = $res->getStatusCode();
            if ($status == 200) {
                $body = $res->getBody();
                $jsonResponse = \json_decode($body->getContents(), true);
                return $jsonResponse['types'];
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
        return [];
    }

    public static function getById(&$bag, User $user, $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('app.api_url') . "/api/v1/loans/get/" . $user->getId();
        try {
            $res = $client->request('POST', $url, Util::addAPIAuthorizationHash([
                'json' => [
                    'loanId' => $id,
                ],
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
