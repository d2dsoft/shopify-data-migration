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

abstract class DateTimeWizard implements Wizard
{
    protected const NO_ESCAPING_NEEDED = "$+-/():!^&'~{}<>= ";

    protected function padSeparatorArray(array $separators, int $count): array
    {
        $lastSeparator = array_pop($separators);

        return $separators + array_fill(0, $count, $lastSeparator);
    }

    protected function escapeSingleCharacter(string $value): string
    {
        if (strpos(self::NO_ESCAPING_NEEDED, $value) !== false) {
            return $value;
        }

        return "\\{$value}";
    }

    protected function wrapLiteral(string $value): string
    {
        if (mb_strlen($value, 'UTF-8') === 1) {
            return $this->escapeSingleCharacter($value);
        }

        // Wrap any other string literals in quotes, so that they're clearly defined as string literals
        return '"' . str_replace('"', '""', $value) . '"';
    }

    protected function intersperse(string $formatBlock, ?string $separator): string
    {
        return "{$formatBlock}{$separator}";
    }

    public function __toString(): string
    {
        return $this->format();
    }
}