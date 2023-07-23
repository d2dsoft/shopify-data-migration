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

use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\CashFlowValidations;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Constants as FinancialConstants;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class Cumulative
{
    /**
     * CUMIPMT.
     *
     * Returns the cumulative interest paid on a loan between the start and end periods.
     *
     * Excel Function:
     *        CUMIPMT(rate,nper,pv,start,end[,type])
     *
     * @param mixed $rate The Interest rate
     * @param mixed $periods The total number of payment periods
     * @param mixed $presentValue Present Value
     * @param mixed $start The first period in the calculation.
     *                       Payment periods are numbered beginning with 1.
     * @param mixed $end the last period in the calculation
     * @param mixed $type A number 0 or 1 and indicates when payments are due:
     *                    0 or omitted    At the end of the period.
     *                    1               At the beginning of the period.
     *
     * @return float|string
     */
    public static function interest(
        $rate,
        $periods,
        $presentValue,
        $start,
        $end,
        $type = FinancialConstants::PAYMENT_END_OF_PERIOD
    ) {
        $rate = Functions::flattenSingleValue($rate);
        $periods = Functions::flattenSingleValue($periods);
        $presentValue = Functions::flattenSingleValue($presentValue);
        $start = Functions::flattenSingleValue($start);
        $end = Functions::flattenSingleValue($end);
        $type = ($type === null) ? FinancialConstants::PAYMENT_END_OF_PERIOD : Functions::flattenSingleValue($type);

        try {
            $rate = CashFlowValidations::validateRate($rate);
            $periods = CashFlowValidations::validateInt($periods);
            $presentValue = CashFlowValidations::validatePresentValue($presentValue);
            $start = CashFlowValidations::validateInt($start);
            $end = CashFlowValidations::validateInt($end);
            $type = CashFlowValidations::validatePeriodType($type);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Validate parameters
        if ($start < 1 || $start > $end) {
            return ExcelError::NAN();
        }

        // Calculate
        $interest = 0;
        for ($per = $start; $per <= $end; ++$per) {
            $ipmt = Interest::payment($rate, $per, $periods, $presentValue, 0, $type);
            if (is_string($ipmt)) {
                return $ipmt;
            }

            $interest += $ipmt;
        }

        return $interest;
    }

    /**
     * CUMPRINC.
     *
     * Returns the cumulative principal paid on a loan between the start and end periods.
     *
     * Excel Function:
     *        CUMPRINC(rate,nper,pv,start,end[,type])
     *
     * @param mixed $rate The Interest rate
     * @param mixed $periods The total number of payment periods as an integer
     * @param mixed $presentValue Present Value
     * @param mixed $start The first period in the calculation.
     *                       Payment periods are numbered beginning with 1.
     * @param mixed $end the last period in the calculation
     * @param mixed $type A number 0 or 1 and indicates when payments are due:
     *                    0 or omitted    At the end of the period.
     *                    1               At the beginning of the period.
     *
     * @return float|string
     */
    public static function principal(
        $rate,
        $periods,
        $presentValue,
        $start,
        $end,
        $type = FinancialConstants::PAYMENT_END_OF_PERIOD
    ) {
        $rate = Functions::flattenSingleValue($rate);
        $periods = Functions::flattenSingleValue($periods);
        $presentValue = Functions::flattenSingleValue($presentValue);
        $start = Functions::flattenSingleValue($start);
        $end = Functions::flattenSingleValue($end);
        $type = ($type === null) ? FinancialConstants::PAYMENT_END_OF_PERIOD : Functions::flattenSingleValue($type);

        try {
            $rate = CashFlowValidations::validateRate($rate);
            $periods = CashFlowValidations::validateInt($periods);
            $presentValue = CashFlowValidations::validatePresentValue($presentValue);
            $start = CashFlowValidations::validateInt($start);
            $end = CashFlowValidations::validateInt($end);
            $type = CashFlowValidations::validatePeriodType($type);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // Validate parameters
        if ($start < 1 || $start > $end) {
            return ExcelError::VALUE();
        }

        // Calculate
        $principal = 0;
        for ($per = $start; $per <= $end; ++$per) {
            $ppmt = Payments::interestPayment($rate, $per, $periods, $presentValue, 0, $type);
            if (is_string($ppmt)) {
                return $ppmt;
            }

            $principal += $ppmt;
        }

        return $principal;
    }
}