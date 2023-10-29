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

class App_Controller_License
    extends App_Controller_Abstract
{

    /**
     * Process for action index
     */
    public function indexAction()
    {
        global $bootstrap;
        $app_folder = _APP_DIR;
        $pub_folder = _ROOT_DIR . '/pub';
        if(!is_writeable($app_folder)){
            $this->setMessage('error', 'Folder "app" must is a writable folder.');
        }
        if(!is_writeable($pub_folder)){
            $this->setMessage('error', 'Folder "pub" must is a writable folder.');
        }
        if(!ini_get('allow_url_fopen')){
            $this->setMessage('error', 'The PHP "allow_url_fopen" must is enabled. Please follow <a href="https://www.a2hosting.com/kb/developer-corner/php/using-php.ini-directives/php-allow-url-fopen-directive" target="_blank">here</a> to enable the setting.');
        }
        if (!extension_loaded('zip')) {
            $this->setMessage('error', 'PHP Zip extension is not installed. Please install the Zip extension.');
        }
        /*if (!function_exists('eval')) {
            $this->setMessage('error', 'Please enable the eval function.');
        }*/
        $bootstrap->render('default', 'license/index', array(
            'controller' => $this
        ));
    }

    /**
     * Process for action setup
     */
    public function setupAction()
    {
        global $bootstrap;
        $license = $bootstrap->getRequestParam('license');
        $install_lib = $this->_downloadAndExtraLibrary($license);
        if(!$install_lib){
            $this->_redirect('license.html');
            return;
        }
        $app = $this->_getMigrationApp();
        $initTarget = $app->getInitTarget();
        $install_db = $initTarget->setupDatabase($license);
        if(!$install_db){
            $this->_redirect('license.html');
            return;
        }
        $this->_redirect('migration.html');
    }

    /**
     * Check and install library from server by license key
     */
    protected function _downloadAndExtraLibrary($license = '')
    {
        $url = 'https://d2d-soft.com/download_package.php';
        $tmp_path = _ROOT_DIR . '/pub/media/resources.zip';
        $data = array(
            'license' => $license
        );
        $fp = @fopen($tmp_path, 'wb');
        if(!$fp){
            return false;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            return false;
        }
        curl_close($ch);
        @fclose($fp);
        if(!$response){
            return false;
        }

        $zip = new ZipArchive;
        if ($zip->open($tmp_path) === TRUE) {
            $zip->extractTo(_APP_DIR);
            $zip->close();

            @unlink($tmp_path);
            return true;
        } else {
            return false;
        }

    }
}