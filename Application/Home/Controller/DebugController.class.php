<?php
use Sunphp\Lib\Vechat\vecommon;
class DebugController {
	public function index(){
		vecommon::init_config();
		$config = vecommon::get_test();
		var_dump($config);
		echo TOKEN;
	}
	public function index1(){
		vecommon::debug();
		vecommon::debug();
	}
}