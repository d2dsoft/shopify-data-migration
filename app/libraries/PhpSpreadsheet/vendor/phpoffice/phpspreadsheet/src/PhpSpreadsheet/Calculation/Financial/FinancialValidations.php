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

namespace PhpOffice\PhpSpreadsheet\Calculation\Financial;

use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Constants as FinancialConstants;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class FinancialValidations
{
    /**
     * @param mixed $date
     */
    public static function validateDate($date): float
    {
        return DateTimeExcel\Helpers::getDateValue($date);
    }

    /**
     * @param mixed $settlement
     */
    public static function validateSettlementDate($settlement): float
    {
        return self::validateDate($settlement);
    }

    /**
     * @param mixed $maturity
     */
    public static function validateMaturityDate($maturity): float
    {
        return self::validateDate($maturity);
    }

    /**
     * @param mixed $value
     */
    public static function validateFloat($value): float
    {
        if (!is_numeric($value)) {
            throw new Exception(ExcelError::VALUE());
        }

        return (float) $value;
    }

    /**
     * @param mixed $value
     */
    public static function validateInt($value): int
    {
        if (!is_numeric($value)) {
            throw new Exception(ExcelError::VALUE());
        }

        return (int) floor((float) $value);
    }

    /**
     * @param mixed $rate
     */
    public static function validateRate($rate): float
    {
        $rate = self::validateFloat($rate);
        if ($rate < 0.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $rate;
    }

    /**
     * @param mixed $frequency
     */
    public static function validateFrequency($frequency): int
    {
        $frequency = self::validateInt($frequency);
        if (
            ($frequency !== FinancialConstants::FREQUENCY_ANNUAL) &&
            ($frequency !== FinancialConstants::FREQUENCY_SEMI_ANNUAL) &&
            ($frequency !== FinancialConstants::FREQUENCY_QUARTERLY)
        ) {
            throw new Exception(ExcelError::NAN());
        }

        return $frequency;
    }

    /**
     * @param mixed $basis
     */
    public static function validateBasis($basis): int
    {
        if (!is_numeric($basis)) {
            throw new Exception(ExcelError::VALUE());
        }

        $basis = (int) $basis;
        if (($basis < 0) || ($basis > 4)) {
            throw new Exception(ExcelError::NAN());
        }

        return $basis;
    }

    /**
     * @param mixed $price
     */
    public static function validatePrice($price): float
    {
        $price = self::validateFloat($price);
        if ($price < 0.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $price;
    }

    /**
     * @param mixed $parValue
     */
    public static function validateParValue($parValue): float
    {
        $parValue = self::validateFloat($parValue);
        if ($parValue < 0.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $parValue;
    }

    /**
     * @param mixed $yield
     */
    public static function validateYield($yield): float
    {
        $yield = self::validateFloat($yield);
        if ($yield < 0.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $yield;
    }

    /**
     * @param mixed $discount
     */
    public static function validateDiscount($discount): float
    {
        $discount = self::validateFloat($discount);
        if ($discount <= 0.0) {
            throw new Exception(ExcelError::NAN());
        }

        return $discount;
    }
}