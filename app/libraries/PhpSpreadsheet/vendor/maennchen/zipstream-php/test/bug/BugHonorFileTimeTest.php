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

declare(strict_types=1);

namespace BugHonorFileTimeTest;

use DateTime;

use function fopen;

use PHPUnit\Framework\TestCase;
use ZipStream\Option\Archive;
use ZipStream\Option\File;

use ZipStream\ZipStream;

/**
 * Asserts that specified last-modified timestamps are not overwritten when a
 * file is added
 */
class BugHonorFileTimeTest extends TestCase
{
    public function testHonorsFileTime(): void
    {
        $archiveOpt = new Archive();
        $fileOpt = new File();
        $expectedTime = new DateTime('2019-04-21T19:25:00-0800');

        $archiveOpt->setOutputStream(fopen('php://memory', 'wb'));
        $fileOpt->setTime(clone $expectedTime);

        $zip = new ZipStream(null, $archiveOpt);

        $zip->addFile('sample.txt', 'Sample', $fileOpt);

        $zip->finish();

        $this->assertEquals($expectedTime, $fileOpt->getTime());
    }
}