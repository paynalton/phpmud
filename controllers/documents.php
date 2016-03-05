<?php
namespace controllers;
use \base\core as core;
class documents{
	public function run(){
		$c=core::getView();
		$user=core::getUser();
		if(!$user->logged&&!$c::isPublic()){
			throw new \base\excepciones\accesoDenegado();
		}
		echo "wiiiii";
	}
}
