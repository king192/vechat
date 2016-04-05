<?php

class route {
	// public function __construct(){
	// 	self::run();
	// }
	static function run(){
		$uri = $_SERVER['REQUEST_URI'];
		$uri = substr($uri, 1);
		echo 'test:';
		var_dump($uri);

		echo "\n<br>";
		$uri = explode('/',$uri);
		var_dump($uri);
		$m = array_shift($uri);
		$c = array_shift($uri);
		$a = array_shift($uri);
		$m = empty($m)?'Home':$m;
		$c = empty($c)?'Index':$c;
		$a = empty($a)?'index':$a;
		echo 'm:'.$m.'<br>';
		echo 'c:'.$c.'<br>';
		echo 'a:'.$a.'<br>';
		echo 'testtt::'.empty($a);
		var_dump($uri);
		echo "\n<br>";
		// $uri = implode('/', $uri);
		// echo 'match:::<br>';
		// preg_match_all('/(\w+)\/([^\/]+)/', $uri, $match);
		// var_dump($match[0]);
		// echo "\n<br>";
		// foreach ($match[0] as $k => $v) {
		// 	print_r( explode('/',$v));
		// }
		echo '<br>';	
		$var = array();
		preg_replace_callback('/(\w+)\/([^\/]+)/', function($match) use(&$var){$var[$match[1]]=strip_tags($match[2]);}, implode('/',$uri));
		print_r($var);	
		echo '<br>';
		$_GET = array_merge($_GET,$var);
		print_r($_GET);
		echo 'req::';
		print_r($_REQUEST);
	}
	/*
	URL解析
	*/
	static function parseUrl(){

		$uri = $_SERVER['REQUEST_URI'];
		if(false === strpos($uri , '?') && false === strpos($uri , 'index.php')){
			$uri = preg_replace("/(.html)$/", '', $uri);//去掉后缀名
			$uri = substr($uri, 1);
			$uri = explode('/',$uri);
			$m = array_shift($uri);
			$c = array_shift($uri);
			$a = array_shift($uri);
			$m = empty($m)?'Home':$m;
			define('MODULE',$m);
			$c = empty($c)?'Index':$c;
			define('CONTROLLER',$c);
			$a = empty($a)?'index':$a;
			define('ACTION',$a);
			$var = array();
			preg_replace_callback('/(\w+)\/([^\/]+)/', function($match) use(&$var){$var[$match[1]]=strip_tags($match[2]);}, implode('/',$uri));
			$_GET = array_merge($_GET,$var);
			// print_r($_GET);
		}else{
			$m = empty($_GET['m'])?'Home':$_GET['m'];
			define('MODULE',$m);
			$c = empty($_GET['c'])?'Index':$_GET['c'];
			define('CONTROLLER',$c);
			$a = empty($_GET['a'])?'index':$_GET['a'];
			define('ACTION',$a);
		}
	}

}