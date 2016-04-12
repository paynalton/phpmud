<?php
namespace controllers;
use \base\core as core;
use \base\controller as controller;

class access extends controller{
  protected $_accessRules=array(
    "login"=>self::ACCESS_GRANTED
  );
  public function login(){
    $room=core::getRoom("rooms\\login");
    $room->show();
  }
}
