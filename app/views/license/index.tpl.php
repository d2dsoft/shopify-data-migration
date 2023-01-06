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
        <div class="current-title title">Install</div>
    </div>

    <form action="<?php echo $bootstrap->getUrl('license/setup') ?>" method="POST" enctype="application/x-www-form-urlencoded">
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

            <div id="install-wrap" class="wrap-box">

                <div class="box-content">

                    <div class="form-group width50" style="margin: 0 auto;">
                        <div style="width: 20%;float: left;">License</div>
                        <div style="width: 80%;float:left;">
                            <input type="text" class="form-input" name="license"/>
                        </div>
                        <div class="clear-both"></div>
                    </div>

                    <div class="form-group" style="margin-top: 10px;">
                        <p>Please fill your license in the form and click the "Install" button. The tool auto-downloads the newest library from D2dSoft's server and installs it. After that, you can run the migration.</p>
                        <p>If you don't have the license, please go to the <a href="https://d2d-soft.com/">D2dSoft website</a> to buy a license or try to run the free migration.</p>
                    </div>
                </div>
                <div class="box-action">
                    <div class="action-left"></div>
                    <div class="action-center">
                        <a href="javascript: void(0)" class="next-action button-action action-submit">Install</a>
                    </div>
                    <div class="action-right"></div>
                </div>
            </div>

        </div>
    </form>
</div>

<script type="text/javascript">
    $(function(){
        $.MigrationData({
            url: 'index.php'
        });
    })
</script>