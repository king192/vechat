<?php
class img{
	public function img(){
		$url = 'http://7xiwax.com1.z0.glb.clouddn.com/wp-content/uploads/2015/07/4.jpg';
		echo $file = $this->https_request($url);
		if(isset($_GET['a'])){
			$action = $_GET['a'];
			if(in_array($action, array('test'))){
				call_user_func('img::'.$action);
			}
		}
		if(isset($_POST['a'])){
			$action = $_POST['a'];
			if(in_array($action, array('test'))){
				call_user_func('img::'.$action);
			}
		}
		// $res = file_put_contents("tmp.png", $file);
		// echo $res;
		// if($res){
		// 	echo 'ok';
		// }else{
		// 	echo 'fail';
		// }
	}
	public function test(){
		echo 'hello';
		// $url = 'http://7xiwax.com1.z0.glb.clouddn.com/wp-content/uploads/2015/07/4.jpg';
		// echo $file = $this->https_request($url);
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
new img();