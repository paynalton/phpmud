<?php
namespace base;

class core{
	private $_currentController=null;
		private $_currentAction=null;
	static function getUser($current=true){
		$user=new user();
		if($current){
			$user->setID(	array_key_exists("iduser",$_SESSION)?intval($_SESSION["iduser"]):null);
		}
		$user->current=true;
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
		$p=explode("/",trim($_SERVER["REQUEST_URI"],"/"));
		array_shift($p);
		array_shift($p);
		array_shift($p);
		$params=array();
		for($i=0;$i<count($p);$i=$i+2){
				$params[$p[$i]]=urldecode($p[$i+1]);
		}
		return array_merge($params,$_GET,$_POST);
	}
	static function crear($clase){
		if(class_exists($clase)){
			$obj=new $clase();
			$obj->guardar();
			return $obj;
		}
	}
	static function getConfig($name){
		$path=sprintf("config/%s.ini",$name);
		if(file_exists($path)){
			return (object)parse_ini_file($path,true)[$name];
		}
	}
	static function getDB(){
		if(!array_key_exists("database",$GLOBALS)||!$GLOBALS["database"]){
			$config=core::getConfig("db");
			$GLOBALS["database"]=new \mysqli($config->host,$config->user,$config->password,$config->database);
		}
		return $GLOBALS["database"];
	}
}
