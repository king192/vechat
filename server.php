<?php
// error_reporting()
// var_dump($_SERVER);
ini_set('display_errors', 'on');
define('BASEDIR',__DIR__);
include BASEDIR.'/Sunphp/Loader.php';

/**
*注册类自动加载方法
*/
spl_autoload_register('\\Sunphp\\Loader::autoloadfff');
$i = 1;
while ($i--) {
\SeasLog::debug('this is a  debug',array('jhg' => 'neeke'));
}
/Lib/Vendor/SeasLog/Log::debug('11111111122223');