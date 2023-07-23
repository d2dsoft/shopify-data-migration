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

namespace ZipStream\Option;

use DateTime;
use DateTimeInterface;

final class File
{
    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var Method
     */
    private $method;

    /**
     * @var int
     */
    private $deflateLevel;

    /**
     * @var DateTimeInterface
     */
    private $time;

    /**
     * @var int
     */
    private $size = 0;

    public function defaultTo(Archive $archiveOptions): void
    {
        $this->deflateLevel = $this->deflateLevel ?: $archiveOptions->getDeflateLevel();
        $this->time = $this->time ?: new DateTime();
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return Method
     */
    public function getMethod(): Method
    {
        return $this->method ?: Method::DEFLATE();
    }

    /**
     * @param Method $method
     */
    public function setMethod(Method $method): void
    {
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getDeflateLevel(): int
    {
        return $this->deflateLevel ?: Archive::DEFAULT_DEFLATE_LEVEL;
    }

    /**
     * @param int $deflateLevel
     */
    public function setDeflateLevel(int $deflateLevel): void
    {
        $this->deflateLevel = $deflateLevel;
    }

    /**
     * @return DateTimeInterface
     */
    public function getTime(): DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @param DateTimeInterface $time
     */
    public function setTime(DateTimeInterface $time): void
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}