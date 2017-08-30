<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

class Product extends Model{

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");

	}


	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
				":idproduct"=>$this->getidproduct(),
				":desproduct"=>$this->getdesproduct(),
				":vlprice"=>$this->getvlprice(),
				":vlwidth"=>$this->getvlwidth(),
				":vlheight"=>$this->getvlheight(),
				":vllength"=>$this->getvllength(),
				":vlweight"=>$this->getvlweight(),
				":desurl"=>$this->getdesurl()
			));


		$this->setData($results[0]);
	}

	public function get($idproduct){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
				":idproduct"=>$idproduct
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

		$sql->query("CALL sp_products_delete(:idproduct)", array(
				":idproduct"=>$this->getidproduct()
			));

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

	public function checkPhoto(){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products-photo" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg"))
		{

		$url = "/res/site/img/products-photo/" . $this->getidproduct() . ".jpg";

		}else{
			$url = "/res/site/img/products-photo/padrao.jpg";
		}


	return $this->setdesphoto($url);
}

	public function getValues(){

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;
	}

	public function setPhoto($file){

		$extension = explode('.', $file["name"]);
		$extension = end($extension);

		switch ($extension) {
			case "jpg":
			case "jpeg":

				$imagem = imagecreatefromjpeg($file["tmp_name"]);
				break;
			
			case "gif":

			$imagem = imagecreatefromgif($file["tmp_name"]);
			break;

			case "png":

			$imagem = imagecreatefrompng($file["tmp_name"]);
			break;
		}

		$destino = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products-photo" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";

		imagejpeg($imagem, $destino);
		imagedestroy($imagem);

		$this->checkPhoto();
	}

}

?>