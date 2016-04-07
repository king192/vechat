<?php
/**
*@author 1293812979@qq.com
*/
namespace Sunphp\Lib\Vechat;
use Sunphp\Lib\Vendor\Net\Http;
use Sunphp\Lib\Vendor\SeasLog\Log;

if(!defined('APP_PATH')){
	// Log::debug('access deny',array(),'invalid');
	exit('access deny');
}
class vecommon{
	/*
	*获取access_token
	*
	*/
	static function get_access_token(){
        $appid = VECHAT_APPID;
        $appsecret = VECHAT_APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        
        $output = Http::http_post($url);
        $jsoninfo = json_decode($output, true);
        
        $access_token = $jsoninfo["access_token"];
        return $access_token;
	}
	/*
	*
	*$type number 1:access_token,2:openid,3:array
	*/
	static function get_test($type=1){
        $appid = VECHAT_APPID;
        $appsecret = VECHAT_APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        
        $output = Http::http_post($url);
        $jsoninfo = json_decode($output, true);
        
        if($type === 1){
        	return $jsoninfo["access_token"];
        }elseif($type === 2){
        	return $jsoninfo["openid"];
        }elseif($type === 3){
        	return $jsoninfo;
        }else{
        	// Log::error('param error in vecommon::get_test');
        	return false;
        }
	}
	static function init_config(){
		$vechat = C('vechatapp',$_SERVER['SERVER_NAME']);
		define('VECHAT_APPID', $vechat['appid']);
		define('VECHAT_APPSECRET', $vechat['appsecret']);
		define("TOKEN", "kdfkdfk");//并不是所有操作都需要token
	}
	static function debug(){
		echo 'hello world!';
	}
}