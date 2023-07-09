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

class App_Controller_Import
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
        $response = $app->process(D2dInit::PROCESS_INIT);
        $html = '';
        if($response['status'] == D2dCoreLibConfig::STATUS_SUCCESS){
            $html = $response['html'];
        }
        $bootstrap->render('default', 'import/index', array(
            'html' => $html,
            'jsConfig' => $target->getConfigJs()
        ));
    }

    /**
     * Process for action process
     */
    public function processAction()
    {
        global $bootstrap;
        $app = $this->_getMigrationApp();
        $process = $bootstrap->getRequestParam('process');
        if(!$process || !in_array($process, array(
                D2dInit::PROCESS_SETUP,
                D2dInit::PROCESS_CHANGE,
                D2dInit::PROCESS_UPLOAD,
                D2dInit::PROCESS_STORED,
                D2dInit::PROCESS_STORAGE,
                D2dInit::PROCESS_CONFIG,
                D2dInit::PROCESS_CONFIRM,
                D2dInit::PROCESS_PREPARE,
                D2dInit::PROCESS_CLEAR,
                D2dInit::PROCESS_IMPORT,
                D2dInit::PROCESS_RESUME,
                D2dInit::PROCESS_REFRESH,
                D2dInit::PROCESS_AUTH,
                D2dInit::PROCESS_FINISH))){
            $this->responseJson(array(
                'status' => 'error',
                'message' => 'Process Invalid.'
            ));
            return;
        }
        $response = $app->process($process);
        $this->responseJson($response);
        return;
    }

    /**
     * Process for action download
     */
    public function downloadAction()
    {
        global $bootstrap;
        $app = $this->_getMigrationApp();
        $app->process(D2dInit::PROCESS_DOWNLOAD);
    }

}