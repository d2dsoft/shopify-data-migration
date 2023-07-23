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
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class Variances extends VarianceBase
{
    /**
     * VAR.
     *
     * Estimates variance based on a sample.
     *
     * Excel Function:
     *        VAR(value1[,value2[, ...]])
     *
     * @param mixed ...$args Data values
     *
     * @return float|string (string if result is an error)
     */
    public static function VAR(...$args)
    {
        $returnValue = ExcelError::DIV0();

        $summerA = $summerB = 0.0;

        // Loop through arguments
        $aArgs = Functions::flattenArray($args);
        $aCount = 0;
        foreach ($aArgs as $arg) {
            $arg = self::datatypeAdjustmentBooleans($arg);

            // Is it a numeric value?
            if ((is_numeric($arg)) && (!is_string($arg))) {
                $summerA += ($arg * $arg);
                $summerB += $arg;
                ++$aCount;
            }
        }

        if ($aCount > 1) {
            $summerA *= $aCount;
            $summerB *= $summerB;

            return ($summerA - $summerB) / ($aCount * ($aCount - 1));
        }

        return $returnValue;
    }

    /**
     * VARA.
     *
     * Estimates variance based on a sample, including numbers, text, and logical values
     *
     * Excel Function:
     *        VARA(value1[,value2[, ...]])
     *
     * @param mixed ...$args Data values
     *
     * @return float|string (string if result is an error)
     */
    public static function VARA(...$args)
    {
        $returnValue = ExcelError::DIV0();

        $summerA = $summerB = 0.0;

        // Loop through arguments
        $aArgs = Functions::flattenArrayIndexed($args);
        $aCount = 0;
        foreach ($aArgs as $k => $arg) {
            if ((is_string($arg)) && (Functions::isValue($k))) {
                return ExcelError::VALUE();
            } elseif ((is_string($arg)) && (!Functions::isMatrixValue($k))) {
            } else {
                // Is it a numeric value?
                if ((is_numeric($arg)) || (is_bool($arg)) || ((is_string($arg) && ($arg != '')))) {
                    $arg = self::datatypeAdjustmentAllowStrings($arg);
                    $summerA += ($arg * $arg);
                    $summerB += $arg;
                    ++$aCount;
                }
            }
        }

        if ($aCount > 1) {
            $summerA *= $aCount;
            $summerB *= $summerB;

            return ($summerA - $summerB) / ($aCount * ($aCount - 1));
        }

        return $returnValue;
    }

    /**
     * VARP.
     *
     * Calculates variance based on the entire population
     *
     * Excel Function:
     *        VARP(value1[,value2[, ...]])
     *
     * @param mixed ...$args Data values
     *
     * @return float|string (string if result is an error)
     */
    public static function VARP(...$args)
    {
        // Return value
        $returnValue = ExcelError::DIV0();

        $summerA = $summerB = 0.0;

        // Loop through arguments
        $aArgs = Functions::flattenArray($args);
        $aCount = 0;
        foreach ($aArgs as $arg) {
            $arg = self::datatypeAdjustmentBooleans($arg);

            // Is it a numeric value?
            if ((is_numeric($arg)) && (!is_string($arg))) {
                $summerA += ($arg * $arg);
                $summerB += $arg;
                ++$aCount;
            }
        }

        if ($aCount > 0) {
            $summerA *= $aCount;
            $summerB *= $summerB;

            return ($summerA - $summerB) / ($aCount * $aCount);
        }

        return $returnValue;
    }

    /**
     * VARPA.
     *
     * Calculates variance based on the entire population, including numbers, text, and logical values
     *
     * Excel Function:
     *        VARPA(value1[,value2[, ...]])
     *
     * @param mixed ...$args Data values
     *
     * @return float|string (string if result is an error)
     */
    public static function VARPA(...$args)
    {
        $returnValue = ExcelError::DIV0();

        $summerA = $summerB = 0.0;

        // Loop through arguments
        $aArgs = Functions::flattenArrayIndexed($args);
        $aCount = 0;
        foreach ($aArgs as $k => $arg) {
            if ((is_string($arg)) && (Functions::isValue($k))) {
                return ExcelError::VALUE();
            } elseif ((is_string($arg)) && (!Functions::isMatrixValue($k))) {
            } else {
                // Is it a numeric value?
                if ((is_numeric($arg)) || (is_bool($arg)) || ((is_string($arg) && ($arg != '')))) {
                    $arg = self::datatypeAdjustmentAllowStrings($arg);
                    $summerA += ($arg * $arg);
                    $summerB += $arg;
                    ++$aCount;
                }
            }
        }

        if ($aCount > 0) {
            $summerA *= $aCount;
            $summerB *= $summerB;

            return ($summerA - $summerB) / ($aCount * $aCount);
        }

        return $returnValue;
    }
}