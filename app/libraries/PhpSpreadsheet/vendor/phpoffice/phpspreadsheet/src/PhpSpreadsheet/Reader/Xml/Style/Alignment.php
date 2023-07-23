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

namespace PhpOffice\PhpSpreadsheet\Reader\Xml\Style;

use PhpOffice\PhpSpreadsheet\Style\Alignment as AlignmentStyles;
use SimpleXMLElement;

class Alignment extends StyleBase
{
    protected const VERTICAL_ALIGNMENT_STYLES = [
        AlignmentStyles::VERTICAL_BOTTOM,
        AlignmentStyles::VERTICAL_TOP,
        AlignmentStyles::VERTICAL_CENTER,
        AlignmentStyles::VERTICAL_JUSTIFY,
    ];

    protected const HORIZONTAL_ALIGNMENT_STYLES = [
        AlignmentStyles::HORIZONTAL_GENERAL,
        AlignmentStyles::HORIZONTAL_LEFT,
        AlignmentStyles::HORIZONTAL_RIGHT,
        AlignmentStyles::HORIZONTAL_CENTER,
        AlignmentStyles::HORIZONTAL_CENTER_CONTINUOUS,
        AlignmentStyles::HORIZONTAL_JUSTIFY,
    ];

    public function parseStyle(SimpleXMLElement $styleAttributes): array
    {
        $style = [];

        foreach ($styleAttributes as $styleAttributeKey => $styleAttributeValue) {
            $styleAttributeValue = (string) $styleAttributeValue;
            switch ($styleAttributeKey) {
                case 'Vertical':
                    if (self::identifyFixedStyleValue(self::VERTICAL_ALIGNMENT_STYLES, $styleAttributeValue)) {
                        $style['alignment']['vertical'] = $styleAttributeValue;
                    }

                    break;
                case 'Horizontal':
                    if (self::identifyFixedStyleValue(self::HORIZONTAL_ALIGNMENT_STYLES, $styleAttributeValue)) {
                        $style['alignment']['horizontal'] = $styleAttributeValue;
                    }

                    break;
                case 'WrapText':
                    $style['alignment']['wrapText'] = true;

                    break;
                case 'Rotate':
                    $style['alignment']['textRotation'] = $styleAttributeValue;

                    break;
            }
        }

        return $style;
    }
}