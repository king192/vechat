<?php
// echo 'dddddddddddddddd';
class IndexController {
	public function index(){
		echo 'okkkkkkk';
	}
	public function hello(){
		var_dump(C('server'));
		echo 'hello';
	}
	public function server(){
		var_dump($_SERVER);
	}
	public function e(){
		try{
    		throw new Sunphp\myException('Exception test');
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}