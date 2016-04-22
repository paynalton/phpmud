<?php
namespace controllers;
use \base\core as core;
use \base\controller as controller;

class player extends controller{
  protected $_accessRules=array(
    "mirar"=>self::ACCESS_GRANTED
  );
  public function mirar(){
    $params=(object)core::getUrlParams();
    $clase=$params->objeto;
    if(class_exists($clase)){
      $objeto=new $clase($params->id);
    }
    $descripcion="";

    if(method_exists($objeto, "description")){
      $descripcion=$objeto->description();
    }else{
      $descripcion=$objeto->description;
    }
    $_SESSION["message"][]=$descripcion;
    header("location:".$_SERVER["HTTP_REFERER"]);
    exit;
  }
}
