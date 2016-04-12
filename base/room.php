<?php
namespace base;
use base\document as document;
use base\salida as salida;
class room{
  public $title="";
  public $description="";
  public $exits=array();
  public function show(){
    $document=new document();
    $document->title=$this->title;
    $info = new \ReflectionClass(get_class( $this));
    //echo (dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description);
    $document->description=file_exists((dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description))?file_get_contents((dirname(dirname(__FILE__))."/rooms/".$info->getShortName()."/".$this->description)):$this->description;
    $document->addReemplazo("/\[\[exits\]\]/i",$this->parseExits());
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
}
