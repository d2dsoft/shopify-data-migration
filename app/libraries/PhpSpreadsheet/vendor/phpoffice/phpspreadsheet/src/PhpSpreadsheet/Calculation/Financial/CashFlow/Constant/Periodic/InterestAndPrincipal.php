<?php

/**
 * D2dSoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL v3.0) that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL: https://d2d-soft.com/license/AFL.txt
 *
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade this extension/plugin/module to newer version in the future.
 *
 * @author     D2dSoft Developers <developer@d2d-soft.com>
 * @copyright  Copyright (c) 2021 D2dSoft (https://d2d-soft.com)
 * @license    https://d2d-soft.com/license/AFL.txt
 */

namespace PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\Constant\Periodic;

use PhpOffice\PhpSpreadsheet\Calculation\Financial\Constants as FinancialConstants;

class InterestAndPrincipal
{
    /** @var float */
    protected $interest;

    /** @var float */
    protected $principal;

    public function __construct(
        float $rate = 0.0,
        int $period = 0,
        int $numberOfPeriods = 0,
        float $presentValue = 0,
        float $futureValue = 0,
        int $type = FinancialConstants::PAYMENT_END_OF_PERIOD
    ) {
        $payment = Payments::annuity($rate, $numberOfPeriods, $presentValue, $futureValue, $type);
        $capital = $presentValue;
        $interest = 0.0;
        $principal = 0.0;
        for ($i = 1; $i <= $period; ++$i) {
            $interest = ($type === FinancialConstants::PAYMENT_BEGINNING_OF_PERIOD && $i == 1) ? 0 : -$capital * $rate;
            $principal = (float) $payment - $interest;
            $capital += $principal;
        }

        $this->interest = $interest;
        $this->principal = $principal;
    }

    public function interest(): float
    {
        return $this->interest;
    }

    public function principal(): float
    {
        return $this->principal;
    }
}