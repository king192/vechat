<?php
namespace Sunphp;

class Loader{
	/**
	*定义自动加载方法
	*/
	static function autoloadfff($class){
		// echo 'c='.$class;
		$path = BASEDIR.'/'.$class.'.php';
		// echo 'p='.$path;
		require($path);
	}
}