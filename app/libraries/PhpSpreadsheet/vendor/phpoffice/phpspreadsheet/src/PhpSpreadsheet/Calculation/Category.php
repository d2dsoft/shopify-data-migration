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

namespace PhpOffice\PhpSpreadsheet\Calculation;

abstract class Category
{
    // Function categories
    const CATEGORY_CUBE = 'Cube';
    const CATEGORY_DATABASE = 'Database';
    const CATEGORY_DATE_AND_TIME = 'Date and Time';
    const CATEGORY_ENGINEERING = 'Engineering';
    const CATEGORY_FINANCIAL = 'Financial';
    const CATEGORY_INFORMATION = 'Information';
    const CATEGORY_LOGICAL = 'Logical';
    const CATEGORY_LOOKUP_AND_REFERENCE = 'Lookup and Reference';
    const CATEGORY_MATH_AND_TRIG = 'Math and Trig';
    const CATEGORY_STATISTICAL = 'Statistical';
    const CATEGORY_TEXT_AND_DATA = 'Text and Data';
    const CATEGORY_WEB = 'Web';
    const CATEGORY_UNCATEGORISED = 'Uncategorised';
}