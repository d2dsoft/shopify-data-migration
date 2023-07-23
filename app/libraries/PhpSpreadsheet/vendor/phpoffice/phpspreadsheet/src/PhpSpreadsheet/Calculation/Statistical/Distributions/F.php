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

namespace PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions;

use PhpOffice\PhpSpreadsheet\Calculation\ArrayEnabled;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class F
{
    use ArrayEnabled;

    /**
     * F.DIST.
     *
     *    Returns the F probability distribution.
     *    You can use this function to determine whether two data sets have different degrees of diversity.
     *    For example, you can examine the test scores of men and women entering high school, and determine
     *        if the variability in the females is different from that found in the males.
     *
     * @param mixed $value Float value for which we want the probability
     *                      Or can be an array of values
     * @param mixed $u The numerator degrees of freedom as an integer
     *                      Or can be an array of values
     * @param mixed $v The denominator degrees of freedom as an integer
     *                      Or can be an array of values
     * @param mixed $cumulative Boolean value indicating if we want the cdf (true) or the pdf (false)
     *                      Or can be an array of values
     *
     * @return array|float|string
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function distribution($value, $u, $v, $cumulative)
    {
        if (is_array($value) || is_array($u) || is_array($v) || is_array($cumulative)) {
            return self::evaluateArrayArguments([self::class, __FUNCTION__], $value, $u, $v, $cumulative);
        }

        try {
            $value = DistributionValidations::validateFloat($value);
            $u = DistributionValidations::validateInt($u);
            $v = DistributionValidations::validateInt($v);
            $cumulative = DistributionValidations::validateBool($cumulative);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if ($value < 0 || $u < 1 || $v < 1) {
            return ExcelError::NAN();
        }

        if ($cumulative) {
            $adjustedValue = ($u * $value) / ($u * $value + $v);

            return Beta::incompleteBeta($adjustedValue, $u / 2, $v / 2);
        }

        return (Gamma::gammaValue(($v + $u) / 2) /
                (Gamma::gammaValue($u / 2) * Gamma::gammaValue($v / 2))) *
            (($u / $v) ** ($u / 2)) *
            (($value ** (($u - 2) / 2)) / ((1 + ($u / $v) * $value) ** (($u + $v) / 2)));
    }
}