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

namespace PhpOffice\PhpSpreadsheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Cell\CellAddress;
use PhpOffice\PhpSpreadsheet\Cell\CellRange;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class AutoFit
{
    protected Worksheet $worksheet;

    public function __construct(Worksheet $worksheet)
    {
        $this->worksheet = $worksheet;
    }

    public function getAutoFilterIndentRanges(): array
    {
        $autoFilterIndentRanges = [];
        $autoFilterIndentRanges[] = $this->getAutoFilterIndentRange($this->worksheet->getAutoFilter());

        foreach ($this->worksheet->getTableCollection() as $table) {
            /** @var Table $table */
            if ($table->getShowHeaderRow() === true && $table->getAllowFilter() === true) {
                $autoFilter = $table->getAutoFilter();
                if ($autoFilter !== null) {
                    $autoFilterIndentRanges[] = $this->getAutoFilterIndentRange($autoFilter);
                }
            }
        }

        return array_filter($autoFilterIndentRanges);
    }

    private function getAutoFilterIndentRange(AutoFilter $autoFilter): ?string
    {
        $autoFilterRange = $autoFilter->getRange();
        $autoFilterIndentRange = null;

        if (!empty($autoFilterRange)) {
            $autoFilterRangeBoundaries = Coordinate::rangeBoundaries($autoFilterRange);
            $autoFilterIndentRange = (string) new CellRange(
                CellAddress::fromColumnAndRow($autoFilterRangeBoundaries[0][0], $autoFilterRangeBoundaries[0][1]),
                CellAddress::fromColumnAndRow($autoFilterRangeBoundaries[1][0], $autoFilterRangeBoundaries[0][1])
            );
        }

        return $autoFilterIndentRange;
    }
}