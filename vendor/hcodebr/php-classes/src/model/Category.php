<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

class Category extends Model{

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT idcategory, descategory, DATE_FORMAT(dtregister, '%d/%m/%Y') as data FROM tb_categories ORDER BY descategory");

	}


	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_category_save(:idcategory, :descategory)", array(
				":idcategory"=>$this->getidcategory(),
				":descategory"=>$this->getdescategory()
			));

		$this->setData($results[0]);
	}

}

?>