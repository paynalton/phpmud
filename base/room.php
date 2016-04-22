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
  protected $propiedades_random=array();
  function __construct($id=null){
    if(intval($id)){
      $this->_id=intval($id);
      $db=core::getDB();
      $reflect = new \ReflectionObject($this);
      $protegidas=array();
      foreach($reflect->getProperties(\ReflectionProperty::IS_PRIVATE|\ReflectionProperty::IS_PROTECTED) as $p){
        $protegidas[]="'".$db->real_escape_string($p->name)."'";
      }
      $q="select `nombre`,`valor` from `flags` where `idroom` = ".intval($this->_id)." and `nombre` not in (".implode(",",$protegidas).")";
      if($r=$db->query($q)){
        while($i=$r->fetch_object()){
          $nombre=$i->nombre;
          $this->$nombre=$i->valor;
        }
      }
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
      $inventario.="<li>".$i->title." <a href='/player/mirar//objeto/".urlencode(get_class($i))."/id/".$i->getId()."'>Mirar</a><ul>";
      $inventario.=$i->parseExits($this,$i);

      $inventario.="</ul></li>";
    }
      $document->addReemplazo("/\[\[stock\]\]/i",$inventario);
    $document->render();
  }
  public function parseExits(room $from=null,room $to=null){
    $from=$from?$from:$this;
    $salidas="";
    foreach($this->exits as $e){
      $salida=new salida($e,$from,$to);
      $salidas.=$salida->render();
    }
    return $salidas;
  }
  public function getURLPath(){
    return $this->_urlPath;
  }
  public function recalcularPropiedades(){
    $valores=array();
    $updates=array();
    $db=core::getDB();
    foreach($this->propiedades_random as $nombre=>$rango){
      $valor=intval(rand(1,$rango));
      $valores[]="(".intval($this->_id).",'".$db->real_escape_string($nombre)."',".$valor.",1,".intval($rango).")";
    }
    foreach($this->propiedades as $nombre=>$rango){
      $valor=$rango[2];
      $valores[]="(".intval($this->_id).",'".$db->real_escape_string($nombre)."',".$valor.",".intval($rango[0]).",".intval($rango[1]).")";
    }
    $query="insert into `flags`(`idroom`,`nombre`,`valor`,`min`,`max`) values ".implode(",",$valores)." on duplicate key update `valor`=values(`valor`)";
    $db->query($query);
  }
  public function guardar(){
    $db=core::getDB();
    if(!$this->_id){
      $query="insert into `rooms`(`nombre`,`clase`) values('".$db->real_escape_string($this->title)."','".$db->real_escape_string(get_class($this))."')";
      $db->query($query);
      $this->_id=$db->insert_id;
      $this->recalcularPropiedades();
    }else{
      $query="update `rooms` set `nombre`= '".$db->real_escape_string($this->title)."', clase = '".$db->real_escape_string(get_class($this))."' where `id`='".$db->real_escape_string($this->_id)."' limit 1 ";
      $db->query($query);
    }
  }
  public function setPropiedad($nombre,$valor){
    $db=core::getDB();
    $query="update `flags` set `valor`=".intval($valor)." where `nombre`='".$db->real_escape_string($nombre)."' and `idroom`=".intval($this->_id)." limit 1";
    $db->query($query);
  }
  public function getId(){
    return $this->_id;
  }
  public function setID($id){
    $this->_id=$id;
  }
}
