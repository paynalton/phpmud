<?php
namespace base\excepciones\sugerencias;
class redirect{
	private $_path;
	function __construct($path){
		$this->_path=$path;
	}
	public function run(){
		header("HTTP/1.1 403 Forbidden");
		header("Location: ".$this->_path);
		exit;
	}
}
