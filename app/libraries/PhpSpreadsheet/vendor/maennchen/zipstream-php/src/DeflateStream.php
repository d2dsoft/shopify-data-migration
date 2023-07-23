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

namespace ZipStream;

class DeflateStream extends Stream
{
    protected $filter;

    /**
     * @var Option\File
     */
    protected $options;

    /**
     * Rewind stream
     *
     * @return void
     */
    public function rewind(): void
    {
        // deflate filter needs to be removed before rewind
        if ($this->filter) {
            $this->removeDeflateFilter();
            $this->seek(0);
            $this->addDeflateFilter($this->options);
        } else {
            rewind($this->stream);
        }
    }

    /**
     * Remove the deflate filter
     *
     * @return void
     */
    public function removeDeflateFilter(): void
    {
        if (!$this->filter) {
            return;
        }
        stream_filter_remove($this->filter);
        $this->filter = null;
    }

    /**
     * Add a deflate filter
     *
     * @param Option\File $options
     * @return void
     */
    public function addDeflateFilter(Option\File $options): void
    {
        $this->options = $options;
        // parameter 4 for stream_filter_append expects array
        // so we convert the option object in an array
        $optionsArr = [
            'comment' => $options->getComment(),
            'method' => $options->getMethod(),
            'deflateLevel' => $options->getDeflateLevel(),
            'time' => $options->getTime(),
        ];
        $this->filter = stream_filter_append(
            $this->stream,
            'zlib.deflate',
            STREAM_FILTER_READ,
            $optionsArr
        );
    }
}