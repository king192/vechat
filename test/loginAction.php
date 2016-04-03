<?php
// $code = $_GET["code"];  //第一步获取的code参数
// echo $code;
// echo 'hello';
class login{
	public function login(){
        $appid = "wxb39afc8e3bd62749"; //公众号的唯一标识
        $secret = "8ff4cdfe5cee4b03fc2a88604a0358d6";  //公众号的appsecret
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
        $json_obj = json_decode($this->https_request($get_token_url),true);
        // var_dump($json_obj);
        $access_token = $json_obj['access_token'];
        $openid = $json_obj['openid'];

	        //根据openid和access_token查询用户信息
	        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
	        $res = $this->https_request($get_user_info_url);
	        $user_obj = json_decode($res,true);
	        var_dump($user_obj);
	    }else{

            $get_tken_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
            $get_tken = json_decode($this->https_request($get_tken_url),true);
            // var_dump($get_tken);

            $access_token = $get_tken['access_token'];
            $get_subscribe_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$puid_openid.'&lang=zh_CN';
            $get_subscribe = json_decode($this->https_request($get_subscribe_url),true);
            var_dump($get_subscribe);
	    }
	}

    protected function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
$new = new login();