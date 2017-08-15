<?php

namespace Hcode;

class Model{

	private $values = [];

	public function __call($nome, $args){

		$method = substr($nome, 0, 3);
		$fieldName = substr($nome, 3, strlen($nome));


		switch($method){

			case "get":
				return $this->values[$fieldName];
				break;

			case "set":
				$this->values[$fieldName] = $args[0];
				break;
		}
	}

	public function setData($data = array()){

		foreach ($data as $key => $value) {
			$this->{"set".$key}($value);
		}
	}

	public function getValues(){
		return $this->values;
	}

}


?>