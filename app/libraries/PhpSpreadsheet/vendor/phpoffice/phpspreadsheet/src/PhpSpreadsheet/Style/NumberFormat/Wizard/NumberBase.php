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

use NumberFormatter;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

abstract class NumberBase
{
    protected const MAX_DECIMALS = 30;

    protected int $decimals = 2;

    protected ?string $locale = null;

    protected ?string $fullLocale = null;

    protected ?string $localeFormat = null;

    public function setDecimals(int $decimals = 2): void
    {
        $this->decimals = ($decimals > self::MAX_DECIMALS) ? self::MAX_DECIMALS : max($decimals, 0);
    }

    /**
     * Setting a locale will override any settings defined in this class.
     *
     * @throws Exception If the locale code is not a valid format
     */
    public function setLocale(?string $locale = null): void
    {
        if ($locale === null) {
            $this->localeFormat = $this->locale = $this->fullLocale = null;

            return;
        }

        $this->locale = $this->validateLocale($locale);

        if (class_exists(NumberFormatter::class)) {
            $this->localeFormat = $this->getLocaleFormat();
        }
    }

    /**
     * Stub: should be implemented as a concrete method in concrete wizards.
     */
    abstract protected function getLocaleFormat(): string;

    /**
     * @throws Exception If the locale code is not a valid format
     */
    private function validateLocale(string $locale): string
    {
        if (preg_match(Locale::STRUCTURE, $locale, $matches, PREG_UNMATCHED_AS_NULL) !== 1) {
            throw new Exception("Invalid locale code '{$locale}'");
        }

        ['language' => $language, 'script' => $script, 'country' => $country] = $matches;
        // Set case and separator to match standardised locale case
        $language = strtolower($language ?? '');
        $script = ($script === null) ? null : ucfirst(strtolower($script));
        $country = ($country === null) ? null : strtoupper($country);

        $this->fullLocale = implode('-', array_filter([$language, $script, $country]));

        return $country === null ? $language : "{$language}-{$country}";
    }

    public function format(): string
    {
        return NumberFormat::FORMAT_GENERAL;
    }

    public function __toString(): string
    {
        return $this->format();
    }
}