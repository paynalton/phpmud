<?php
namespace controllers;
use \base\core as core;
use \base\controller as controller;
use \base\salida as salida;
class salidas extends controller{

    protected $_accessRules=array(
      "go"=>self::ACCESS_GRANTED
    );

    public function go(){
      $class=$this->_urlParams["from"];
      if(class_exists($class)){
        $room=new $class();
      }
      if(array_key_exists($this->_urlParams["to"], $room->exits)){
          $salida=new salida($room->exits[$this->_urlParams["to"]],$room);
      }
      
      $return=$salida->go();
      if(array_key_exists("message",$_SESSION)&&!is_array($_SESSION["message"])){
        $_SESSION["message"]=array();
      }
      $_SESSION["message"][]=$return->message;
      header("location:".$return->room->getURLPath());
      exit;
    }
}
