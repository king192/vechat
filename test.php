<?php
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        // if($echostr)
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
 
    public function responseMsg()
    { 
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        // $postStr = $_GET['msg'];
 
        //extract post data
         
                 
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                 
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $type=$postObj->MsgType;              
                $Recognition = $postObj->Recognition;
                $Recognition=urlencode($Recognition);
                 
                $time = time();
                 $token = $this->get_access_token();
$c=array("query"=>$Recognition,"city"=>"北京","category"=>"stock","appid"=>"wx3a5aac7161b28013","uid"=>"opuShs_H5WGiwXY4jP2uHKxVadus");
$post=json_encode($c);
$post=urldecode($post);
//语义理解
$url = "https://api.weixin.qq.com/semantic/semproxy/search?access_token={$token}";  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);//url  
curl_setopt($ch, CURLOPT_POST, 1);  //post
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$a = curl_exec($ch);
$strjson=json_decode($a);
$code = $strjson->semantic->details->code;
$category = $strjson->semantic->details->category;
//股票查询
$url="http://apistore.baidu.com/microservice/stock?stockid=".$category.$code;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$a = curl_exec($ch);
$strjson=json_decode($a);
$name=$strjson->retData->stockinfo->name;
$price=$strjson->retData->stockinfo->currentPrice;
$reply= $name."当前股价".$price;
         
        $textTpl = "
                            $fromUsername
                            $toUsername
                            $time
                             
                             
                            0
                            ";    
        echo $textTpl;
                 
     
        }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];    
                 
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
         
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

  private function get_access_token(){
        $appid = "wx3a5aac7161b28013";
        $appsecret = "d4624c36b6795d1d99dcf0547af5443d";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        
        $output = $this->https_request($url);
        $jsoninfo = json_decode($output, true);
        
        $access_token = $jsoninfo["access_token"];
        return $access_token;
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
?>