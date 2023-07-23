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

namespace PhpOffice\PhpSpreadsheet\Writer\Xls\Style;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CellAlignment
{
    /**
     * @var array<string, int>
     */
    private static $horizontalMap = [
        Alignment::HORIZONTAL_GENERAL => 0,
        Alignment::HORIZONTAL_LEFT => 1,
        Alignment::HORIZONTAL_RIGHT => 3,
        Alignment::HORIZONTAL_CENTER => 2,
        Alignment::HORIZONTAL_CENTER_CONTINUOUS => 6,
        Alignment::HORIZONTAL_JUSTIFY => 5,
    ];

    /**
     * @var array<string, int>
     */
    private static $verticalMap = [
        Alignment::VERTICAL_BOTTOM => 2,
        Alignment::VERTICAL_TOP => 0,
        Alignment::VERTICAL_CENTER => 1,
        Alignment::VERTICAL_JUSTIFY => 3,
    ];

    public static function horizontal(Alignment $alignment): int
    {
        $horizontalAlignment = $alignment->getHorizontal();

        if (is_string($horizontalAlignment) && array_key_exists($horizontalAlignment, self::$horizontalMap)) {
            return self::$horizontalMap[$horizontalAlignment];
        }

        return self::$horizontalMap[Alignment::HORIZONTAL_GENERAL];
    }

    public static function wrap(Alignment $alignment): int
    {
        $wrap = $alignment->getWrapText();

        return ($wrap === true) ? 1 : 0;
    }

    public static function vertical(Alignment $alignment): int
    {
        $verticalAlignment = $alignment->getVertical();

        if (is_string($verticalAlignment) && array_key_exists($verticalAlignment, self::$verticalMap)) {
            return self::$verticalMap[$verticalAlignment];
        }

        return self::$verticalMap[Alignment::VERTICAL_BOTTOM];
    }
}