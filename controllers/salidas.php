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
      $fromClass=$this->_urlParams["from"];
      if(class_exists($fromClass)){
        $from=new $fromClass($this->_urlParams["idfrom"]);
      }
      $toClass=$this->_urlParams["to"];
      if(class_exists($toClass)){
        $to=new $toClass($this->_urlParams["idto"]);
      }
      if(array_key_exists($this->_urlParams["through"], $to->exits)){
          $salida=new salida($to->exits[$this->_urlParams["through"]],$from,$to);
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
