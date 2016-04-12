<?php
namespace base;

class core{
	private $_currentController=null;
		private $_currentAction=null;
	static function getUser(){
		$user=new user();
		return $user;
	}
	static function getController(){
		$class="\\controllers\\".((is_array($_GET)&&array_key_exists("controlador",$_GET))?$_GET["controlador"]:"default");
		if(class_exists($class)){
			return new $class();
		}else{
			throw new excepciones\accesoDenegado();
		}
	}
	static function getAction(){
		return is_array($_GET)&&array_key_exists("accion",$_GET)?$_GET["accion"]:"default";
	}
	static function getView(){

		return '\views\index';
	}
	static function getRoom($name){
		if(class_exists($name)){
			return new $name();
		}
	}
	static function getUrlParams(){
		$params=array_merge($_GET,$_POST);
		print_r($_SERVER);
		exit;
	}
}
