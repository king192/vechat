<?php
// echo 'dddddddddddddddd';
class IndexController {
	public function index(){
		define("TOKEN", "kdfkdfk");
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
		if (isset($_GET['echostr'])) {
		  $wechatObj->valid();
		}else{
		  $wechatObj->responseMsg();
		}
	}
	public function oauth2(){
		define("TOKEN", "kdfkdfk");
		$this->appconfig();
		\Sunphp\Lib\Vendor\velogin::oauth2();
	}
	public function getuserinfo(){
		define("TOKEN", "kdfkdfk");
		$this->appconfig();
		$info = \Sunphp\Lib\Vendor\velogin::getUserInfo();
		var_dump($info);
	}
	//初始化菜单
	public function initMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
		$wechatObj->init_menu(); 
	}

	public function delMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
		$wechatObj->delete_menu(); 
	}
	public function flushMenu(){
		$this->appconfig();
		$wechatObj = new \Sunphp\Lib\Vendor\vechat();
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
		$vechat = C('vechatapp',$_SERVER['SERVER_NAME']);
		define('VECHAT_APPID', $vechat['appid']);
		define('VECHAT_APPSECRET', $vechat['appsecret']);
	}
}