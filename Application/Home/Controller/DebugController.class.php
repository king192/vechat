<?php
use Sunphp\Lib\Vechat\vecommon;
class DebugController {
	public function index(){
		vecommon::init_config();
		// vecommon::get_test();
		echo TOKEN;
	}
	public function index1(){
		vecommon::debug();
		vecommon::debug();
	}
}