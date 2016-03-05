<?php
namespace base\excepciones;
class accesoDenegado extends \Exception{
	protected $message = 'Acceso Denegado';
	protected $code = 1;
	protected $sugerencias=array();
	public function sugerencias(){
		$sugerencias["ira"]=new sugerencias\redirect("access/login");
		return $sugerencias;
	}
}
