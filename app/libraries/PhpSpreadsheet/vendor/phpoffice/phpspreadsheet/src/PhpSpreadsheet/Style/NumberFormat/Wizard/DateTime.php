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

namespace PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard;

class DateTime extends DateTimeWizard
{
    /**
     * @var string[]
     */
    protected array $separators;

    /**
     * @var array<DateTimeWizard|string>
     */
    protected array $formatBlocks;

    /**
     * @param null|string|string[] $separators
     *          If you want to use only a single format block, then pass a null as the separator argument
     * @param DateTimeWizard|string ...$formatBlocks
     */
    public function __construct($separators, ...$formatBlocks)
    {
        $this->separators = $this->padSeparatorArray(
            is_array($separators) ? $separators : [$separators],
            count($formatBlocks) - 1
        );
        $this->formatBlocks = array_map([$this, 'mapFormatBlocks'], $formatBlocks);
    }

    /**
     * @param DateTimeWizard|string $value
     */
    private function mapFormatBlocks($value): string
    {
        // Any date masking codes are returned as lower case values
        if (is_object($value)) {
            // We can't explicitly test for Stringable until PHP >= 8.0
            return $value;
        }

        // Wrap any string literals in quotes, so that they're clearly defined as string literals
        return $this->wrapLiteral($value);
    }

    public function format(): string
    {
        return implode('', array_map([$this, 'intersperse'], $this->formatBlocks, $this->separators));
    }
}