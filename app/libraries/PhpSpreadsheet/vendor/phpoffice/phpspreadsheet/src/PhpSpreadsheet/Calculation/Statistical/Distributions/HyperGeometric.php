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

namespace PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions;

use PhpOffice\PhpSpreadsheet\Calculation\ArrayEnabled;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Combinations;

class HyperGeometric
{
    use ArrayEnabled;

    /**
     * HYPGEOMDIST.
     *
     * Returns the hypergeometric distribution. HYPGEOMDIST returns the probability of a given number of
     * sample successes, given the sample size, population successes, and population size.
     *
     * @param mixed $sampleSuccesses Integer number of successes in the sample
     *                      Or can be an array of values
     * @param mixed $sampleNumber Integer size of the sample
     *                      Or can be an array of values
     * @param mixed $populationSuccesses Integer number of successes in the population
     *                      Or can be an array of values
     * @param mixed $populationNumber Integer population size
     *                      Or can be an array of values
     *
     * @return array|float|string
     *         If an array of numbers is passed as an argument, then the returned result will also be an array
     *            with the same dimensions
     */
    public static function distribution($sampleSuccesses, $sampleNumber, $populationSuccesses, $populationNumber)
    {
        if (
            is_array($sampleSuccesses) || is_array($sampleNumber) ||
            is_array($populationSuccesses) || is_array($populationNumber)
        ) {
            return self::evaluateArrayArguments(
                [self::class, __FUNCTION__],
                $sampleSuccesses,
                $sampleNumber,
                $populationSuccesses,
                $populationNumber
            );
        }

        try {
            $sampleSuccesses = DistributionValidations::validateInt($sampleSuccesses);
            $sampleNumber = DistributionValidations::validateInt($sampleNumber);
            $populationSuccesses = DistributionValidations::validateInt($populationSuccesses);
            $populationNumber = DistributionValidations::validateInt($populationNumber);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if (($sampleSuccesses < 0) || ($sampleSuccesses > $sampleNumber) || ($sampleSuccesses > $populationSuccesses)) {
            return ExcelError::NAN();
        }
        if (($sampleNumber <= 0) || ($sampleNumber > $populationNumber)) {
            return ExcelError::NAN();
        }
        if (($populationSuccesses <= 0) || ($populationSuccesses > $populationNumber)) {
            return ExcelError::NAN();
        }

        $successesPopulationAndSample = (float) Combinations::withoutRepetition($populationSuccesses, $sampleSuccesses);
        $numbersPopulationAndSample = (float) Combinations::withoutRepetition($populationNumber, $sampleNumber);
        $adjustedPopulationAndSample = (float) Combinations::withoutRepetition(
            $populationNumber - $populationSuccesses,
            $sampleNumber - $sampleSuccesses
        );

        return $successesPopulationAndSample * $adjustedPopulationAndSample / $numbersPopulationAndSample;
    }
}