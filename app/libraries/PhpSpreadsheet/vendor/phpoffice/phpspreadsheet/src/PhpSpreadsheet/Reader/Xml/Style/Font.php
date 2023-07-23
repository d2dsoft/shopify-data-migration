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

use PhpOffice\PhpSpreadsheet\Style\Font as FontUnderline;
use SimpleXMLElement;

class Font extends StyleBase
{
    protected const UNDERLINE_STYLES = [
        FontUnderline::UNDERLINE_NONE,
        FontUnderline::UNDERLINE_DOUBLE,
        FontUnderline::UNDERLINE_DOUBLEACCOUNTING,
        FontUnderline::UNDERLINE_SINGLE,
        FontUnderline::UNDERLINE_SINGLEACCOUNTING,
    ];

    protected function parseUnderline(array $style, string $styleAttributeValue): array
    {
        if (self::identifyFixedStyleValue(self::UNDERLINE_STYLES, $styleAttributeValue)) {
            $style['font']['underline'] = $styleAttributeValue;
        }

        return $style;
    }

    protected function parseVerticalAlign(array $style, string $styleAttributeValue): array
    {
        if ($styleAttributeValue == 'Superscript') {
            $style['font']['superscript'] = true;
        }
        if ($styleAttributeValue == 'Subscript') {
            $style['font']['subscript'] = true;
        }

        return $style;
    }

    public function parseStyle(SimpleXMLElement $styleAttributes): array
    {
        $style = [];

        foreach ($styleAttributes as $styleAttributeKey => $styleAttributeValue) {
            $styleAttributeValue = (string) $styleAttributeValue;
            switch ($styleAttributeKey) {
                case 'FontName':
                    $style['font']['name'] = $styleAttributeValue;

                    break;
                case 'Size':
                    $style['font']['size'] = $styleAttributeValue;

                    break;
                case 'Color':
                    $style['font']['color']['rgb'] = substr($styleAttributeValue, 1);

                    break;
                case 'Bold':
                    $style['font']['bold'] = $styleAttributeValue === '1';

                    break;
                case 'Italic':
                    $style['font']['italic'] = $styleAttributeValue === '1';

                    break;
                case 'Underline':
                    $style = $this->parseUnderline($style, $styleAttributeValue);

                    break;
                case 'VerticalAlign':
                    $style = $this->parseVerticalAlign($style, $styleAttributeValue);

                    break;
            }
        }

        return $style;
    }
}