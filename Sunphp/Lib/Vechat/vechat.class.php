<?php
namespace Sunphp\Lib\Vechat;
use Sunphp\Lib\Vendor\SeasLog\Log;
use Sunphp\Lib\Vendor\Net\Http;
use Sunphp\Lib\Vechat\vecommon;

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
          Log::info('some',array(),'validfail');
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
    function init_menu(){
        
        $access_token = vecommon::get_access_token();
        $jsonmenu = '{
              "button":[
              {
                    "name":"网站",
                   "sub_button":[
                    {
                       "type":"view",
                       "name":"爱游思",
                       "url":"http://wp.iyouths.org"
                    },
                    {
                       "type":"view",
                       "name":"nodejs站点",
                       "url":"http://www.55com.org"
                    }]
              
        
               },
               {
                   "name":"关于",
                   "sub_button":[
                    {
                      "type":"click",
                      "name":"说明",
                      "key":"about"
                    }]
               
        
               }]
         }';
        
        
                    // {
                    //   "type":"click",
                    //   "name":"用户信息", 
                    //   "key":"userinfo"
                    // },
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $result = Http::http_post($url, $jsonmenu);
        var_dump($result);
    }
    public function delete_menu(){
      $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".vecommon::get_access_token();
      $result = Http::http_post($url);
    }
    public function flush_menu(){
      $this->delete_menu();
      $this->init_menu();
    }
        
        // protected fuHttp::http_post(
        // }
      private function receiveEvent($object)
    {
        // Log::debug('hello',array(),'event');
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "欢迎关注!!!".$object->EventKey;
                Log::info($object->FromUserName,array(),'subscribe');
            case "unsubscribe":
                Log::info($object->FromUserName,array(),'unsubscribe');

                break;
            case "CLICK":
                Log::debug($object->EventKey,array(),'click');
                switch ($object->EventKey)
                {
                    case "company":
                        $contentStr[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "userinfo":
                        Log::debug($object->FromUserName,array(),'click');
                        $res = $this->userinfo($object->FromUserName);
                        $contentStr[] = array('Title'=>'hello','Description'=>$res);
                        break;
                    case "about":
                        $contentStr = '此公众号暂时不接收用户消息，需要请联系1293812979@qq.com或o@iyouths.org';
                        break;
                    default:
                        $contentStr[] = array("Title" =>"谢谢您的关注", 
                        "Description" =>"hahahhahahahahhaahhahaahhahahha", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"http://wp.iyouths.org");
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
        Log::debug($object->FromUserName.' || '.$object->Content,array(),'text');
        $appid = VECHAT_APPID;

        $token = vecommon::get_access_token();
        $c=array("query"=>$object->Content,"city"=>"北京","category"=>"stock","appid"=>$appid,"uid"=>$object->FromUserName);
        $post=json_encode($c);
        $post=urldecode($post);
        //语义理解
        $url = "https://api.weixin.qq.com/semantic/semproxy/search?access_token=".$token; 
        $msg = Http::http_post($url,$post); 
        $strjson=json_decode($msg);
        $code = $strjson->semantic->details->code;
        $category = $strjson->semantic->details->category;
        $funcFlag = 0;
        $contentStr = "你发送的内容为：".$msg->ret;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }
    private function receiveText1($object){
        Log::debug($object->FromUserName.' || '.$object->Content,array(),'text');
        switch ($object->Content) {
          case 'info':
            $contentStr = 'http://'.$_SERVER['SERVER_NAME'].'/login.php';
            break;
          case 'vl':
            $contentStr = 'http://'.$_SERVER['SERVER_NAME'].'/Home/Index/oauth2';
            break;
          case 'v':
            $contentStr = 'http://'.$_SERVER['SERVER_NAME'].'/Home/Index/getuserinfo';
            break;
          default:
            $contentStr = "你发送的内容为：".$object->Content;
            break;
        }
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
      $access_token = vecommon::get_access_token();
      Log::debug($openid.'||||||'.$access_token);
      return Http::http_post('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid);
    }

}