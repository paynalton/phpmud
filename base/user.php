<?php
namespace base;
use base\room as room;
use base\core as core;

class user extends room{
	public $logged=false;
	public $current=false;
	public function getFromInv(){
		return null;
	}
	public function coger(room $objeto){
		if(!$this->_id){
			$this->guardar();
		}
		$query="insert into `mapa` values('".intval($this->_id)."','".intval($objeto->getId())."')";
		$db=core::getDB();
		$db->query($query);
	}
	public function guardar(){
		parent::guardar();
		if($this->current){
			$_SESSION["iduser"]=$this->_id;
		}
	}
	public function getStock(){
		$db=core::getDB();
		$query="select `m`.`contenido` as `id`,`r`.`clase` as `clase` from `mapa` as `m` left join `rooms` as `r` on `r`.`id`=`m`.`contenido` where `m`.`contenedor`=".intval($this->_id);
		$stock=array();
		if($result=$db->query($query)){
			while($r=$result->fetch_object()){
				$clase=$r->clase;
				if(class_exists($clase)){
					$stock[]=new $clase($r->id);
				}
			}
		}
		return $stock;
	}
}
