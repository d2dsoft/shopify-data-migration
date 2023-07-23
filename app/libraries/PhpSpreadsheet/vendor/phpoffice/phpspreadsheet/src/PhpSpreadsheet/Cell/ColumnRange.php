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

class ColumnRange implements AddressRange
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

    public function __construct(string $from, ?string $to = null, ?Worksheet $worksheet = null)
    {
        $this->validateFromTo(
            Coordinate::columnIndexFromString($from),
            Coordinate::columnIndexFromString($to ?? $from)
        );
        $this->worksheet = $worksheet;
    }

    public static function fromColumnIndexes(int $from, int $to, ?Worksheet $worksheet = null): self
    {
        return new self(Coordinate::stringFromColumnIndex($from), Coordinate::stringFromColumnIndex($to), $worksheet);
    }

    /**
     * @param array<int|string> $array
     */
    public static function fromArray(array $array, ?Worksheet $worksheet = null): self
    {
        array_walk(
            $array,
            function (&$column): void {
                $column = is_numeric($column) ? Coordinate::stringFromColumnIndex((int) $column) : $column;
            }
        );
        /** @var string $from */
        /** @var string $to */
        [$from, $to] = $array;

        return new self($from, $to, $worksheet);
    }

    private function validateFromTo(int $from, int $to): void
    {
        // Identify actual top and bottom values (in case we've been given bottom and top)
        $this->from = min($from, $to);
        $this->to = max($from, $to);
    }

    public function columnCount(): int
    {
        return $this->to - $this->from + 1;
    }

    public function shiftDown(int $offset = 1): self
    {
        $newFrom = $this->from + $offset;
        $newFrom = ($newFrom < 1) ? 1 : $newFrom;

        $newTo = $this->to + $offset;
        $newTo = ($newTo < 1) ? 1 : $newTo;

        return self::fromColumnIndexes($newFrom, $newTo, $this->worksheet);
    }

    public function shiftUp(int $offset = 1): self
    {
        return $this->shiftDown(0 - $offset);
    }

    public function from(): string
    {
        return Coordinate::stringFromColumnIndex($this->from);
    }

    public function to(): string
    {
        return Coordinate::stringFromColumnIndex($this->to);
    }

    public function fromIndex(): int
    {
        return $this->from;
    }

    public function toIndex(): int
    {
        return $this->to;
    }

    public function toCellRange(): CellRange
    {
        return new CellRange(
            CellAddress::fromColumnAndRow($this->from, 1, $this->worksheet),
            CellAddress::fromColumnAndRow($this->to, AddressRange::MAX_ROW)
        );
    }

    public function __toString(): string
    {
        $from = $this->from();
        $to = $this->to();

        if ($this->worksheet !== null) {
            $title = str_replace("'", "''", $this->worksheet->getTitle());

            return "'{$title}'!{$from}:{$to}";
        }

        return "{$from}:{$to}";
    }
}