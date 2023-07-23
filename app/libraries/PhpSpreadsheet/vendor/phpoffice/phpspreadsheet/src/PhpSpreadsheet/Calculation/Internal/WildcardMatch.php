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

namespace PhpOffice\PhpSpreadsheet\Calculation\Internal;

class WildcardMatch
{
    private const SEARCH_SET = [
        '~~', // convert double tilde to unprintable value
        '~\\*', // convert tilde backslash asterisk to [*] (matches literal asterisk in regexp)
        '\\*', // convert backslash asterisk to .* (matches string of any length in regexp)
        '~\\?', // convert tilde backslash question to [?] (matches literal question mark in regexp)
        '\\?', // convert backslash question to . (matches one character in regexp)
        "\x1c", // convert original double tilde to single tilde
    ];

    private const REPLACEMENT_SET = [
        "\x1c",
        '[*]',
        '.*',
        '[?]',
        '.',
        '~',
    ];

    public static function wildcard(string $wildcard): string
    {
        // Preg Escape the wildcard, but protecting the Excel * and ? search characters
        return str_replace(self::SEARCH_SET, self::REPLACEMENT_SET, preg_quote($wildcard, '/'));
    }

    public static function compare(?string $value, string $wildcard): bool
    {
        if ($value === '' || $value === null) {
            return false;
        }

        return (bool) preg_match("/^{$wildcard}\$/mui", $value);
    }
}