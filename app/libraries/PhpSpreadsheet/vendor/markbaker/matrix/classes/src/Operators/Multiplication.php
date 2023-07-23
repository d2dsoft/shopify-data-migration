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

namespace Matrix\Operators;

use Matrix\Matrix;
use \Matrix\Builder;
use Matrix\Exception;
use Throwable;

class Multiplication extends Operator
{
    /**
     * Execute the multiplication
     *
     * @param mixed $value The matrix or numeric value to multiply the current base value by
     * @throws Exception If the provided argument is not appropriate for the operation
     * @return $this The operation object, allowing multiple multiplications to be chained
     **/
    public function execute($value, string $type = 'multiplication'): Operator
    {
        if (is_array($value)) {
            $value = new Matrix($value);
        }

        if (is_object($value) && ($value instanceof Matrix)) {
            return $this->multiplyMatrix($value, $type);
        } elseif (is_numeric($value)) {
            return $this->multiplyScalar($value, $type);
        }

        throw new Exception("Invalid argument for $type");
    }

    /**
     * Execute the multiplication for a scalar
     *
     * @param mixed $value The numeric value to multiply with the current base value
     * @return $this The operation object, allowing multiple mutiplications to be chained
     **/
    protected function multiplyScalar($value, string $type = 'multiplication'): Operator
    {
        try {
            for ($row = 0; $row < $this->rows; ++$row) {
                for ($column = 0; $column < $this->columns; ++$column) {
                    $this->matrix[$row][$column] *= $value;
                }
            }
        } catch (Throwable $e) {
            throw new Exception("Invalid argument for $type");
        }

        return $this;
    }

    /**
     * Execute the multiplication for a matrix
     *
     * @param Matrix $value The numeric value to multiply with the current base value
     * @return $this The operation object, allowing multiple mutiplications to be chained
     * @throws Exception If the provided argument is not appropriate for the operation
     **/
    protected function multiplyMatrix(Matrix $value, string $type = 'multiplication'): Operator
    {
        $this->validateReflectingDimensions($value);

        $newRows = $this->rows;
        $newColumns = $value->columns;
        $matrix = Builder::createFilledMatrix(0, $newRows, $newColumns)
            ->toArray();
        try {
            for ($row = 0; $row < $newRows; ++$row) {
                for ($column = 0; $column < $newColumns; ++$column) {
                    $columnData = $value->getColumns($column + 1)->toArray();
                    foreach ($this->matrix[$row] as $key => $valueData) {
                        $matrix[$row][$column] += $valueData * $columnData[$key][0];
                    }
                }
            }
        } catch (Throwable $e) {
            throw new Exception("Invalid argument for $type");
        }
        $this->matrix = $matrix;

        return $this;
    }
}