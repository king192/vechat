<?php
error_reporting(E_ALL & ~E_NOTICE);

require BASEDIR.'/Sunphp/Loader.php';
require BASEDIR.'/Sunphp/Route.php';
// route::run();
//URL解析
route::parseUrl();
// echo 'heee';
// echo BASEDIR;
/**
*注册类自动加载方法
*/
spl_autoload_register('\\Sunphp\\Loader::autoloadfff');

require BASEDIR.'/Sunphp/functions.php';

\Sunphp\App::run();