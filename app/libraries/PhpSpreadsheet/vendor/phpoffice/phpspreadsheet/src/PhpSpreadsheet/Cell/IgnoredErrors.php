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

namespace PhpOffice\PhpSpreadsheet\Cell;

class IgnoredErrors
{
    /** @var bool */
    private $numberStoredAsText = false;

    /** @var bool */
    private $formula = false;

    /** @var bool */
    private $twoDigitTextYear = false;

    /** @var bool */
    private $evalError = false;

    public function setNumberStoredAsText(bool $value): self
    {
        $this->numberStoredAsText = $value;

        return $this;
    }

    public function getNumberStoredAsText(): bool
    {
        return $this->numberStoredAsText;
    }

    public function setFormula(bool $value): self
    {
        $this->formula = $value;

        return $this;
    }

    public function getFormula(): bool
    {
        return $this->formula;
    }

    public function setTwoDigitTextYear(bool $value): self
    {
        $this->twoDigitTextYear = $value;

        return $this;
    }

    public function getTwoDigitTextYear(): bool
    {
        return $this->twoDigitTextYear;
    }

    public function setEvalError(bool $value): self
    {
        $this->evalError = $value;

        return $this;
    }

    public function getEvalError(): bool
    {
        return $this->evalError;
    }
}