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

use PhpOffice\PhpSpreadsheet\Style\Font;

class CellFont
{
    public static function escapement(Font $font, int $escapement): void
    {
        switch ($escapement) {
            case 0x0001:
                $font->setSuperscript(true);

                break;
            case 0x0002:
                $font->setSubscript(true);

                break;
        }
    }

    /**
     * @var array<int, string>
     */
    protected static $underlineMap = [
        0x01 => Font::UNDERLINE_SINGLE,
        0x02 => Font::UNDERLINE_DOUBLE,
        0x21 => Font::UNDERLINE_SINGLEACCOUNTING,
        0x22 => Font::UNDERLINE_DOUBLEACCOUNTING,
    ];

    public static function underline(Font $font, int $underline): void
    {
        if (array_key_exists($underline, self::$underlineMap)) {
            $font->setUnderline(self::$underlineMap[$underline]);
        }
    }
}