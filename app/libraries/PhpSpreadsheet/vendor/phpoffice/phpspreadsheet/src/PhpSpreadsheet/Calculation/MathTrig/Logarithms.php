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

class Logarithms
{
    use ArrayEnabled;

    /**
     * LOG_BASE.
     *
     * Returns the logarithm of a number to a specified base. The default base is 10.
     *
     * Excel Function:
     *        LOG(number[,base])
     *
     * @param mixed $number The positive real number for which you want the logarithm
     *                      Or can be an array of values
     * @param mixed $base The base of the logarithm. If base is omitted, it is assumed to be 10.
     *                      Or can be an array of values
     *
     * @return array|float|string The result, or a string containing an error
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function withBase($number, $base = 10)
    {
        if (is_array($number) || is_array($base)) {
            return self::evaluateArrayArguments([self::class, __FUNCTION__], $number, $base);
        }

        try {
            $number = Helpers::validateNumericNullBool($number);
            Helpers::validatePositive($number);
            $base = Helpers::validateNumericNullBool($base);
            Helpers::validatePositive($base);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return log($number, $base);
    }

    /**
     * LOG10.
     *
     * Returns the result of builtin function log after validating args.
     *
     * @param mixed $number Should be numeric
     *                      Or can be an array of values
     *
     * @return array|float|string Rounded number
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function base10($number)
    {
        if (is_array($number)) {
            return self::evaluateSingleArgumentArray([self::class, __FUNCTION__], $number);
        }

        try {
            $number = Helpers::validateNumericNullBool($number);
            Helpers::validatePositive($number);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return log10($number);
    }

    /**
     * LN.
     *
     * Returns the result of builtin function log after validating args.
     *
     * @param mixed $number Should be numeric
     *                      Or can be an array of values
     *
     * @return array|float|string Rounded number
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function natural($number)
    {
        if (is_array($number)) {
            return self::evaluateSingleArgumentArray([self::class, __FUNCTION__], $number);
        }

        try {
            $number = Helpers::validateNumericNullBool($number);
            Helpers::validatePositive($number);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return log($number);
    }
}