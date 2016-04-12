<?php
namespace base;
use base\room as room;
class salida {
  const EXIT_OPENED="O";
  const EXIT_LOCKED="X";
  public $status=self::EXIT_LOCKED;
  public $title="";
  public $name="";
  public $description="";
  public $errorMSG="";
  public $link="";
  public $alias="";
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
}
