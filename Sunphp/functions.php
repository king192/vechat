<?php

function C($key){
	$config = new \Sunphp\Config('/common/conf');
	return $config[$key];
}