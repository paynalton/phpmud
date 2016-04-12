<?php
namespace base;
use \base\core as core;

class controller{

  protected $_accessRules=array();

  const ACCESS_GRANTED="O";
  const ACCESS_DENNIED="X";
  const ACCESS_RESTRICTED="R";


	public function run(){
		$accion=core::getAction();
    if(!method_exists($this, $accion)){
      $accion="default";
    }
    $acceso=self::ACCESS_DENNIED;
    if(is_array($this->_accessRules)&&array_key_exists($accion,$this->_accessRules)){
      $acceso=$this->_accessRules[$accion];
    }
    switch($acceso){
      case self::ACCESS_GRANTED:
        $this->$accion();
        break;
    }
	}
}
