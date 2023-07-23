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

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RowRange implements AddressRange
{
    /**
     * @var ?Worksheet
     */
    protected $worksheet;

    /**
     * @var int
     */
    protected $from;

    /**
     * @var int
     */
    protected $to;

    public function __construct(int $from, ?int $to = null, ?Worksheet $worksheet = null)
    {
        $this->validateFromTo($from, $to ?? $from);
        $this->worksheet = $worksheet;
    }

    public static function fromArray(array $array, ?Worksheet $worksheet = null): self
    {
        [$from, $to] = $array;

        return new self($from, $to, $worksheet);
    }

    private function validateFromTo(int $from, int $to): void
    {
        // Identify actual top and bottom values (in case we've been given bottom and top)
        $this->from = min($from, $to);
        $this->to = max($from, $to);
    }

    public function from(): int
    {
        return $this->from;
    }

    public function to(): int
    {
        return $this->to;
    }

    public function rowCount(): int
    {
        return $this->to - $this->from + 1;
    }

    public function shiftRight(int $offset = 1): self
    {
        $newFrom = $this->from + $offset;
        $newFrom = ($newFrom < 1) ? 1 : $newFrom;

        $newTo = $this->to + $offset;
        $newTo = ($newTo < 1) ? 1 : $newTo;

        return new self($newFrom, $newTo, $this->worksheet);
    }

    public function shiftLeft(int $offset = 1): self
    {
        return $this->shiftRight(0 - $offset);
    }

    public function toCellRange(): CellRange
    {
        return new CellRange(
            CellAddress::fromColumnAndRow(Coordinate::columnIndexFromString('A'), $this->from, $this->worksheet),
            CellAddress::fromColumnAndRow(Coordinate::columnIndexFromString(AddressRange::MAX_COLUMN), $this->to)
        );
    }

    public function __toString(): string
    {
        if ($this->worksheet !== null) {
            $title = str_replace("'", "''", $this->worksheet->getTitle());

            return "'{$title}'!{$this->from}:{$this->to}";
        }

        return "{$this->from}:{$this->to}";
    }
}