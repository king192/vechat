<?php
namespace Sunphp\Lib\Vendor;
use Lib\Vendor\Net\Http;

class velogin {
	  public function __construct(){
	    if(!defined('VECHAT_APPID') || !defined('VECHAT_APPSECRET')){
	      Log::error('not defined appid or appsecret',array(),'defined');
	    }
	  }
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
		$redirect_uri = urlencode("http://".$_SERVER['SERVER_NAME']."/Home/Index/getuserinfo".$param);
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
	/*
	*获取微信用户信息
	*return array
	*/
	static public function getUserInfo(){
		$appid = VECHAT_APPID; //公众号的唯一标识
        $secret = VECHAT_APPSECRET;  //公众号的appsecret
        $code = $_GET["code"];  //第一步获取的code参数
        if(!empty($_GET['puid'])){
            $param .= "&puid=".$_GET['puid'];
        }
        if(!empty($_GET['bid'])){
            $param .= "&bid=".$_GET['bid'];
        }
        if(!empty($_GET['auto_puid'])){
            $param .= "&auto_puid=".$_GET['auto_puid'];
        }

        if(empty($_GET['param'])){
        //获取授权token
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        $json_obj = json_decode(Http::http_post($get_token_url),true);
        // var_dump($json_obj);
        $access_token = $json_obj['access_token'];
        $openid = $json_obj['openid'];

	        //根据openid和access_token查询用户信息
	        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
	        $res = Http::http_post($get_user_info_url);
	        $user_obj = json_decode($res,true);
	        var_dump($user_obj);
	    }else{

            $get_tken_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
            $get_tken = json_decode(Http::http_post($get_tken_url),true);
            // var_dump($get_tken);

            $access_token = $get_tken['access_token'];
            $get_subscribe_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$puid_openid.'&lang=zh_CN';
            $get_subscribe = json_decode(Http::http_post($get_subscribe_url),true);
            return $get_subscribe;
	    }
	}
}