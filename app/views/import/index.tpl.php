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
        <div class="current-title title">Migration</div>
        <div class="redirect-icon"><a href="<?php echo $bootstrap->getUrl('setting.html') ?>" title="Setting"><span class="icon-setting"></span></a></div>
    </div>

    <?php echo $html ?>

</div>
<script type="text/javascript">
    $(function(){
        $.MigrationData({
            <?php foreach($jsConfig as $key => $value) { ?>
                <?php echo $key ?>: '<?php echo $value ?>',
            <?php } ?>
            url: 'index.php',
            request_post: {
                controller: 'import',
                action: 'process'
            },
            request_download: {
                controller: 'import',
                action: 'download'
            }
        });
    })
</script>