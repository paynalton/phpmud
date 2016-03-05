<?php
namespace base;

class core{
	static function getUser(){
		$user=new user();
		return $user;
	}
	static function getController(){
		return new \controllers\documents();
	}
	static function getView(){
		return '\views\index';
	}
}
