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

class Bootstrap
{
    /* @var Bootstrap */
    protected static $instance = null;
    protected $url;

    const LAYOUT    = 'layouts';
    const VIEW      = 'views';

    /**
     * Retrieve singleton object
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Process request
     */
    public function run()
    {
        $route = $this->route();
        if(!$route){
            die('Route invalid.');
        }
        $className = $route[0];
        $actionName = $route[1];
        $class = new $className;
        $class->$actionName();
    }

    /*
     * TODO: INIT
     */

    /**
     * Register autoload function
     */
    public static function autoload($className)
    {
        if(class_exists($className)){
            return ;
        }
        $config = self::getConfig('autoload');
        foreach($config as $config_class_prefix => $dir_path){
            $config_class_length = strlen($config_class_prefix);
            $class_prefix = substr($className, 0, $config_class_length);
            if($class_prefix == $config_class_prefix){
                $class_suffix = substr($className, $config_class_length);
                $file_name = str_replace('_', '/', $class_suffix);
                $file_path = $dir_path . DS . $file_name . '.php';
                if(file_exists($file_path)){
                    include_once $file_path;
                    break;
                }
            }
        }
    }

    /*
     * TODO: CONFIG
     */

    /**
     * Retrieve config data from file
     *
     * @var $type string
     * @return array | null
     */
    public static function getConfig($type){
        $config_path = _APP_DIR . DS. 'config' . DS . $type . '.php';
        $config = array();
        if(file_exists($config_path)){
            $config = include $config_path;
        }
        return $config;
    }

    /**
     * Build url by query
     *
     * @var $path string
     * @return string
     */
    public function getUrl($path = null)
    {
        $root_url = $this->getRootUrl();
        if(!$path){
            return $root_url;
        }
        $url = rtrim($root_url, '/') . '/' . ltrim($path, '/');
        return $url;
    }

    /**
     * Check and init url of tool
     *
     * @return string
     */
    protected function getRootUrl()
    {
        if(!$this->url){
            $url = 'http';
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
                $url .= "s";
            }
            $url .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]);
            }
            else {
                $url .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]);
            }
            $this->url = $url;
        }
        return $this->url;
    }

    /**
     * Build redirect url
     *
     * @return string
     */
    protected function getRoutePath(){
        $route = $this->getRequestParam('r');
        if(!$route && isset($_SERVER['PATH_INFO'])){
            $route = $_SERVER['PATH_INFO'];
        }
        if($route){
            $route = ltrim($route, '/');
        }
        return $route;
    }

    /*
     * TODO: REQUEST
     */

    /**
     * Retrieve request value by key
     *
     * @var $key string
     * @var $default string | array | null
     * @return string | null
     */
    public function getRequestParam($key, $default = null)
    {
        $result = null;
        if(isset($_GET[$key]))
            $result = $_GET[$key];

        if($result === null && isset($_POST[$key])){
            $result = $_POST[$key];
        }


        if($result === null && isset($_REQUEST[$key]))
            $result = $_REQUEST[$key];

        return $result !== null ? $result : $default;
    }

    /*
     * TODO: VIEW
     */

    /**
     * Render template data
     *
     * @var $layout string
     * @var $view string
     *
     * @return string
     */
    public function render($layout, $view, $binds = array())
    {
        $layout_path = $this->getTemplate($layout, self::LAYOUT);
        if($layout_path){
            if($binds) {
                foreach ($binds as $key => $value) {
                    $$key = $value;
                }
            }
            $view_path = $this->getTemplate($view, self::VIEW);
            include $layout_path;
        }
    }

    /**
     * Render template as variable
     *
     * @var $view string
     * @return string
     */
    public function fetch($view, $binds = array())
    {
        $html = '';
        $view_path = $this->getTemplate($view, self::VIEW);
        if($view_path){
            if($binds){
                foreach($binds as $key => $value){
                    $$key = $value;
                }
            }
            ob_start();
            include $view_path;
            $html = ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }

    /**
     * Get template path by name
     *
     * @var $name string
     * @return string | null
     */
    public function getTemplate($name, $type = self::LAYOUT)
    {
        $path = _APP_DIR . DS . $type . DS . $name . '.tpl.php';
        return file_exists($path) ? $path : false;
    }

    /*
     * TODO: ROUTE
     */

    /**
     * Parse controller and action from url
     *
     * @return array
     */
    public function route()
    {
        $controller = $this->getRequestParam('controller');
        $action = $this->getRequestParam('action', 'index');
        if(!$controller || !$this->isRoute($controller, $action)){
            $route = $this->getRoutePath();
            $route = ltrim($route, '/');
            if($route){
                preg_match('/((?<controller>[\w\d]+)\/)?((?<action>[\w\d]+)\/)?/', $route . '/', $m);
                $controller = $this->getArrayValue($m, 'controller');
                $action = $this->getArrayValue($m, 'action', 'index');
            }
            if(!$controller || !$this->isRoute($controller, $action)){
                $rewrite = self::getConfig('route');
                $config = $this->getArrayValue($rewrite, $route);
                if(!$config)
                    $config = $this->getArrayValue($rewrite, 'home');

                $split = explode('@', $config);
                $controller = $split[0];
                $action = $split[1];
            }
        }

        if(!$this->isRoute($controller, $action)){
            return false;
        }

        $class = $this->getControllerClass($controller);
        $method = $this->getActionMethod($action);
        return array($class, $method);
    }

    /**
     * Build class name from url
     *
     * @var $controller string
     * @return string
     */
    public function getControllerClass($controller)
    {
        return 'App_Controller_' . ucfirst($controller);
    }

    /**
     * Build action name from url
     *
     * @var $action string
     * @return string
     */
    public function getActionMethod($action)
    {
        return $action . 'Action';
    }

    /**
     * Check controller exists
     *
     * @var $controller string
     * @return boolean
     */
    public function isController($controller)
    {
        $class = $this->getControllerClass($controller);
        return class_exists($class);
    }

    /**
     * Check action exists
     *
     * @var $class string
     * @var $action string
     *
     * @return boolean
     */
    public function isAction($class, $action)
    {
        $method = $this->getActionMethod($action);
        return method_exists($class, $method);
    }

    /**
     * Check route exists
     *
     * @var $controller string
     * @var $action string
     *
     * @return boolean
     */
    public function isRoute($controller, $action)
    {
        if(!$controller || !$action){
            return false;
        }

        if(!$this->isController($controller)){
           return false;
        }
        $class = $this->getControllerClass($controller);
        return $this->isAction($class, $action);
    }

    /*
     * TODO: LOGGER
     */

    /**
     * Log data to file
     *
     * @var $message string | array | object
     * @var $type string
     *
     * @return object
     */
    public function log($message, $type = 'info')
    {
        $path = _ROOT_DIR . DS . 'pub' . DS . 'log' . DS . $type . '.log';
        if(is_array($message) || is_object($message)){
            $message = print_r($message, true);
        }
        $date = date('Y-m-d H:i:s');
        $message = $date . ": " . $message;
        @file_put_contents($path, $message, FILE_APPEND);
        @file_put_contents($path, "\r\n", FILE_APPEND);
        return $this;
    }

    /*
     * TODO: UTILS
     */

    /**
     * Check and get value of array by key
     *
     * @var $array array
     * @var $key string
     * @var $default string | array | null
     * @return string | array | null
     */
    public function getArrayValue($array, $key, $default = null)
    {
        if(!$array)
            return $default;

        return isset($array[$key]) ? $array[$key] : $default;
    }

    /**
     * Transform variable to template
     *
     * @var $text string
     */
    public function __($text){
        echo $text;
    }

    /**
     * Load plugin
     * @var $name string
     * @return object | boolean
     */
    public function getPlugin($name){
        $class_name = 'App_Plugin_' . $name;
        if(!class_exists($class_name)){
            return false;
        }
        $class = new $class_name();
        return $class;
    }
}