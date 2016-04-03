<?php
error_reporting(E_ALL & ~E_NOTICE);
define('BASEDIR',__DIR__);
include BASEDIR.'/Sunphp/Loader.php';

/**
*注册类自动加载方法
*/
spl_autoload_register('\\Sunphp\\Loader::autoloadfff');