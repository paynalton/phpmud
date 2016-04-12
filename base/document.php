<?php
namespace base;
class document{
  public $title="";
  public $description="";
  public $sitename="PHPMud";
  public $template="default.html";
  public $templatesBase=array("views");
  public $reemplazos=array();
  public function addReemplazo($k,$v){
    $this->_reemplazos[$k]=$v;
  }
  public function render(){
    $path=$this->templatesBase;
    $path[]=$this->template;
    $document=file_get_contents(implode("/", $path));
    $reemplazos=array(
      "/\[\[title\]\]/i"=>$this->title,
      "/\[\[sitename\]\]/i"=>$this->sitename,
      "/\[\[description\]\]/i"=>$this->description
    );
    $reemplazos=array_merge($reemplazos,$this->_reemplazos);
    $document=preg_replace(array_keys($reemplazos),$reemplazos,$document);
    echo $document;
  }
}
