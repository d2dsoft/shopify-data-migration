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

use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;

class NewtonRaphson
{
    private const MAX_ITERATIONS = 256;

    /** @var callable */
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /** @return float|string */
    public function execute(float $probability)
    {
        $xLo = 100;
        $xHi = 0;

        $dx = 1;
        $x = $xNew = 1;
        $i = 0;

        while ((abs($dx) > Functions::PRECISION) && ($i++ < self::MAX_ITERATIONS)) {
            // Apply Newton-Raphson step
            $result = call_user_func($this->callback, $x);
            $error = $result - $probability;

            if ($error == 0.0) {
                $dx = 0;
            } elseif ($error < 0.0) {
                $xLo = $x;
            } else {
                $xHi = $x;
            }

            // Avoid division by zero
            if ($result != 0.0) {
                $dx = $error / $result;
                $xNew = $x - $dx;
            }

            // If the NR fails to converge (which for example may be the
            // case if the initial guess is too rough) we apply a bisection
            // step to determine a more narrow interval around the root.
            if (($xNew < $xLo) || ($xNew > $xHi) || ($result == 0.0)) {
                $xNew = ($xLo + $xHi) / 2;
                $dx = $xNew - $x;
            }
            $x = $xNew;
        }

        if ($i == self::MAX_ITERATIONS) {
            return ExcelError::NA();
        }

        return $x;
    }
}