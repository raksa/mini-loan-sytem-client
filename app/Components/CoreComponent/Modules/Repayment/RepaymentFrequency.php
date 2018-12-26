<?php
namespace App\Components\CoreComponent\Modules\Repayment;

/*
 * Author: Raksa Eng
 */
class RepaymentFrequency
{
    const MONTHLY = [
        'id' => 1,
        'name' => 'monthly',
        'description' => 'The most common repayment frequency',
    ];
    const FORTNIGHTLY = [
        'id' => 2,
        'name' => 'fortnightly',
        'description' => 'Fortnightly repayment frequency',
    ];
    const WEEKLY = [
        'id' => 3,
        'name' => 'weekly',
        'description' => 'Weekly repayment frequency',
    ];

    public static function isMonthly($typeId)
    {
        return $typeId == self::MONTHLY['id'];
    }
    public static function isFortnightly($typeId)
    {
        return $typeId == self::FORTNIGHTLY['id'];
    }
    public static function isWeekly($typeId)
    {
        return $typeId == self::WEEKLY['id'];
    }

    public static function getRepaymentFrequencyTypeName($typeId)
    {
        switch ($typeId) {
            case self::MONTHLY['id']:
                return self::MONTHLY['name'];
            case self::FORTNIGHTLY['id']:
                return self::FORTNIGHTLY['name'];
            case self::WEEKLY['id']:
                return self::WEEKLY['name'];
            default:
                return 'Unknown';
        }
    }
}
