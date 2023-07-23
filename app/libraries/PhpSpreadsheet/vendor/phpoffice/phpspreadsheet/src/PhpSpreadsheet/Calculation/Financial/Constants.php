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

namespace PhpOffice\PhpSpreadsheet\Calculation\Financial;

class Constants
{
    public const BASIS_DAYS_PER_YEAR_NASD = 0;
    public const BASIS_DAYS_PER_YEAR_ACTUAL = 1;
    public const BASIS_DAYS_PER_YEAR_360 = 2;
    public const BASIS_DAYS_PER_YEAR_365 = 3;
    public const BASIS_DAYS_PER_YEAR_360_EUROPEAN = 4;

    public const FREQUENCY_ANNUAL = 1;
    public const FREQUENCY_SEMI_ANNUAL = 2;
    public const FREQUENCY_QUARTERLY = 4;

    public const PAYMENT_END_OF_PERIOD = 0;
    public const PAYMENT_BEGINNING_OF_PERIOD = 1;
}