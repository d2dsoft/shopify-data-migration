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

use Complex\Complex as Complex;

include(__DIR__ . '/../vendor/autoload.php');

echo 'Create', PHP_EOL;

$x = new Complex(123);
echo $x, PHP_EOL;

$x = new Complex(123, 456);
echo $x, PHP_EOL;

$x = new Complex(array(123,456,'j'));
echo $x, PHP_EOL;

$x = new Complex('1.23e-4--2.34e-5i');
echo $x, PHP_EOL;


echo PHP_EOL, 'Add', PHP_EOL;

$x = new Complex(123);
$x->add(456);
echo $x, PHP_EOL;

$x = new Complex(123.456);
$x->add(789.012);
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->add(new Complex(-987.654, -32.1));
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->add(-987.654);
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->add(new Complex(0, 1));
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->add(new Complex(0, -1));
echo $x, PHP_EOL;


echo PHP_EOL, 'Subtract', PHP_EOL;

$x = new Complex(123);
$x->subtract(456);
echo $x, PHP_EOL;

$x = new Complex(123.456);
$x->subtract(789.012);
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->subtract(new Complex(-987.654, -32.1));
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->subtract(-987.654);
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->subtract(new Complex(0, 1));
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->subtract(new Complex(0, -1));
echo $x, PHP_EOL;


echo PHP_EOL, 'Multiply', PHP_EOL;

$x = new Complex(123);
$x->multiply(456);
echo $x, PHP_EOL;

$x = new Complex(123.456);
$x->multiply(789.012);
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->multiply(new Complex(-987.654, -32.1));
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->multiply(-987.654);
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->multiply(new Complex(0, 1));
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->multiply(new Complex(0, -1));
echo $x, PHP_EOL;


echo PHP_EOL, 'Divide By', PHP_EOL;

$x = new Complex(123);
$x->divideBy(456);
echo $x, PHP_EOL;

$x = new Complex(123.456);
$x->divideBy(789.012);
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->divideBy(new Complex(-987.654, -32.1));
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->divideBy(-987.654);
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->divideBy(new Complex(0, 1));
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->divideBy(new Complex(0, -1));
echo $x, PHP_EOL;


echo PHP_EOL, 'Divide Into', PHP_EOL;

$x = new Complex(123);
$x->divideInto(456);
echo $x, PHP_EOL;

$x = new Complex(123.456);
$x->divideInto(789.012);
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->divideInto(new Complex(-987.654, -32.1));
echo $x, PHP_EOL;

$x = new Complex(123.456, 78.90);
$x->divideInto(-987.654);
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->divideInto(new Complex(0, 1));
echo $x, PHP_EOL;

$x = new Complex(-987.654, -32.1);
$x->divideInto(new Complex(0, -1));
echo $x, PHP_EOL;