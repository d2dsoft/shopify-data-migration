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

/* @var $this Bootstrap */
$root_url = $this->getUrl();
$root_url = ltrim($root_url, '/') . '/';
$root_css = $root_url . 'pub/css/';
$root_js = $root_url . 'pub/js/';
$favicon_url = $root_url . '/favicon.ico';
$logo_url = $root_url . '/pub/img/logo.png';
$styles = array(
    'bootstrap.min.css',
    'font-awesome.min.css',
    'select2.min.css',
    'layout.css',
    'style.css',
);
$scripts = array(
    'jquery.min.js',
    'bootstrap.min.js',
    'bootbox.min.js',
    'select2.min.js',
    'jquery.form.min.js',
    'jquery.validate.min.js',
    'jquery.extend.js',
    'jquery.migration.js',
//    'script.js'
);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?php echo $favicon_url ?>"/>

    <?php if(!isset($title)) $title = 'Migration Tool'; ?>
    <title><?php $this->__($title) ?></title>
    <?php foreach($styles as $style): ?>
        <link type="text/css" rel="stylesheet" media="screen" href="<?php echo $root_css . $style ?>" />
    <?php endforeach; ?>
    <?php foreach($scripts as $script): ?>
        <script type="application/javascript" src="<?php echo $root_js . $script ?>"></script>
    <?php endforeach; ?>
</head>
<body>
    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-12 text-center">
                    <a class="blog-header-logo text-dark" href="#"><img src="<?php echo $logo_url ?>" style="width: 300px;"></a>
                </div>
            </div>
        </header>
        <div>
            <?php if(isset($view_path)) include $view_path;?>
        </div>
    </div>
</body>
</html>