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

use DateTimeInterface;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Constants as FinancialConstants;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class Helpers
{
    /**
     * daysPerYear.
     *
     * Returns the number of days in a specified year, as defined by the "basis" value
     *
     * @param int|string $year The year against which we're testing
     * @param int|string $basis The type of day count:
     *                              0 or omitted US (NASD)   360
     *                              1                        Actual (365 or 366 in a leap year)
     *                              2                        360
     *                              3                        365
     *                              4                        European 360
     *
     * @return int|string Result, or a string containing an error
     */
    public static function daysPerYear($year, $basis = 0)
    {
        if (!is_numeric($basis)) {
            return ExcelError::NAN();
        }

        switch ($basis) {
            case FinancialConstants::BASIS_DAYS_PER_YEAR_NASD:
            case FinancialConstants::BASIS_DAYS_PER_YEAR_360:
            case FinancialConstants::BASIS_DAYS_PER_YEAR_360_EUROPEAN:
                return 360;
            case FinancialConstants::BASIS_DAYS_PER_YEAR_365:
                return 365;
            case FinancialConstants::BASIS_DAYS_PER_YEAR_ACTUAL:
                return (DateTimeExcel\Helpers::isLeapYear($year)) ? 366 : 365;
        }

        return ExcelError::NAN();
    }

    /**
     * isLastDayOfMonth.
     *
     * Returns a boolean TRUE/FALSE indicating if this date is the last date of the month
     *
     * @param DateTimeInterface $date The date for testing
     */
    public static function isLastDayOfMonth(DateTimeInterface $date): bool
    {
        return $date->format('d') === $date->format('t');
    }
}