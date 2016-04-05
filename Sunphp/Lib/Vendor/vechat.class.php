<?php
namespace Sunphp\Lib\Vendor;
use Lib\Vendor\SeasLog\Log;

class vechat
{
  public function __construct(){
    if(!defined('VECHAT_APPID') || !defined('VECHAT_APPSECRET')){
      Log::error('not defined appid or appsecret',array(),'defined');
    }
  }
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }else{
          Log::info('some',array(),'logtest');
          exit('nonono');
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

    if (!empty($postStr)){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $RX_TYPE = trim($postObj->MsgType);

        switch ($RX_TYPE)
        {
            case "text":
                $resultStr = $this->receiveText1($postObj);
                break;
            case "event":
                $resultStr = $this->receiveEvent($postObj);
                break;
            default:
                $resultStr = "";
                break;
        }
        echo $resultStr;
    }else {
        echo "";
        exit;
    }
  //     	//extract post data
		// if (!empty($postStr)){
  //               /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
  //                  the best way is to check the validity of xml by yourself */
  //               libxml_disable_entity_loader(true);
  //             	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
  //               $fromUsername = $postObj->FromUserName;
  //               $toUsername = $postObj->ToUserName;
  //               $keyword = trim($postObj->Content);
  //               $time = time();
  //               $textTpl = "<xml>
		// 					<ToUserName><![CDATA[%s]]></ToUserName>
		// 					<FromUserName><![CDATA[%s]]></FromUserName>
		// 					<CreateTime>%s</CreateTime>
		// 					<MsgType><![CDATA[%s]]></MsgType>
		// 					<Content><![CDATA[%s]]></Content>
		// 					<FuncFlag>0</FuncFlag>
		// 					</xml>";             
		// 		if(!empty( $keyword ))
  //               {
  //             		$msgType = "text";
  //               	$contentStr = "Welcome to wechat world!";
  //               	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
  //               	echo $resultStr;
  //               }else{
  //               	echo "Input something...";
  //               }

  //       }else {
  //       	echo "";
  //       	exit;
  //       }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
  private function get_access_token(){
        $appid = VECHAT_APPID;
        $appsecret = VECHAT_APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        
        $output = $this->https_request($url);
        $jsoninfo = json_decode($output, true);
        
        $access_token = $jsoninfo["access_token"];
        return $access_token;
  }
    function init_menu(){
        
        $access_token = $this->get_access_token();
        $jsonmenu = '{
              "button":[
              {
                    "name":"天气预报",
                   "sub_button":[
                    {
                       "type":"click",
                       "name":"北京天气",
                       "key":"天气北京"
                    },
                    {
                       "type":"click",
                       "name":"深圳天气",
                       "key":"天气深圳"
                    },
                    {
                        "type":"view",
                        "name":"本地天气",
                        "url":"http://m.hao123.com/a/tianqi"
                    }]
              
        
               },
               {
                   "name":"关于",
                   "sub_button":[
                    {
                    "type": "view",
                    "name": "授权获取",
                    "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid='.VECHAT_APPID.'&redirect_uri=http%3A%2F%2'.$_SERVER["SERVER_NAME"].'%2Findex.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect"
                    },
                    {
                      "type":"click",
                      "name":"用户信息", 
                      "key":"userinfo"
                    },
                    {
                      "type":"view",
                      "name":"授权登录",
                      "url":"http://'.$_SERVER["SERVER_NAME"].'/login.php"
                    }]
               
        
               }]
         }';
        
        
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $result = $this->https_request($url, $jsonmenu);
        var_dump($result);
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
      private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "欢迎关注!!!".$object->EventKey;
                Log::info('some',array(),'subscribe');
            case "unsubscribe":

                break;
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "company":
                        $contentStr[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "userinfo":
                        $res = $this->userinfo($object->FromUserName);
                        $contentStr[] = array('Title'=>'hello','Description'=>$res);
                        break;
                    default:
                        $contentStr[] = array("Title" =>"默认菜单回复", 
                        "Description" =>"您正在使用的是方倍工作室的自定义菜单测试接口", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                }
                break;
            case "SCAN":
                // $contentStr = '您扫描了二维码！';
                $contentStr = "扫描 ".$object->EventKey;
                break;
            default:
                $contentStr = '当前事件为：'.$object->Event;
                break;      

        }
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }

      private function receiveText($object)
    {
        Log::debug($object->Content,array(),'text');
        $appid = VECHAT_APPID;

        $token = $this->get_access_token();
        $c=array("query"=>$object->Content,"city"=>"北京","category"=>"stock","appid"=>$appid,"uid"=>$object->FromUserName);
        $post=json_encode($c);
        $post=urldecode($post);
        //语义理解
        $url = "https://api.weixin.qq.com/semantic/semproxy/search?access_token=".$token; 
        $msg = $this->https_request($url,$post); 
        $strjson=json_decode($msg);
        $code = $strjson->semantic->details->code;
        $category = $strjson->semantic->details->category;
        $funcFlag = 0;
        $contentStr = "你发送的内容为：".$msg->ret;
        Log::debug($msg->ret,array('msg'=>$msg->ret),'text');
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }
    private function receiveText1($object)
    {
        Log::debug($object->Content,array(),'text');
        if($object->Content == 'info'){
          $contentStr = 'http://'.$_SERVER['SERVER_NAME'].'/login.php';
        }else{
          $contentStr = "你发送的内容为：".$object->Content;
        }
        Log::debug($msg->ret,array('msg'=>$object->Content),'text');
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }
    private function transmitText($object, $content, $funcFlag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);
        return $resultStr;
    }
        private function transmitNews($object, $arr_item, $funcFlag = 0)
    {
        //首条标题28字，其他标题39字
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
<FuncFlag>%s</FuncFlag>
</xml>";

        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);
        return $resultStr;
    }
    private function userinfo($openid){
      $access_token = $this->get_access_token();
      return $this->https_request('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid);
    }

}