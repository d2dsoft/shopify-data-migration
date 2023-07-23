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

namespace PhpOffice\PhpSpreadsheet\Shared;

use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;

class TimeZone
{
    /**
     * Default Timezone used for date/time conversions.
     *
     * @var string
     */
    protected static $timezone = 'UTC';

    /**
     * Validate a Timezone name.
     *
     * @param string $timezoneName Time zone (e.g. 'Europe/London')
     *
     * @return bool Success or failure
     */
    private static function validateTimeZone(string $timezoneName): bool
    {
        return in_array($timezoneName, DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC), true);
    }

    /**
     * Set the Default Timezone used for date/time conversions.
     *
     * @param string $timezoneName Time zone (e.g. 'Europe/London')
     *
     * @return bool Success or failure
     */
    public static function setTimeZone(string $timezoneName): bool
    {
        if (self::validateTimeZone($timezoneName)) {
            self::$timezone = $timezoneName;

            return true;
        }

        return false;
    }

    /**
     * Return the Default Timezone used for date/time conversions.
     *
     * @return string Timezone (e.g. 'Europe/London')
     */
    public static function getTimeZone(): string
    {
        return self::$timezone;
    }

    /**
     *    Return the Timezone offset used for date/time conversions to/from UST
     * This requires both the timezone and the calculated date/time to allow for local DST.
     *
     * @param ?string $timezoneName The timezone for finding the adjustment to UST
     * @param float|int $timestamp PHP date/time value
     *
     * @return int Number of seconds for timezone adjustment
     */
    public static function getTimeZoneAdjustment(?string $timezoneName, $timestamp): int
    {
        $timezoneName = $timezoneName ?? self::$timezone;
        $dtobj = Date::dateTimeFromTimestamp("$timestamp");
        if (!self::validateTimeZone($timezoneName)) {
            throw new PhpSpreadsheetException("Invalid timezone $timezoneName");
        }
        $dtobj->setTimeZone(new DateTimeZone($timezoneName));

        return $dtobj->getOffset();
    }
}