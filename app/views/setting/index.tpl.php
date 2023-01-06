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

global $bootstrap; ?>
<div id="migration-page">

    <div class="page-header">
        <div class="current-title title">Settings</div>
        <div class="redirect-icon"><a href="<?php echo $bootstrap->getUrl() ?>" title="Migration"><span class="icon-migrate"></span></a></div>
    </div>
    <!--Lib render-->
    <div class="migration-content">
        <div id="loading" class="backdrop">
            <span class="icon-loading"></span>
        </div>

        <?php $messages = $controller->getMessage(); ?>
        <?php if($messages): ?>
            <div style="margin-bottom: 20px;">
                <?php foreach($messages as $message){ ?>
                    <div class="alert-box <?php echo $message['type'] ?>"> <?php echo $message['message'] ?></div>
                <?php } ?>
            </div>
        <?php endif; ?>

        <div id="setting-wrap" class="wrap-box">
            <form id="setting-form" action="<?php echo $bootstrap->getUrl('setting.html') ?>" method="POST" enctype="application/x-www-form-urlencoded">
                <div class="box-content">

                    <div class="mapping-table" style="margin-bottom: 20px;">

                        <div class="form-group odd">
                            <div class="form-label text-left">License Key</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="license" class="form-input" name="license" value="<?php echo $settings['license'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Storage per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="storage" class="form-input" name="storage" value="<?php echo $settings['storage'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Tax per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="taxes" class="form-input" name="taxes" value="<?php echo $settings['taxes'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Manufacturer per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="manufacturers" class="form-input" name="manufacturers" value="<?php echo $settings['manufacturers'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Category per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="categories" class="form-input" name="categories" value="<?php echo $settings['categories'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Product per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="products" class="form-input" name="products" value="<?php echo $settings['products'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Customer per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="customers" class="form-input" name="customers" value="<?php echo $settings['customers'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Order per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="orders" class="form-input" name="orders" value="<?php echo $settings['orders'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Review per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="reviews" class="form-input" name="reviews" value="<?php echo $settings['reviews'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Delay time</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="delay" class="form-input" name="delay" value="<?php echo $settings['delay'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Retry time</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="retry" class="form-input" name="retry" value="<?php echo $settings['retry'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Database source cart prefix</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="src_prefix" class="form-input" name="src_prefix" value="<?php echo $settings['src_prefix'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group odd">
                            <div class="form-label text-left">Database target cart prefix</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="target_prefix" class="form-input" name="target_prefix" value="<?php echo $settings['target_prefix'] ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="form-group even">
                            <div class="form-label text-left">Other per batch</div>
                            <div class="form-field">
                                <div class="width50">
                                    <input type="text" id="other" class="form-input" name="other" value="<?php echo isset($settings['other']) ? $settings['other'] : '' ?>"/>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>

                        <div class="clear-both"></div>
                    </div>
                </div>
                <div class="box-action">
                    <div class="action-left">
                    </div>
                    <div class="action-center">
                        <a href="javascript: void(0)" class="next-action button-action action-submit">Save</a>
                    </div>
                    <div class="action-right">
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(function(){

        $("#setting-form").validate({
            rules: {
                license: "required",
                storage: {
                    required: true,
                    digits: true
                },
                taxes: {
                    required: true,
                    digits: true
                },
                manufacturers: {
                    required: true,
                    digits: true
                },
                categories: {
                    required: true,
                    digits: true
                },
                products: {
                    required: true,
                    digits: true
                },
                customers: {
                    required: true,
                    digits: true
                },
                orders: {
                    required: true,
                    digits: true
                },
                reviews: {
                    required: true,
                    digits: true
                },
                delay: {
                    required: true,
                    number: true
                },
                retry: {
                    required: true,
                    number: true
                }
            },
            errorClass: "message-valid"
        });

        $.MigrationData({
            url: 'index.php'
        });
    })
</script>