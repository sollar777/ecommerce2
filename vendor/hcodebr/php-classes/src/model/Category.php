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

		Category::updateFile();

		$this->setData($results[0]);
	}

	public function get($idcategory){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", array(
				":idcategory"=>$idcategory
			));

		$this->setData($results[0]);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_category_save(:idcategory, :descategory)", array(
				":idcategory"=>$this->getidcategory(),
				":descategory"=>$this->getdescategory()
			));


		$this->setData($results[0]);
	}

	public function delete(){

		$sql = new sql();

		$sql->query("CALL sp_category_delete(:idcategory)", array(
				":idcategory"=>$this->getidcategory()
			));

		Category::updateFile();
	}

	public static function updateFile(){

		$category = Category::listAll();

		$html = [];

		foreach ($category as $row) {
			array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
			'<br/>';
		}

		file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html" , implode('', $html));
	}

}

?>