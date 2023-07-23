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

namespace PhpOffice\PhpSpreadsheet\Calculation\Statistical;

use PhpOffice\PhpSpreadsheet\Calculation\Functions;

abstract class AggregateBase
{
    /**
     * MS Excel does not count Booleans if passed as cell values, but they are counted if passed as literals.
     * OpenOffice Calc always counts Booleans.
     * Gnumeric never counts Booleans.
     *
     * @param mixed $arg
     * @param mixed $k
     *
     * @return int|mixed
     */
    protected static function testAcceptedBoolean($arg, $k)
    {
        if (!is_bool($arg)) {
            return $arg;
        }
        if (Functions::getCompatibilityMode() === Functions::COMPATIBILITY_GNUMERIC) {
            return $arg;
        }
        if (Functions::getCompatibilityMode() === Functions::COMPATIBILITY_OPENOFFICE) {
            return (int) $arg;
        }
        if (!Functions::isCellValue($k)) {
            return (int) $arg;
        }
        /*if (
            (is_bool($arg)) &&
            ((!Functions::isCellValue($k) && (Functions::getCompatibilityMode() === Functions::COMPATIBILITY_EXCEL)) ||
                (Functions::getCompatibilityMode() === Functions::COMPATIBILITY_OPENOFFICE))
        ) {
            $arg = (int) $arg;
        }*/

        return $arg;
    }

    /**
     * @param mixed $arg
     * @param mixed $k
     *
     * @return bool
     */
    protected static function isAcceptedCountable($arg, $k, bool $countNull = false)
    {
        if ($countNull && $arg === null && !Functions::isCellValue($k) && Functions::getCompatibilityMode() !== Functions::COMPATIBILITY_GNUMERIC) {
            return true;
        }
        if (!is_numeric($arg)) {
            return false;
        }
        if (!is_string($arg)) {
            return true;
        }
        if (!Functions::isCellValue($k) && Functions::getCompatibilityMode() === Functions::COMPATIBILITY_OPENOFFICE) {
            return true;
        }
        if (!Functions::isCellValue($k) && Functions::getCompatibilityMode() !== Functions::COMPATIBILITY_GNUMERIC) {
            return true;
        }

        return false;
    }
}