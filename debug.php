<?php
/**
* 
*/
class ClassName
{
    
    function __construct()
    {
        # code...
        // if(isset($_GET['url'])){
        //     $url = $_GET['url'];
        // }
        // if
        //https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQEr7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzAwaEhOdGJsWFNZa3l1UHdpR1JpAAIEcT0vVgMEAAAAAA==
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->get_access_token();
        $data = '{"action_name": "QR_LIMIT_STR_SCENE",
                    "action_info": {
                        "scene": {
                                "scene_str":"'.time().'"
                                }
                    }
                }';
                $res = $this->https_request($url,$data);
                $ticket = json_decode('['.$res.']');
                echo $ticket = $ticket[0]->ticket;
                $getQrUrl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
                echo '<iframe style="width: 100%; height: 100%; border: 0; outline: 0;" src="'.$getQrUrl.'"></iframe>';
                // $imgStream = $this->https_request($getQrUrl);
                // echo '<img src="'.$imgStream.'"/ >';
                // echo 'hrllo';
    }
  public function get_access_token(){
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
$new = new ClassName();
        ?>