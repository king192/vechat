<?php
error_reporting(E_ALL & ~E_NOTICE);

require BASEDIR.'/Sunphp/Loader.php';
// echo BASEDIR;
/**
*注册类自动加载方法
*/
spl_autoload_register('\\Sunphp\\Loader::autoloadfff');