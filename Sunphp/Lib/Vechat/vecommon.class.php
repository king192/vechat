<?php
namespace Sunphp\Lib\Vendor;
if(!defined('APP_PATH')){
	exit('access deny');
}
class vecommon{
	static function get_access_token(){
        $appid = VECHAT_APPID;
        $appsecret = VECHAT_APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        
        $output = Http::http_post($url);
        $jsoninfo = json_decode($output, true);
        
        $access_token = $jsoninfo["access_token"];
        return $access_token;
	}
}