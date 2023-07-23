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

use Iterator as NativeIterator;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Collection\Cells;

/**
 * @template TKey
 *
 * @implements NativeIterator<TKey, Cell>
 */
abstract class CellIterator implements NativeIterator
{
    public const TREAT_NULL_VALUE_AS_EMPTY_CELL = 1;

    public const TREAT_EMPTY_STRING_AS_EMPTY_CELL = 2;

    public const IF_NOT_EXISTS_RETURN_NULL = false;

    public const IF_NOT_EXISTS_CREATE_NEW = true;

    /**
     * Worksheet to iterate.
     *
     * @var Worksheet
     */
    protected $worksheet;

    /**
     * Cell Collection to iterate.
     *
     * @var Cells
     */
    protected $cellCollection;

    /**
     * Iterate only existing cells.
     *
     * @var bool
     */
    protected $onlyExistingCells = false;

    /**
     * If iterating all cells, and a cell doesn't exist, identifies whether a new cell should be created,
     *    or if the iterator should return a null value.
     *
     * @var bool
     */
    protected $ifNotExists = self::IF_NOT_EXISTS_CREATE_NEW;

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // @phpstan-ignore-next-line
        $this->worksheet = $this->cellCollection = null;
    }

    public function getIfNotExists(): bool
    {
        return $this->ifNotExists;
    }

    public function setIfNotExists(bool $ifNotExists = self::IF_NOT_EXISTS_CREATE_NEW): void
    {
        $this->ifNotExists = $ifNotExists;
    }

    /**
     * Get loop only existing cells.
     */
    public function getIterateOnlyExistingCells(): bool
    {
        return $this->onlyExistingCells;
    }

    /**
     * Validate start/end values for 'IterateOnlyExistingCells' mode, and adjust if necessary.
     */
    abstract protected function adjustForExistingOnlyRange(): void;

    /**
     * Set the iterator to loop only existing cells.
     */
    public function setIterateOnlyExistingCells(bool $value): void
    {
        $this->onlyExistingCells = (bool) $value;

        $this->adjustForExistingOnlyRange();
    }
}