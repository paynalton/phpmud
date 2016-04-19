<?php
namespace base;
use base\room as room;
use \base\core as core;
class salida {
  const EXIT_OPENED="O";
  const EXIT_LOCKED="X";

  const KEY_CONDICION_NOTIENEOBJETO=1;

  const ACCION_CREAROBJETO=1;

  public $status=self::EXIT_LOCKED;
  public $title="";
  public $name="";
  public $description="";
  public $errorMSG="";
  public $link="";
  public $alias="";
  public $keys=array();
  public $template="views/salida.html";
  protected $_room=null;
  public function __construct($params, room $room){
    $this->_room=$room;
    foreach($params as $k=>$v){
      if(property_exists($this, $k)){
        $this->$k=$v;
      }
    }
  }
  public function render(){
    $temp=file_get_contents($this->template);
    $room=urlencode(get_class( $this->_room));
    $reemplazos=array(
      "/\[\[title\]\]/i"=>$this->title,
      "/\[\[description\]\]/i"=>$this->description,
      "/\[\[name\]\]/i"=>$this->name,
      "/\[\[room\]\]/i"=>$room
    );
    return preg_replace(array_keys($reemplazos),$reemplazos,$temp);
  }
  public function go(){
    if($this->status==self::EXIT_LOCKED){
      $open=false;
      $messages=array();
      foreach($this->keys as $k){
        if($this->puedeAbrir($k)){
          $messages[]=$this->pasar($k);
          $open=true;
        }
      }
      return (object)array("room"=>$this->_room,"message"=>implode("",$messages));
    }
  }
  public function pasar($key){
    $messages=array();
    foreach($key["acciones"] as $accion){
      switch($accion["accion"]){
        case salida::ACCION_CREAROBJETO:
          $objeto=core::crear($accion["clase"]);
          if($objeto && $accion["recoger"]){
            $user=core::getUser();
            $user->coger($objeto);
            $messages[]=$accion["sucessMessage"];
          }
        break;
      }
    }
    return implode("",$messages);
  }
  public function puedeAbrir($key){
    $pasa=0;
    foreach($key["condiciones"] as $condicion=>$operador){
      switch($condicion){
        case salida::KEY_CONDICION_NOTIENEOBJETO:
          $user=core::getUser();
          if($user->getFromInv($operador)==null){
            $pasa++;
          }
        break;
      }

    }
    return $pasa==count($key["condiciones"]);
  }
}
