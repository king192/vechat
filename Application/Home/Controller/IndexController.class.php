<?php
// echo 'dddddddddddddddd';
use Sunphp\Lib\Vechat\vecommon;
class IndexController {
	public function index(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vechat\vechat();
		if (isset($_GET['echostr'])) {
			//微信接入，即初始化认证，认证时不需要appid和appsecret
			// define("TOKEN", "kdfkdfk");
		  $wechatObj->valid();
		}else{
			//非认证，接收消息事件
		  $wechatObj->responseMsg();
		}
	}
	public function oauth2(){
		// define("TOKEN", "kdfkdfk");
		$this->appconfig();
		\Sunphp\Lib\Vechat\velogin::oauth2();
	}
	public function getuserinfo(){
		// define("TOKEN", "kdfkdfk");
		// exit('hello');
		$this->appconfig();
		$code = $_GET['code'];
		$info = \Sunphp\Lib\Vechat\velogin::getUserInfo($code);
		echo '=+=+=+=+=+===+===+=+=+==<br>';
		var_dump($info);
	}
	//初始化菜单
	public function initMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vechat\vechat();
		$wechatObj->init_menu(); 
	}

	public function delMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vechat\vechat();
		$wechatObj->delete_menu(); 
	}
	public function flushMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vechat\vechat();
		$wechatObj->flush_menu(); 
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
	private function appconfig(){
		vecommon::init_config();
	}
}