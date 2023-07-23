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

namespace PhpOffice\PhpSpreadsheet\Calculation\LookupRef;

use PhpOffice\PhpSpreadsheet\Cell\AddressHelper;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\DefinedName;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Helpers
{
    public const CELLADDRESS_USE_A1 = true;

    public const CELLADDRESS_USE_R1C1 = false;

    private static function convertR1C1(string &$cellAddress1, ?string &$cellAddress2, bool $a1, ?int $baseRow = null, ?int $baseCol = null): string
    {
        if ($a1 === self::CELLADDRESS_USE_R1C1) {
            $cellAddress1 = AddressHelper::convertToA1($cellAddress1, $baseRow ?? 1, $baseCol ?? 1);
            if ($cellAddress2) {
                $cellAddress2 = AddressHelper::convertToA1($cellAddress2, $baseRow ?? 1, $baseCol ?? 1);
            }
        }

        return $cellAddress1 . ($cellAddress2 ? ":$cellAddress2" : '');
    }

    private static function adjustSheetTitle(string &$sheetTitle, ?string $value): void
    {
        if ($sheetTitle) {
            $sheetTitle .= '!';
            if (stripos($value ?? '', $sheetTitle) === 0) {
                $sheetTitle = '';
            }
        }
    }

    public static function extractCellAddresses(string $cellAddress, bool $a1, Worksheet $sheet, string $sheetName = '', ?int $baseRow = null, ?int $baseCol = null): array
    {
        $cellAddress1 = $cellAddress;
        $cellAddress2 = null;
        $namedRange = DefinedName::resolveName($cellAddress1, $sheet, $sheetName);
        if ($namedRange !== null) {
            $workSheet = $namedRange->getWorkSheet();
            $sheetTitle = ($workSheet === null) ? '' : $workSheet->getTitle();
            $value = (string) preg_replace('/^=/', '', $namedRange->getValue());
            self::adjustSheetTitle($sheetTitle, $value);
            $cellAddress1 = $sheetTitle . $value;
            $cellAddress = $cellAddress1;
            $a1 = self::CELLADDRESS_USE_A1;
        }
        if (strpos($cellAddress, ':') !== false) {
            [$cellAddress1, $cellAddress2] = explode(':', $cellAddress);
        }
        $cellAddress = self::convertR1C1($cellAddress1, $cellAddress2, $a1, $baseRow, $baseCol);

        return [$cellAddress1, $cellAddress2, $cellAddress];
    }

    public static function extractWorksheet(string $cellAddress, Cell $cell): array
    {
        $sheetName = '';
        if (strpos($cellAddress, '!') !== false) {
            [$sheetName, $cellAddress] = Worksheet::extractSheetTitle($cellAddress, true);
            $sheetName = trim($sheetName, "'");
        }

        $worksheet = ($sheetName !== '')
            ? $cell->getWorksheet()->getParentOrThrow()->getSheetByName($sheetName)
            : $cell->getWorksheet();

        return [$cellAddress, $worksheet, $sheetName];
    }
}