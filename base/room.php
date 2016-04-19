<?php
namespace base;
use base\core as core;
use base\document as document;
use base\salida as salida;
class room{
  protected $_id;
  public $title="";
  public $description="";
  protected $_urlPath="";
  public $exits=array();
  function __construct($id=null){
    if($id){
      $this->_id=intval($id);
    }
  }
  public function show(){
    $user=core::getUser();
    $document=new document();
    $document->title=$this->title;
    $info = new \ReflectionClass(get_class( $this));
    //echo (dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description);
    $document->description=file_exists((dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description))?file_get_contents((dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description)):$this->description;
    $document->addReemplazo("/\[\[exits\]\]/i",$this->parseExits());
    $messages="";
    if(array_key_exists("message",$_SESSION)&&is_array($_SESSION["message"])&&count($_SESSION["message"])){
      while($m=array_shift($_SESSION["message"])){
        $messages.="<li>".$m."</li>";
      }
    }
    $document->addReemplazo("/\[\[messages\]\]/i",$messages);
    $inventario="";
    foreach($user->getStock() as $i){
      $inventario.="<li>".$i->title."</li>";
    }
      $document->addReemplazo("/\[\[stock\]\]/i",$inventario);
    $document->render();
  }
  public function parseExits(){
    $salidas="";
    foreach($this->exits as $e){
      $salida=new salida($e,$this);
      $salidas.=$salida->render();
    }
    return $salidas;
  }
  public function getURLPath(){
    return $this->_urlPath;
  }
  public function guardar(){
    $db=core::getDB();
    if(!$this->_id){
      $query="insert into `rooms`(`nombre`,`clase`) values('".$db->real_escape_string($this->title)."','".$db->real_escape_string(get_class($this))."')";
      $db->query($query);
      $this->_id=$db->insert_id;
    }else{
      $query="update `rooms` set `nombre`= '".$db->real_escape_string($this->title)."', clase = '".$db->real_escape_string(get_class($this))."' where `id`='".$db->real_escape_string($this->_id)."' limit 1 ";
      $db->query($query);
    }
  }
  public function getId(){
    return $this->_id;
  }
  public function setID($id){
    $this->_id=$id;
  }
}
