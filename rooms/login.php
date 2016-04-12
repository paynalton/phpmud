<?php
namespace rooms;
use base\room as room;
use base\salida as salida;
class login extends room{
  public $title="Portal Misterioso";
  public $description="description.html";
  public $exits=array(
    "letrero"=>array(
      "status"=>salida::EXIT_LOCKED,
      "name"=>"letrero",
      "title"=>"Mirar Letrero",
      "description"=>"ADVERTENCIA. Bienvenido a fantasía",
      "errorMSG"=>"ADVERTENCIA. Bienvenido a fantasía",
      "link"=>"\\rooms\\login",
      "alias"=>array("Mirar Letrero")
  ));
}
