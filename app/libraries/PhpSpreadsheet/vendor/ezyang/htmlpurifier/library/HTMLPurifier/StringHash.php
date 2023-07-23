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

/**
 * This is in almost every respect equivalent to an array except
 * that it keeps track of which keys were accessed.
 *
 * @warning For the sake of backwards compatibility with early versions
 *     of PHP 5, you must not use the $hash[$key] syntax; if you do
 *     our version of offsetGet is never called.
 */
class HTMLPurifier_StringHash extends ArrayObject
{
    /**
     * @type array
     */
    protected $accessed = array();

    /**
     * Retrieves a value, and logs the access.
     * @param mixed $index
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($index)
    {
        $this->accessed[$index] = true;
        return parent::offsetGet($index);
    }

    /**
     * Returns a lookup array of all array indexes that have been accessed.
     * @return array in form array($index => true).
     */
    public function getAccessed()
    {
        return $this->accessed;
    }

    /**
     * Resets the access array.
     */
    public function resetAccessed()
    {
        $this->accessed = array();
    }
}

// vim: et sw=4 sts=4