<?php
namespace Sunphp\Lib\Vendor;

class velogin {
	/*我微信oauth2认证*/
	static public function oauth2(){
		$param = '';
		if(!empty($_GET['param'])){
		    $param .= "?param=".$_GET['param'];
		}
		if(!empty($_GET['bid'])){
		    $param .= "?bid=".$_GET['bid'];
		} 
		if(!empty($_GET['auto_puid'])){
		    $param .= "?auto_puid=".$_GET['auto_puid'];
		} 
		$appid = VECHAT_APPID;  //公众号的唯一标识
		$redirect_uri = urlencode("http://".$_SERVER['SERVER_NAME']."/test/loginAction.php".$param);
		$state = 'other';
		$is_scope = max(0,$_GET['is_scope']);

		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize';

		// if($is_scope>0){
		if(!isset($_GET['is_scope'])){
		    // 一般模式
		    $url .= '?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect';
		}else{
		    // 静默模式
		    // echo 'hello world';
		    // sleep(5);
		    $url .= '?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
		}
		header("Location:".$url);

	}
}