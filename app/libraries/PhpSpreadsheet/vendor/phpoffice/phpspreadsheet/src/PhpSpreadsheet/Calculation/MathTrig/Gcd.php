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

use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class Gcd
{
    /**
     * Recursively determine GCD.
     *
     * Returns the greatest common divisor of a series of numbers.
     * The greatest common divisor is the largest integer that divides both
     *        number1 and number2 without a remainder.
     *
     * Excel Function:
     *        GCD(number1[,number2[, ...]])
     *
     * @param float|int $a
     * @param float|int $b
     *
     * @return float|int
     */
    private static function evaluateGCD($a, $b)
    {
        return $b ? self::evaluateGCD($b, $a % $b) : $a;
    }

    /**
     * GCD.
     *
     * Returns the greatest common divisor of a series of numbers.
     * The greatest common divisor is the largest integer that divides both
     *        number1 and number2 without a remainder.
     *
     * Excel Function:
     *        GCD(number1[,number2[, ...]])
     *
     * @param mixed ...$args Data values
     *
     * @return float|int|string Greatest Common Divisor, or a string containing an error
     */
    public static function evaluate(...$args)
    {
        try {
            $arrayArgs = [];
            foreach (Functions::flattenArray($args) as $value1) {
                if ($value1 !== null) {
                    $value = Helpers::validateNumericNullSubstitution($value1, 1);
                    Helpers::validateNotNegative($value);
                    $arrayArgs[] = (int) $value;
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if (count($arrayArgs) <= 0) {
            return ExcelError::VALUE();
        }
        $gcd = (int) array_pop($arrayArgs);
        do {
            $gcd = self::evaluateGCD($gcd, (int) array_pop($arrayArgs));
        } while (!empty($arrayArgs));

        return $gcd;
    }
}