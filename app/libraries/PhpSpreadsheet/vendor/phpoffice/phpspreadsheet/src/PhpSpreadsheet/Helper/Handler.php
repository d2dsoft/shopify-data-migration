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

namespace PhpOffice\PhpSpreadsheet\Helper;

class Handler
{
    /** @var string */
    private static $invalidHex = 'Y';

    // A bunch of methods to show that we continue
    // to capture messages even using PhpUnit 10.
    public static function suppressed(): bool
    {
        return @trigger_error('hello');
    }

    public static function deprecated(): string
    {
        return (string) hexdec(self::$invalidHex);
    }

    public static function notice(string $value): void
    {
        date_default_timezone_set($value);
    }

    public static function warning(): bool
    {
        return file_get_contents(__FILE__ . 'noexist') !== false;
    }

    public static function userDeprecated(): bool
    {
        return trigger_error('hello', E_USER_DEPRECATED);
    }

    public static function userNotice(): bool
    {
        return trigger_error('userNotice', E_USER_NOTICE);
    }

    public static function userWarning(): bool
    {
        return trigger_error('userWarning', E_USER_WARNING);
    }
}