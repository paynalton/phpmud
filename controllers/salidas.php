<?php
namespace controllers;
use \base\core as core;
use \base\controller as controller;
class salidas extends controller{

    protected $_accessRules=array(
      "go"=>self::ACCESS_GRANTED
    );

    public function go(){
      $params=core::getUrlParams();
      echo "wiiii";exit;
    }
}
