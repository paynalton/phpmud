<?php
namespace PHPMUD;
use \base\core as core;

error_reporting(E_ALL);
ini_set('display_errors', '1');


spl_autoload_register(function ($clase) {
	$path=str_replace("\\","/",ltrim($clase,"\\")).".php";
    if(file_exists($path)){
		include_once $path;
	}
});

session_start();
$core=new core();

try{
	$controller=core::getController();
	$controller->run();
}catch(\Exception $e){
	$sugerencias=$e->sugerencias();
	if(count($sugerencias)){
		$sugerencia=array_shift($sugerencias);
		$sugerencia->run();
	}
}
