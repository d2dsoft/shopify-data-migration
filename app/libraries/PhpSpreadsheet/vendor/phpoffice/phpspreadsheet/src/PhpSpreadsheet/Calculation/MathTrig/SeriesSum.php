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
use PhpOffice\PhpSpreadsheet\Calculation\Functions;

class SeriesSum
{
    use ArrayEnabled;

    /**
     * SERIESSUM.
     *
     * Returns the sum of a power series
     *
     * @param mixed $x Input value
     * @param mixed $n Initial power
     * @param mixed $m Step
     * @param mixed[] $args An array of coefficients for the Data Series
     *
     * @return array|float|string The result, or a string containing an error
     */
    public static function evaluate($x, $n, $m, ...$args)
    {
        if (is_array($x) || is_array($n) || is_array($m)) {
            return self::evaluateArrayArgumentsSubset([self::class, __FUNCTION__], 3, $x, $n, $m, ...$args);
        }

        try {
            $x = Helpers::validateNumericNullSubstitution($x, 0);
            $n = Helpers::validateNumericNullSubstitution($n, 0);
            $m = Helpers::validateNumericNullSubstitution($m, 0);

            // Loop through arguments
            $aArgs = Functions::flattenArray($args);
            $returnValue = 0;
            $i = 0;
            foreach ($aArgs as $argx) {
                if ($argx !== null) {
                    $arg = Helpers::validateNumericNullSubstitution($argx, 0);
                    $returnValue += $arg * $x ** ($n + ($m * $i));
                    ++$i;
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $returnValue;
    }
}