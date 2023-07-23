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

namespace PhpOffice\PhpSpreadsheet\Calculation\MathTrig;

use PhpOffice\PhpSpreadsheet\Calculation\ArrayEnabled;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class Base
{
    use ArrayEnabled;

    /**
     * BASE.
     *
     * Converts a number into a text representation with the given radix (base).
     *
     * Excel Function:
     *        BASE(Number, Radix [Min_length])
     *
     * @param mixed $number expect float
     *                      Or can be an array of values
     * @param mixed $radix expect float
     *                      Or can be an array of values
     * @param mixed $minLength expect int or null
     *                      Or can be an array of values
     *
     * @return array|string the text representation with the given radix (base)
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function evaluate($number, $radix, $minLength = null)
    {
        if (is_array($number) || is_array($radix) || is_array($minLength)) {
            return self::evaluateArrayArguments([self::class, __FUNCTION__], $number, $radix, $minLength);
        }

        try {
            $number = (float) floor(Helpers::validateNumericNullBool($number));
            $radix = (int) Helpers::validateNumericNullBool($radix);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return self::calculate($number, $radix, $minLength);
    }

    /**
     * @param mixed $minLength
     */
    private static function calculate(float $number, int $radix, $minLength): string
    {
        if ($minLength === null || is_numeric($minLength)) {
            if ($number < 0 || $number >= 2 ** 53 || $radix < 2 || $radix > 36) {
                return ExcelError::NAN(); // Numeric range constraints
            }

            $outcome = strtoupper((string) base_convert("$number", 10, $radix));
            if ($minLength !== null) {
                $outcome = str_pad($outcome, (int) $minLength, '0', STR_PAD_LEFT); // String padding
            }

            return $outcome;
        }

        return ExcelError::VALUE();
    }
}