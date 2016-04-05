<?php
// echo 'dddddddddddddddd';
class IndexController {
	public function index(){
		define("TOKEN", "kdfkdfk");
		$vechat = C('vechatapp',$_SERVER['SERVER_NAME']);
		define('VECHAT_APPID', $vechat['appid']);
		define('VECHAT_APPSECRET', $vechat['appsecret']);
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
		if (isset($_GET['echostr'])) {
		  $wechatObj->valid();
		}else{
		  $wechatObj->init_menu(); 
		  $wechatObj->responseMsg();
		}
	}
	public function hello(){
		var_dump($vechat = C('vechatapp',$_SERVER['SERVER_NAME']));
		echo $vechat['appid'];
		// var_dump(C('vechatapp'));
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