<?php
// echo 'dddddddddddddddd';
class IndexController {
	public function index(){
		define("TOKEN", "kdfkdfk");
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
		if (isset($_GET['echostr'])) {
		  $wechatObj->valid();
		}else{
		  $wechatObj->init_menu();
		  $wechatObj->responseMsg();
		}
	}
	public function hello(){
		var_dump(C('server'));
		echo 'hello';
	}
	public function server(){
		var_dump($_SERVER);
	}
	public function e(){
		try{
    		throw new Sunphp\myException('Exception test');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}