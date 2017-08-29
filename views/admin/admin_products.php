<?php

	use \Slim\slim;
	use \Hcode\PageAdmin;
	use \Hcode\Model\User;
	use \Hcode\Model\Product;

	$app->get('/admin/products', function(){

	User::verifyLogin();

	$product = Product::listAll();

	$page = new PageAdmin();
	$page->setTpl("products", array(
			"product"=>$product
		));

});

$app->get('/admin/products/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("products-create");

});

$app->post('/admin/products/create', function(){

	User::verifyLogin();

	$product = new Product();
	$product->setData($_POST);
	$product->save();


	header("Location: /admin/products");
	exit;

});


?>