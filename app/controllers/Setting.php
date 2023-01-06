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

class App_Controller_Setting
    extends App_Controller_Abstract
{

    /**
     * Process for action index
     */
    public function indexAction()
    {
        if(!$this->_isInstallLibrary()){
            $this->_redirect('license.html');
            return ;
        }
        global $bootstrap;
        $app = $this->_getMigrationApp();
        $target = $app->getInitTarget();
        if(!empty($_POST)){
            $keys = array(
                'license', 'storage', 'taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'delay', 'retry', 'src_prefix', 'target_prefix', 'other'
            );
            foreach($keys as $key){
                $target->dbSaveSetting($key, $bootstrap->getRequestParam($key));
            }
            $this->setMessage('success', 'Save successfully.');
        }
        $settings = $target->dbSelectSettings();
        $bootstrap->render('default', 'setting/index', array(
            'settings' => $settings,
            'controller' => $this
        ));
    }

}