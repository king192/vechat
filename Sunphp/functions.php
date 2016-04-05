<?php

function C($key,$file='config'){
	$config = new \Sunphp\Config('/common/conf');
    if (!strpos($key, '.')) {
        return $config[$file][$key];
    }
    // 二维数组设置和获取支持
    $key = explode('.', $key);
    // $key[0]   =  strtoupper($key[0]);
	return $config[$file][$key[0]][$key[1]];
}