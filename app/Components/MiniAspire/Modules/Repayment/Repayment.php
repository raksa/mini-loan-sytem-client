<?php
namespace App\Components\MiniAspire\Modules\Repayment;

use App\Components\MiniAspire\Modules\Loan\Loan;
use Carbon\Carbon;

/*
 * Author: Raksa Eng
 */
class Repayment
{

    const TABLE_NAME = 'repayments';

    const ID = 'id';
    const LOAN_ID = 'loan_id';
    const AMOUNT = 'amount';
    const PAYMENT_STATUS = 'payment_status';
    const DUE_DATE = 'due_date';
    const DATE_OF_PAYMENT = 'date_of_payment';
    const REMARKS = 'remarks';
    const LAST_UPDATED = 'last_updated';
    const CREATED = 'created';

    public $loan = null;

    public function __construct($data)
    {
        if (isset($data['loan'])) {
            $this->loan = new Loan($data['loan']);
        }
        $this->{self::ID} = $data[self::ID];
        $this->{self::LOAN_ID} = $data[self::LOAN_ID];
        $this->{self::AMOUNT} = $data[self::AMOUNT];
        $this->{self::PAYMENT_STATUS} = $data[self::PAYMENT_STATUS];
        $this->{self::DUE_DATE} = $data[self::DUE_DATE];
        $this->{self::DATE_OF_PAYMENT} = $data[self::DATE_OF_PAYMENT];
        $this->{self::REMARKS} = $data[self::REMARKS];
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
    public function getPaymentStatusId()
    {
        return $this->{self::PAYMENT_STATUS};
    }
    public function getPaymentStatus()
    {
        return RepaymentStatus::getPaymentStatusName($this->getPaymentStatusId());
    }
    public function setPaymentStatusId($statusId)
    {
        $this->{self::PAYMENT_STATUS} = $statusId;
    }
    public function getDueDate()
    {
        return $this->{self::DUE_DATE} ? new Carbon($this->{self::DUE_DATE}) : null;
    }
    public function getDateOfPayment()
    {
        return $this->{self::DATE_OF_PAYMENT} ? new Carbon($this->{self::DATE_OF_PAYMENT}) : null;
    }
    public function getRemarks()
    {
        return $this->{self::REMARKS};
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
