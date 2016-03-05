<?php
namespace base\excepciones\redirect;
class redirect{
	private $_path();
	function ira($path){
		$this->_path=$path;
	}
	public function run(){
		header("location:".$path);
	}
}
