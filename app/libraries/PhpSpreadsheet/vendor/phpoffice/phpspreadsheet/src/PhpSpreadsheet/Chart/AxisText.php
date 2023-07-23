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

namespace PhpOffice\PhpSpreadsheet\Chart;

use PhpOffice\PhpSpreadsheet\Style\Font;

class AxisText extends Properties
{
    /** @var ?int */
    private $rotation;

    /** @var Font */
    private $font;

    public function __construct()
    {
        parent::__construct();
        $this->font = new Font();
        $this->font->setSize(null, true);
    }

    public function setRotation(?int $rotation): self
    {
        $this->rotation = $rotation;

        return $this;
    }

    public function getRotation(): ?int
    {
        return $this->rotation;
    }

    public function getFillColorObject(): ChartColor
    {
        $fillColor = $this->font->getChartColor();
        if ($fillColor === null) {
            $fillColor = new ChartColor();
            $this->font->setChartColorFromObject($fillColor);
        }

        return $fillColor;
    }

    public function getFont(): Font
    {
        return $this->font;
    }

    public function setFont(Font $font): self
    {
        $this->font = $font;

        return $this;
    }
}