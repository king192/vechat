<?php
namespace Sunphp;

class App {
	static function run(){
		$app = APP_PATH.MODULE.'/Controller/'.CONTROLLER.'Controller.class.php';
		require $app;
		$class = CONTROLLER.'Controller';
		$controller = new $class;
		$action = ACTION;
		$controller -> $action();
	}
}