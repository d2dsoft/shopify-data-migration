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

namespace PhpOffice\PhpSpreadsheet\Reader\Xls\Style;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CellAlignment
{
    /**
     * @var array<int, string>
     */
    protected static $horizontalAlignmentMap = [
        0 => Alignment::HORIZONTAL_GENERAL,
        1 => Alignment::HORIZONTAL_LEFT,
        2 => Alignment::HORIZONTAL_CENTER,
        3 => Alignment::HORIZONTAL_RIGHT,
        4 => Alignment::HORIZONTAL_FILL,
        5 => Alignment::HORIZONTAL_JUSTIFY,
        6 => Alignment::HORIZONTAL_CENTER_CONTINUOUS,
    ];

    /**
     * @var array<int, string>
     */
    protected static $verticalAlignmentMap = [
        0 => Alignment::VERTICAL_TOP,
        1 => Alignment::VERTICAL_CENTER,
        2 => Alignment::VERTICAL_BOTTOM,
        3 => Alignment::VERTICAL_JUSTIFY,
    ];

    public static function horizontal(Alignment $alignment, int $horizontal): void
    {
        if (array_key_exists($horizontal, self::$horizontalAlignmentMap)) {
            $alignment->setHorizontal(self::$horizontalAlignmentMap[$horizontal]);
        }
    }

    public static function vertical(Alignment $alignment, int $vertical): void
    {
        if (array_key_exists($vertical, self::$verticalAlignmentMap)) {
            $alignment->setVertical(self::$verticalAlignmentMap[$vertical]);
        }
    }

    public static function wrap(Alignment $alignment, int $wrap): void
    {
        $alignment->setWrapText((bool) $wrap);
    }
}