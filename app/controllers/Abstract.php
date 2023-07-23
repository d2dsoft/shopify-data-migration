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

abstract class App_Controller_Abstract
{
    /* @var D2dCoreLibApp */
    protected $app;

    /**
     * Check migration library install
     */
    protected function _isInstallLibrary(){
        $init_file = $this->_getInitLibrary();
        return file_exists($init_file);
    }

    /**
     * Define the init file of library
     */
    protected function _getInitLibrary()
    {
        return _APP_DIR . '/resources/init.php';
    }

    /**
     * Redirect to Url
     *
     * @var $path String
     */
    protected function _redirect($path)
    {
        global $bootstrap;
        $url = $bootstrap->getUrl($path);
        header("Location: $url");
    }

    /**
     * Initialization migration app
     *
     * @return Object
     */
    protected function _getMigrationApp()
    {
        if($this->app){
            return $this->app;
        }
        global $bootstrap;
        include_once $this->_getInitLibrary();
        D2dInit::initEnv();
        $app = D2dInit::getAppInstance(D2dInit::APP_HTTP, D2dInit::TARGET_CONNECT);
        $config = array();
        $config['db'] = $bootstrap->getConfig('db');
        $config['user_id'] = 1;
        $config['upload_dir'] = _ROOT_DIR . '/pub/media';
        $config['upload_location'] = 'pub/media';
        $config['log_dir'] = _ROOT_DIR . '/pub/log';
        $app->setConfig($config)
            ->setRequest($_REQUEST)
            ->setPluginManager($bootstrap);
        $this->app = $app;
        return $this->app;
    }

    /**
     * Response json data
     *
     * @var $data Array
     */
    protected function responseJson($data)
    {
        echo json_encode($data);
        exit;
    }

    /**
     * Stored message to session
     *
     * @var $type string
     * @var $message string
     *
     * @return object
     */
    public function setMessage($type, $message){
        if(!isset($_SESSION['messages'])){
            $_SESSION['messages'] = array();
        }
        $_SESSION['messages'][] = array(
            'type' => $type,
            'message' => $message
        );
        return $this;
    }

    /**
     * Retrieve message stored from session
     *
     * @return Array | null
     */
    public function getMessage(){
        $notify = isset($_SESSION['messages']) ? $_SESSION['messages'] : false;
        unset($_SESSION['messages']);
        return $notify;
    }
}